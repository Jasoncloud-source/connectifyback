<?php
namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CommunityController extends Controller
{
    public function getPopularCommunities(): JsonResponse
    {
        $communities = DB::table('communities')
            ->orderBy('popularity_score', 'desc')
            ->get();

        return response()->json($communities);
    }
}