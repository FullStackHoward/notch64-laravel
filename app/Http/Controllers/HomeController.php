<?php

namespace App\Http\Controllers;

use App\Models\LinkTile;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function index()
    {
        /*
         * Rendered server-side rather than fetched from /api like the stats and
         * Spotify sections: these are the site's primary outbound links, so they
         * need to be in the initial HTML for search engines and must not flash
         * in after paint.
         */
        $tiles = LinkTile::query()
            ->active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->groupBy('section');

        return view('home', [
            'mainTiles' => $tiles->get(LinkTile::SECTION_MAIN) ?? new Collection,
            'communityTiles' => $tiles->get(LinkTile::SECTION_COMMUNITY) ?? new Collection,
            'socialTiles' => $tiles->get(LinkTile::SECTION_SOCIAL) ?? new Collection,
        ]);
    }
}
