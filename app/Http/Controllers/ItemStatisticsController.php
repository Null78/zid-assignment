<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemStatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return [
            "total" => Item::count(),
            "average_price" => Item::average('price'),
            "highest_website" => Item::all()
                ->groupBy(fn($item) => parse_url($item->url, PHP_URL_HOST))
                ->map(fn($items) => $items->sum('price'))
                ->sortDesc()
                ->keys()
                ->first(),
            "current_month_prices" => Item::currentMonth()->sum('price'),
        ];
    }
}
