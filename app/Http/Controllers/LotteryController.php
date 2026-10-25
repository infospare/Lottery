<?php

namespace App\Http\Controllers;

use App\Models\Lottery;
use App\Models\LotteryDraw;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LotteryController extends Controller
{
    public function index()
    {
        $lotteries = Lottery::orderBy('name')->get(['id', 'name']);

        return response()->json([
            'success' => true,
            'data' => $lotteries,
        ]);
    }

    public function store(Request $request)
    {
        $request->merge([
            'name' => strtoupper(trim((string) $request->input('name', ''))),
        ]);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Lottery::class, 'name'),
            ],
        ]);

        $lottery = Lottery::create([
            'name' => $validated['name'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lottery added successfully.',
            'data' => $lottery,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $lottery = Lottery::findOrFail($id);

        $request->merge([
            'name' => strtoupper(trim((string) $request->input('name', ''))),
        ]);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Lottery::class, 'name')->ignore($lottery->id),
            ],
        ]);

        $oldName = $lottery->name;
        $newName = $validated['name'];

        $lottery->update(['name' => $newName]);

        if ($oldName !== $newName) {
            LotteryDraw::where('lottery_name', $oldName)->update([
                'lottery_name' => $newName,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Lottery updated successfully.',
            'data' => $lottery->fresh(),
        ]);
    }

    public function destroy($id)
    {
        $lottery = Lottery::findOrFail($id);
        $lottery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lottery removed successfully.',
        ]);
    }
}
