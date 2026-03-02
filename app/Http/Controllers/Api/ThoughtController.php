<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Thought;

class ThoughtController extends Controller
{
    public function current()
    {
        $thought = Thought::where('active', true)
            ->latest()
            ->first();

        return response()->json([
            'content' => $thought ? $thought->content : 'Just out here building cool stuff.',
        ]);
    }
}
