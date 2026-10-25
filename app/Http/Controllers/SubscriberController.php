<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubscriberController extends Controller
{
    public function index()
    {
        $subscribers = Subscriber::orderBy('expiry_date')
            ->orderBy('id')
            ->get();

        return view('subscribers.subscriber', compact('subscribers'));
    }

    public function export()
    {
        $subscribers = Subscriber::orderBy('expiry_date')
            ->orderBy('id')
            ->get();

        $filename = 'Subscribers_' . now()->format('Y-m-d') . '.xls';

        $callback = function () use ($subscribers) {
            echo "\xEF\xBB\xBF";
            echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
            echo '<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head><body>';
            echo '<table border="1">';
            echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Subscriber Name</th>';
            echo '<th>Phone</th>';
            echo '<th>Registration ID</th>';
            echo '<th>Registration Key</th>';
            echo '<th>Expiry Date</th>';
            echo '<th>Notes</th>';
            echo '</tr>';

            foreach ($subscribers as $subscriber) {
                echo '<tr>';
                echo '<td>' . e($subscriber->id) . '</td>';
                echo '<td>' . e($subscriber->subscriber_name) . '</td>';
                echo '<td>' . e($subscriber->phone ?: '') . '</td>';
                echo '<td>' . e($subscriber->registration_id ?: '') . '</td>';
                echo '<td>' . e($subscriber->registration_key) . '</td>';
                echo '<td>' . e($subscriber->formatted_expiry_date) . '</td>';
                echo '<td>' . e($subscriber->notes ?: '') . '</td>';
                echo '</tr>';
            }

            echo '</table></body></html>';
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateSubscriber($request);

        $subscriber = Subscriber::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Subscriber added successfully.',
                'data' => $this->formatSubscriber($subscriber),
            ], 201);
        }

        return redirect()
            ->route('subscribers.index')
            ->with('success', 'Subscriber added successfully.');
    }

    public function update(Request $request, $id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $validated = $this->validateSubscriber($request, $subscriber->id);

        $subscriber->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Subscriber updated successfully.',
                'data' => $this->formatSubscriber($subscriber->fresh()),
            ]);
        }

        return redirect()
            ->route('subscribers.index')
            ->with('success', 'Subscriber updated successfully.');
    }

    public function destroy(Request $request, $id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Subscriber removed successfully.',
            ]);
        }

        return redirect()
            ->route('subscribers.index')
            ->with('success', 'Subscriber removed successfully.');
    }

    private function validateSubscriber(Request $request, ?int $ignoreId = null): array
    {
        $validated = $request->validate([
            'subscriber_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:100',
            'registration_id' => 'nullable|string|max:255',
            'registration_key' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Subscriber::class, 'registration_key')->ignore($ignoreId),
            ],
            'expiry_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $validated['subscriber_name'] = trim($validated['subscriber_name']);
        $validated['phone'] = isset($validated['phone']) ? trim($validated['phone']) : null;
        $validated['registration_id'] = isset($validated['registration_id']) ? trim($validated['registration_id']) : null;
        $validated['registration_key'] = trim($validated['registration_key']);
        $validated['notes'] = isset($validated['notes']) ? trim($validated['notes']) : null;

        if ($validated['phone'] === '') {
            $validated['phone'] = null;
        }
        if ($validated['registration_id'] === '') {
            $validated['registration_id'] = null;
        }
        if ($validated['notes'] === '') {
            $validated['notes'] = null;
        }

        return $validated;
    }

    private function formatSubscriber(Subscriber $subscriber): array
    {
        return [
            'id' => $subscriber->id,
            'subscriber_name' => $subscriber->subscriber_name,
            'phone' => $subscriber->phone,
            'registration_id' => $subscriber->registration_id,
            'registration_key' => $subscriber->registration_key,
            'expiry_date' => $subscriber->expiry_date->format('Y-m-d'),
            'expiry_date_formatted' => $subscriber->formatted_expiry_date,
            'notes' => $subscriber->notes,
            'is_expired' => $subscriber->is_expired,
        ];
    }
}
