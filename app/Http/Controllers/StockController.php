<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trader;

class StockController extends Controller
{
    public function updatePrice(Request $request)
    {
        $request->validate([
            'stock_name' => 'required',
            'new_price' => 'required|numeric|min:0',
        ]);

        // Update all traders with this stock name
        Trader::where('stock_name', $request->stock_name)
            ->update(['current_stock_value' => $request->new_price]);

        return redirect()->back()->with('success', 'Stock price updated successfully.');
    }
}
