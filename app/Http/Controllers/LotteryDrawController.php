<?php

namespace App\Http\Controllers;

use App\Models\Lottery;
use App\Models\LotteryDraw;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LotteryDrawController extends Controller
{
    public function index(Request $request)
    {
        $access = $this->resolveResultsAccess($request);

        if ($access['status'] !== 'ok') {
            return response()
                ->view('lottery.results-denied', [
                    'message' => $access['message'],
                    'showPayment' => !empty($access['showPayment']),
                ])
                ->header('Content-Type', 'text/html; charset=utf-8')
                ->header('X-UA-Compatible', 'IE=8')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache');
        }

        $draws = LotteryDraw::orderByDesc('draw_date')
            ->orderByDesc('id')
            ->paginate(14)
            ->withQueryString();

        $subscriber = $access['subscriber'] ?? null;
        $expiringSoon = $subscriber && $subscriber->is_expiring_soon;

        $response = response()
            ->view('lottery.results', [
                'draws' => $draws,
                'expiringSoon' => $expiringSoon,
                'subscriber' => $subscriber,
            ])
            ->header('Content-Type', 'text/html; charset=utf-8')
            ->header('X-UA-Compatible', 'IE=8')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache');

        $rk = trim((string) $request->session()->get('lottery_results_rk', ''));
        if ($rk !== '') {
            $response->cookie('lottery_rk', $rk, 60 * 24 * 365, '/', null, false, false);
        }

        return $response;
    }

    public function manage()
    {
        $draws = LotteryDraw::orderByDesc('draw_date')
            ->orderByDesc('id')
            ->paginate(30);

        $lotteries = Lottery::orderBy('name')->get();

        $nextDrawCodes = [];
        foreach ($lotteries as $lottery) {
            $nextDrawCodes[$lottery->name] = LotteryDraw::nextDrawCodeFor($lottery->name);
        }

        return view('lottery.manage', compact('draws', 'lotteries', 'nextDrawCodes'));
    }

    public function list()
    {
        $draws = LotteryDraw::orderByDesc('draw_date')
            ->orderByDesc('id')
            ->get()
            ->map(fn (LotteryDraw $draw) => $this->formatDraw($draw));

        return response()->json([
            'success' => true,
            'data' => $draws,
        ]);
    }

    public function version(Request $request)
    {
        $access = $this->resolveResultsAccess($request);
        if ($access['status'] !== 'ok') {
            return response()->json(['message' => $access['message'] ?? 'Unauthorized'], 403);
        }

        $stats = LotteryDraw::query()
            ->selectRaw('COUNT(*) as total, COALESCE(MAX(id), 0) as max_id, MAX(updated_at) as max_updated')
            ->first();

        $version = ((int) ($stats->max_id ?? 0))
            . '-' . ((int) ($stats->total ?? 0))
            . '-' . strtotime((string) ($stats->max_updated ?? '1970-01-01'));

        return response()
            ->json(['version' => $version])
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache');
    }

    public function show($id)
    {
        $draw = LotteryDraw::findOrFail($id);

        return view('lottery.show', compact('draw'));
    }

    public function showApi($id)
    {
        $draw = LotteryDraw::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $this->formatDraw($draw, includeResults: true),
        ]);
    }

    public function download($id)
    {
        $draw = LotteryDraw::findOrFail($id);
        $filePath = $draw->resolveFilePath();

        if (!$filePath) {
            abort(404, 'Result file not found for this draw.');
        }

        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $downloadName = $draw->original_filename
            ?: Str::slug($draw->lottery_name . '-' . $draw->draw_code) . '.' . $extension;

        // Old IE needs a simple ASCII filename in Content-Disposition
        $safeName = preg_replace('/[^A-Za-z0-9._-]/', '_', $downloadName);
        if ($safeName === '' || $safeName === '_' || $safeName === '.') {
            $safeName = 'result.' . ($extension ?: 'bin');
        }

        $mimeTypes = [
            'pdf' => 'application/pdf',
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
        ];
        $contentType = $mimeTypes[$extension] ?? 'application/octet-stream';

        return response()->download($filePath, $safeName, [
            'Content-Type' => $contentType,
            'Content-Disposition' => 'attachment; filename="' . $safeName . '"',
            'Cache-Control' => 'private, must-revalidate',
            'Pragma' => 'public',
            'Expires' => '0',
        ]);
    }

    public function upload(Request $request)
    {
        $validated = $request->validate([
            'lottery_name' => 'required|string|max:255',
            'draw_code' => 'required|string|max:50',
            'draw_date' => 'required|date',
            'status' => 'required|string|in:Live,official,-',
            'description' => 'nullable|string|max:65000',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,txt,htm,html|max:10240',
            'results' => 'nullable|json',
        ]);

        $existing = LotteryDraw::where('lottery_name', $validated['lottery_name'])
            ->where('draw_code', $validated['draw_code'])
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'A draw with this lottery name and draw code already exists.',
            ], 422);
        }

        try {
            $filePath = null;
            $originalFilename = null;

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $storedName = Str::slug($validated['lottery_name'] . '-' . $validated['draw_code'])
                    . '-' . time()
                    . '.' . $extension;

                $file->storeAs('lottery-results', $storedName, 'public');
                $filePath = 'lottery-results/' . $storedName;
                $originalFilename = $file->getClientOriginalName();
            }

            $results = null;
            if (!empty($validated['results'])) {
                $results = json_decode($validated['results'], true);
            }

            $draw = LotteryDraw::create([
                'lottery_name' => strtoupper(trim($validated['lottery_name'])),
                'draw_code' => strtoupper(trim($validated['draw_code'])),
                'draw_date' => $validated['draw_date'],
                'status' => $validated['status'],
                'description' => isset($validated['description']) ? trim($validated['description']) : null,
                'file_path' => $filePath,
                'original_filename' => $originalFilename,
                'results' => $results,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Lottery result uploaded successfully.',
                'data' => $this->formatDraw($draw, includeResults: true),
            ], 201);
        } catch (\Exception $e) {
            Log::error('Lottery result upload failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to upload lottery result: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        $draw = LotteryDraw::find($id);

        if (!$draw) {
            return back()->with('error', 'Lottery result not found.');
        }

        $label = $draw->display_label;

        if ($draw->file_path && Storage::disk('public')->exists($draw->file_path)) {
            Storage::disk('public')->delete($draw->file_path);
        }

        $draw->delete();

        return back()->with('success', "Removed result: {$label}");
    }

    private function formatDraw(LotteryDraw $draw, bool $includeResults = false): array
    {
        $data = [
            'id' => $draw->id,
            'lottery_name' => $draw->lottery_name,
            'draw_code' => $draw->draw_code,
            'label' => $draw->display_label,
            'description' => $draw->description,
            'draw_date' => $draw->draw_date->format('Y-m-d'),
            'draw_date_formatted' => $draw->formatted_draw_date,
            'status' => $draw->status ?: 'Live',
            'has_file' => (bool) $draw->file_path,
            'view_url' => route('lottery.results.show', $draw->id),
            'download_url' => route('lottery.results.download', $draw->id),
            'api_url' => route('lottery.results.show.api', $draw->id),
        ];

        if ($includeResults) {
            $data['results'] = $draw->results;
            $data['original_filename'] = $draw->original_filename;
        }

        return $data;
    }

    /**
     * Registration key must come from the VB6 app (lblRegKey.Caption)
     * as ?rk= on the WebAll WebBrowser URL.
     *
     * @return array{status: string, message?: string, subscriber?: Subscriber|null}
     */
    private function resolveResultsAccess(Request $request): array
    {
        if ($request->user()) {
            return ['status' => 'ok', 'subscriber' => null];
        }

        $rk = trim((string) $request->query('rk', ''));

        if ($rk === '') {
            $rk = trim((string) $request->cookie('lottery_rk', ''));
        }

        if ($rk === '') {
            $rk = trim((string) $request->session()->get('lottery_results_rk', ''));
        }

        if ($rk === '') {
            return [
                'status' => 'denied',
                'message' => 'Registration missing. Open results from the Results software. Please contact support at support@infospare.com., Phone: 7559022205',
            ];
        }

        $subscriber = Subscriber::where('registration_key', $rk)->first();

        if (!$subscriber) {
            $request->session()->forget('lottery_results_rk');

            return [
                'status' => 'denied',
                'message' => 'No subscriber found for this registration. Please contact support at support@infospare.com., Phone: 7559022205',
            ];
        }

        if ($subscriber->is_expired) {
            $request->session()->forget('lottery_results_rk');

            return [
                'status' => 'denied',
                'showPayment' => true,
                'message' => 'Subscription expired on ' . $subscriber->formatted_expiry_date . '.' . ' Please contact support at support@infospare.com., Phone: 7559022205',
            ];
        }

        $request->session()->put('lottery_results_rk', $rk);

        return [
            'status' => 'ok',
            'subscriber' => $subscriber,
        ];
    }
}
