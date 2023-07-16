<?php

namespace App\Http\Controllers;

use App\Models\Screening;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the incoming search request.
     *
     * @param  Request  $request The search request.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function __invoke(Request $request)
    {
        $searchTerm = $request->search;

        return Screening::whereHas('movie', function ($query) use ($searchTerm) {
            $query->where('title', 'like', '%'.$searchTerm.'%')
                ->orWhere('genre', 'like', '%'.$searchTerm.'%');
        })->get();
    }
}
