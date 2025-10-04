<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trader;
use Illuminate\Support\Facades\Auth;

class TraderController extends Controller
{
    public function index()
    {
    $traders = Trader::where('broker_email', Auth::user()->email)->get();
        return view('traders.index', compact('traders'));
    }

    public function create()
    {
        return view('traders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'trader_id' => 'required',
            'trader_name' => 'required',
            'stock_name' => 'required',
            'current_stock_value' => 'required|numeric',
            'own_money' => 'required|numeric',
            'borrowed_money' => 'required|numeric',
            'margin_threshold' => 'required|numeric',
            'current_stock_count' => 'required|integer',
        ]);
        // Optionally, validate uniqueness of trader_id + stock_name
        if (Trader::where('trader_id', $request->trader_id)->where('stock_name', $request->stock_name)->exists()) {
            return back()->withErrors(['trader_id' => 'This Trader ID already exists for the selected stock.']);
        }
        $data = $request->only([
            'trader_id', 'trader_name', 'stock_name', 'current_stock_value',
            'own_money', 'borrowed_money', 'margin_threshold', 'current_stock_count'
        ]);
        $data['broker_name'] = Auth::user()->name;
        $data['broker_email'] = Auth::user()->email;
        $data['user_id'] = Auth::user()->id;
        // Compute and store additional fields
        $data['initial_total_investment'] = $data['own_money'] + $data['borrowed_money'];
        $data['current_total_value'] = $data['current_stock_value'] * $data['current_stock_count'];
        $data['equity'] = $data['current_total_value'] - $data['borrowed_money'];
        $ratio = $data['current_total_value'] > 0 ? ($data['equity'] / $data['current_total_value']) * 100 : 0;
        $trader = new Trader($data);
        $data['status'] = $trader->status; // use computed accessor
        $trader->fill($data)->save();
        return redirect()->route('traders.index')->with('success', 'Trader added successfully.');
    }

    public function edit(Trader $trader)
    {
        return view('traders.edit', compact('trader'));
    }

    public function update(Request $request, Trader $trader)
    {
        $request->validate([
            'trader_id' => 'required',
            'trader_name' => 'required',
            'stock_name' => 'required',
            'current_stock_value' => 'required|numeric',
            'own_money' => 'required|numeric',
            'borrowed_money' => 'required|numeric',
            'margin_threshold' => 'required|numeric',
            'current_stock_count' => 'required|integer',
        ]);
        // Optionally, validate uniqueness of trader_id + stock_name (excluding current)
        if (Trader::where('trader_id', $request->trader_id)->where('stock_name', $request->stock_name)->where('_id', '!=', $trader->_id)->exists()) {
            return back()->withErrors(['trader_id' => 'This Trader ID already exists for the selected stock.']);
        }
        $data = $request->only([
            'trader_id', 'trader_name', 'stock_name', 'current_stock_value',
            'own_money', 'borrowed_money', 'margin_threshold', 'current_stock_count'
        ]);
        $data['broker_name'] = Auth::user()->name;
        $data['broker_email'] = Auth::user()->email;
        // Compute and store additional fields
        $data['initial_total_investment'] = $data['own_money'] + $data['borrowed_money'];
        $data['current_total_value'] = $data['current_stock_value'] * $data['current_stock_count'];
        $data['equity'] = $data['current_total_value'] - $data['borrowed_money'];
        $ratio = $data['current_total_value'] > 0 ? ($data['equity'] / $data['current_total_value']) * 100 : 0;
        $trader->fill($data);
        $data['status'] = $trader->status; // use computed accessor
        $trader->update($data);
        return redirect()->route('traders.index')->with('success', 'Trader updated successfully.');
    }

    public function destroy(Trader $trader)
    {
        $trader->delete();
        return redirect()->route('traders.index')->with('success', 'Trader deleted successfully.');
    }
}
