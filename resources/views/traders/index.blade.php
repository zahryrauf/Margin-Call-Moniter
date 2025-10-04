
@extends('layouts.app')

@section('content')

<div class="flex justify-center items-center min-h-screen bg-gradient-to-br from-blue-50 to-gray-100 py-8">
    <div class="w-full max-w-6xl bg-white shadow-xl rounded-2xl p-10 border border-blue-100">
        <h2 class="text-3xl font-extrabold mb-8 text-blue-800 text-center tracking-tight">Broker Dashboard - Margin Call Monitoring</h2>

        <div class="mb-8 flex flex-col md:flex-row gap-4 md:gap-8 items-center justify-between">
            <form method="POST" action="{{ route('stocks.updatePrice') }}" onsubmit="return confirm('Are you sure you want to update the price for this stock?');" class="flex flex-wrap gap-3 items-center bg-blue-50 rounded-lg px-4 py-3 shadow">
                @csrf
                <label for="stock_name" class="text-blue-700 font-semibold mb-0">Update Stock Price:</label>
                <select name="stock_name" id="stock_name" required
                    class="block w-44 appearance-none rounded-lg border border-blue-300 bg-white px-3 py-2 pr-8 text-blue-800 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-400 transition placeholder-blue-400">
                    <option value="" disabled selected class="text-gray-400">Select Stock</option>
                    @php $stockNames = collect($traders)->pluck('stock_name')->unique(); @endphp
                    @foreach($stockNames as $stock)
                        <option value="{{ $stock }}">{{ $stock }}</option>
                    @endforeach
                </select>
                <input type="number" name="new_price" id="new_price" class="rounded border-gray-300 px-2 py-1 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" placeholder="New Price" step="0.01" min="0" required style="max-width: 120px;">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-1.5 rounded shadow">Update Price</button>
            </form>

            <div id="js-search-bar" class="flex flex-wrap gap-3 items-center bg-blue-50 rounded-lg px-4 py-3 shadow">
                <input type="text" id="js-search-name" placeholder="Trader Name" class="rounded border-gray-300 px-2 py-1 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" style="max-width: 180px;">
                <select id="js-search-stock" class="block w-36 appearance-none rounded-lg border border-blue-300 bg-white px-3 py-2 pr-8 text-blue-800 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-400 transition placeholder-blue-400">
                    <option value="" class="text-gray-400">All Trader IDs</option>
                    @php $traderIds = collect($traders)->pluck('trader_id')->unique(); @endphp
                    @foreach($traderIds as $id)
                        <option value="{{ $id }}">{{ $id }}</option>
                    @endforeach
                </select>
                <select id="js-search-stockname" class="block w-40 appearance-none rounded-lg border border-blue-300 bg-white px-3 py-2 pr-8 text-blue-800 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-400 transition placeholder-blue-400">
                    <option value="" class="text-gray-400">All Stocks</option>
                    @php $stockNames = collect($traders)->pluck('stock_name')->unique(); @endphp
                    @foreach($stockNames as $stock)
                        <option value="{{ $stock }}">{{ $stock }}</option>
                    @endforeach
                </select>
                <select id="js-search-status" class="block w-32 appearance-none rounded-lg border border-blue-300 bg-white px-3 py-2 pr-8 text-blue-800 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-400 transition placeholder-blue-400">
                    <option value="" class="text-gray-400">All Statuses</option>
                    <option value="ALERT">ALERT</option>
                    <option value="OK">OK</option>
                </select>
                <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-1.5 rounded shadow" onclick="filterTable()">Search</button>
                <button type="button" class="bg-gray-100 hover:bg-gray-200 text-blue-700 font-semibold px-4 py-1.5 rounded shadow" onclick="resetTable()">Reset</button>
            </div>
        </div>

        <a href="{{ route('traders.create') }}" class="inline-block mb-6 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-bold px-8 py-2 rounded-lg shadow-lg transition">Add Trader</a>

        @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800 font-semibold shadow text-center">{{ session('success') }}</div>
        @endif

        <div class="overflow-x-auto rounded-xl shadow">
            <table class="min-w-full divide-y divide-blue-200" id="js-traders-table">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Trader</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Stock</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Current Value</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Own Money</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Borrowed Money</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Initial Investment</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Margin Threshold</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Stock Count</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Total Value</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Equity</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-blue-50">
                    @foreach($traders as $trader)
                    <tr class="{{ $trader->status == 'ALERT' ? 'bg-red-50' : 'bg-green-50' }} hover:bg-blue-50 transition">
                        <td class="px-4 py-2 font-mono text-blue-900">{{ $trader->trader_id }}</td>
                        <td class="px-4 py-2">{{ $trader->trader_name }}</td>
                        <td class="px-4 py-2">{{ $trader->stock_name }}</td>
                        <td class="px-4 py-2">{{ $trader->current_stock_value }}</td>
                        <td class="px-4 py-2">{{ $trader->own_money }}</td>
                        <td class="px-4 py-2">{{ $trader->borrowed_money }}</td>
                        <td class="px-4 py-2">{{ $trader->initial_total_investment }}</td>
                        <td class="px-4 py-2">{{ $trader->margin_threshold }}</td>
                        <td class="px-4 py-2">{{ $trader->current_stock_count }}</td>
                        <td class="px-4 py-2">{{ $trader->current_total_value }}</td>
                        <td class="px-4 py-2">{{ $trader->equity }}</td>
                        <td class="px-4 py-2 font-bold {{ $trader->status == 'ALERT' ? 'text-red-600' : 'text-green-700' }}">{{ $trader->status }}</td>
                        <td class="px-4 py-2 flex gap-2">
                            <a href="{{ route('traders.edit', $trader->_id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white font-bold px-3 py-1 rounded shadow text-xs" onclick="return confirm('Are you sure you want to edit this trader?');">Edit</a>
                            <form action="{{ route('traders.destroy', $trader->_id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this trader?');">
                                @csrf @method('DELETE')
                                <button class="bg-red-500 hover:bg-red-600 text-white font-bold px-3 py-1 rounded shadow text-xs">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function filterTable() {
    const name = document.getElementById('js-search-name').value.toLowerCase();
    const stock = document.getElementById('js-search-stock').value;
    const stockname = document.getElementById('js-search-stockname').value;
    const status = document.getElementById('js-search-status').value;
    const table = document.getElementById('js-traders-table');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (let i = 0; i < rows.length; i++) {
        const tds = rows[i].getElementsByTagName('td');
        const traderName = tds[1].textContent.toLowerCase();
        const stockId = tds[0].textContent;
        const stockName = tds[2].textContent;
        const traderStatus = tds[11].textContent;
        let show = true;
        if (name && !traderName.includes(name)) show = false;
        if (stock && stock !== '' && stockId !== stock) show = false;
        if (stockname && stockname !== '' && stockName !== stockname) show = false;
        if (status && traderStatus !== status) show = false;
        rows[i].style.display = show ? '' : 'none';
    }
}
function resetTable() {
    document.getElementById('js-search-name').value = '';
    document.getElementById('js-search-stock').value = '';
    document.getElementById('js-search-stockname').value = '';
    document.getElementById('js-search-status').value = '';
    filterTable();
}
</script>
@endsection
