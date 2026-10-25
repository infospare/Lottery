<?php

namespace App\Http\Controllers;

use App\Models\DownloadCount;
use App\Models\Rating;
use App\Models\SoftwareDownloadCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DownloadController extends Controller
{
    public function index()
    {
        $softwareDownloads = SoftwareDownloadCount::with('ratings')->orderBy('id', 'asc')->get();
        
        // Get user identifier to check if they've already rated
        $userIdentifier = request()->ip() . '_' . session()->getId();
        $userRatings = Rating::where('user_identifier', $userIdentifier)
            ->pluck('rating', 'software_download_count_id')
            ->toArray();
        
        // Log to verify index is being called
        Log::info("Downloads index page accessed, found " . $softwareDownloads->count() . " software items");
        
        return view('downloads', compact('softwareDownloads', 'userRatings'));
    }
    
    public function getDownloadCount($id)
    {
        $software = SoftwareDownloadCount::findOrFail($id);
        
        return response()->json([
            'success' => true,
            'download_count' => $software->download_count
        ]);
    }
    
    public function incrementDownload($id)
    {
        Log::info("incrementDownload method called with ID: {$id}");
        
        try {
            // Increment the download count directly in the database
            $updated = DB::connection('infospare')
                ->table('software_download_counts')
                ->where('id', $id)
                ->increment('download_count');
            
            if ($updated === 0) {
                Log::warning("Failed to increment download count for software ID: {$id} - No rows updated");
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to increment download count'
                ], 400);
            }
            
            // Get the updated count
            $newCount = DB::connection('infospare')
                ->table('software_download_counts')
                ->where('id', $id)
                ->value('download_count');
            
            Log::info("Download count incremented for software ID: {$id}, new count: {$newCount}");
            
            return response()->json([
                'success' => true,
                'download_count' => $newCount
            ]);
        } catch (\Exception $e) {
            Log::error("Error incrementing download count for software ID: {$id}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error incrementing download count: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function downloadFile($id, $type = 'exe')
    {
        $type = in_array($type, ['exe', 'zip'], true) ? $type : 'exe';

        $logMessage = date('Y-m-d H:i:s') . " - downloadFile method called with ID: {$id}, type: {$type}\n";
        @file_put_contents(storage_path('logs/download_debug.log'), $logMessage, FILE_APPEND);
        Log::info("downloadFile method called with ID: {$id}, type: {$type}");

        try {
            $software = SoftwareDownloadCount::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Software not found: {$id}");
            abort(404, 'Software with ID ' . $id . ' not found in database');
        }

        $oldCount = $software->download_count;
        Log::info("Download requested for software ID: {$id}, current count: {$oldCount}");

        try {
            $updated = DB::connection('infospare')
                ->table('software_download_counts')
                ->where('id', $id)
                ->increment('download_count');

            if ($updated === 0) {
                Log::warning("Failed to increment download count for software ID: {$id} - No rows updated");
            } else {
                $newCount = DB::connection('infospare')
                    ->table('software_download_counts')
                    ->where('id', $id)
                    ->value('download_count');

                Log::info("Download count incremented for software ID: {$id}, old: {$oldCount}, new: {$newCount}, rows updated: {$updated}");
            }
        } catch (\Exception $e) {
            Log::error("Error incrementing download count for software ID: {$id}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        $software->refresh();

        if ($type === 'zip') {
            $originalFilePath = $software->zip_file_path
                ?: preg_replace('/\.[^.]+$/', '.zip', $software->file_path);
        } else {
            $originalFilePath = $software->file_path;
        }

        if (!$originalFilePath) {
            abort(404, strtoupper($type) . ' file path not configured for this software.');
        }

        $filePath = null;
        $possiblePaths = [];

        if (str_starts_with($originalFilePath, '/') || str_starts_with($originalFilePath, storage_path()) || str_starts_with($originalFilePath, base_path())) {
            $filePath = $originalFilePath;
        } else {
            $possiblePaths = [
                public_path($originalFilePath),
                public_path('exes/' . $originalFilePath),
                public_path('files/' . $originalFilePath),
                public_path('downloads/' . $originalFilePath),
                public_path('zips/' . $originalFilePath),
            ];

            foreach ($possiblePaths as $path) {
                if (file_exists($path)) {
                    $filePath = $path;
                    break;
                }
            }
        }

        if (!$filePath || !file_exists($filePath)) {
            $checkedPaths = $filePath ? [$filePath] : $possiblePaths;
            abort(404, 'File not found. Original path: ' . $originalFilePath . '. Checked: ' . implode(', ', $checkedPaths));
        }

        $downloadName = $software->name . '_setup.' . ($type === 'zip' ? 'zip' : 'exe');

        return response()->download($filePath, $downloadName);
    }
    
    public function incrementUserGuideDownload()
    {
        $downloadCount = DownloadCount::firstOrCreate([], ['count' => 0]);
        $downloadCount->increment('count');
        
        return response()->json(['success' => true, 'count' => $downloadCount->count]);
    }
    
    public function submitRating(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);
        
        try {
            $software = SoftwareDownloadCount::findOrFail($id);
            
            // Get user identifier (IP address or session ID)
            $userIdentifier = $request->ip() . '_' . session()->getId();
            
            // Check if user already rated this software
            $existingRating = Rating::where('software_download_count_id', $id)
                ->where('user_identifier', $userIdentifier)
                ->first();
            
            if ($existingRating) {
                // Update existing rating
                $existingRating->update(['rating' => $request->rating]);
                $message = 'Rating updated successfully';
            } else {
                // Create new rating
                Rating::create([
                    'software_download_count_id' => $id,
                    'user_identifier' => $userIdentifier,
                    'rating' => $request->rating,
                ]);
                $message = 'Rating submitted successfully';
            }
            
            // Get updated average rating
            $software->refresh();
            $averageRating = $software->average_rating;
            $ratingCount = $software->rating_count;
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'average_rating' => $averageRating,
                'rating_count' => $ratingCount,
            ]);
        } catch (\Exception $e) {
            Log::error("Error submitting rating for software ID: {$id}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error submitting rating: ' . $e->getMessage()
            ], 500);
        }
    }
}
