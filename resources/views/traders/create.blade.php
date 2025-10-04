@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gradient-to-br from-blue-50 to-gray-100 py-8">
    <div class="w-full max-w-2xl bg-white shadow-xl rounded-2xl p-10 border border-blue-100">
        <h2 class="text-3xl font-extrabold mb-8 text-blue-800 text-center tracking-tight">Add Trader</h2>
        <form action="{{ route('traders.store') }}" method="POST" class="space-y-6">
            @csrf
    @csrf
    @php
        $allTraders = \App\Models\Trader::where('broker_email', Auth::user()->email)->get();
        $traderIds = $allTraders->pluck('trader_id')->unique();
        $traderNames = $allTraders->pluck('trader_name')->unique();
        $stockNames = $allTraders->pluck('stock_name')->unique();
    @endphp
            <div>
                <label class="block text-blue-700 font-semibold mb-2">Trader ID</label>
                <select name="trader_id" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" required>
                    <option value="">Select Trader ID</option>
                    @foreach($traderIds as $id)
                        <option value="{{ $id }}">{{ $id }}</option>
                    @endforeach
                </select>
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-xs text-gray-500">Or enter a new Trader ID:</span>
                    <input type="text" name="trader_id" class="flex-1 rounded-lg border-gray-300 px-2 py-1 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" placeholder="New Trader ID">
                </div>
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-2">Trader Name</label>
                <select name="trader_name" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" required>
                    <option value="">Select Trader Name</option>
                    @foreach($traderNames as $name)
                        <option value="{{ $name }}">{{ $name }}</option>
                    @endforeach
                </select>
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-xs text-gray-500">Or enter a new Trader Name:</span>
                    <input type="text" name="trader_name" class="flex-1 rounded-lg border-gray-300 px-2 py-1 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" placeholder="New Trader Name">
                </div>
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-2">Stock Name</label>
                <select name="stock_name" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" required>
                    <option value="">Select Stock Name</option>
                    @foreach($stockNames as $stock)
                        <option value="{{ $stock }}">{{ $stock }}</option>
                    @endforeach
                </select>
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-xs text-gray-500">Or enter a new Stock Name:</span>
                    <input type="text" name="stock_name" class="flex-1 rounded-lg border-gray-300 px-2 py-1 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" placeholder="New Stock Name">
                </div>
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-2">Current Stock Value</label>
                <input type="number" name="current_stock_value" class="w-full rounded-lg border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" required>
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-2">Own Money</label>
                <input type="number" name="own_money" class="w-full rounded-lg border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" required>
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-2">Borrowed Money</label>
                <input type="number" name="borrowed_money" class="w-full rounded-lg border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" required>
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-2">Initial Investment</label>
                <div id="initial-investment" class="w-full rounded-lg border bg-blue-50 px-3 py-2 text-blue-900 font-semibold">0</div>
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-2">Margin Threshold</label>
                <input type="number" step="0.01" name="margin_threshold" class="w-full rounded-lg border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" required>
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-2">Stock Count</label>
                <input type="number" name="current_stock_count" class="w-full rounded-lg border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" required>
            </div>
            <div class="flex gap-4 mt-8 justify-center">
                <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-bold px-8 py-2 rounded-lg shadow-lg transition">Add Trader</button>
                <a href="{{ route('traders.index') }}" class="bg-gray-100 hover:bg-gray-200 text-blue-700 font-bold px-8 py-2 rounded-lg shadow-lg transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
<script>
    function updateInitialInvestment() {
        const own = parseFloat(document.querySelector('[name="own_money"]').value) || 0;
        const borrowed = parseFloat(document.querySelector('[name="borrowed_money"]').value) || 0;
        document.getElementById('initial-investment').textContent = own + borrowed;
    }
    document.querySelector('[name="own_money"]').addEventListener('input', updateInitialInvestment);
    document.querySelector('[name="borrowed_money"]').addEventListener('input', updateInitialInvestment);
</script>
</form>
@endsection
