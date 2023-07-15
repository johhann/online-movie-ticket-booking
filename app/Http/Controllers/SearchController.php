<?php

namespace App\Http\Controllers;

use App\Models\Screening;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return Screening::whereHas('movie', function ($movie) use ($request) {
            $movie->where('title', 'like', '%'.$request->search.'%')->orWhere('genre', 'like', '%'.$request->search.'%');
        })->get();
    }
}
