<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class CommunityController extends Controller
{
    /**
     * Return a list of popular communities.
     */
    public function getPopularCommunities(): JsonResponse
    {
        try {
            // Check if the column exists before ordering by it
            if (Schema::hasColumn('communities', 'popularity_score')) {
                $communities = DB::table('communities')
                    ->orderBy('popularity_score', 'desc')
                    ->take(10)
                    ->get();
            } else {
                Log::warning('Column "popularity_score" does not exist on communities table. Using fallback sort.');

                $communities = DB::table('communities')
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();
            }

            return response()->json($communities);
        } catch (\Exception $e) {
            Log::error('Error fetching popular communities: ' . $e->getMessage());

            return response()->json([
                'message' => 'Server error while fetching popular communities.'
            ], 500);
        }
    }
}
