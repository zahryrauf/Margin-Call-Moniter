@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gradient-to-br from-blue-50 to-gray-100 py-8">
    <div class="w-full max-w-2xl bg-white shadow-xl rounded-2xl p-10 border border-blue-100">
        <h2 class="text-3xl font-extrabold mb-8 text-blue-800 text-center tracking-tight">Add Trader</h2>
    <form id="trader-create-form" action="{{ route('traders.store') }}" method="POST" class="space-y-6">
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
                <select id="trader_id_select" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                    <option value="">Select Trader ID</option>
                    @foreach($traderIds as $id)
                        <option value="{{ $id }}">{{ $id }}</option>
                    @endforeach
                    <option value="__other__">Other</option>
                </select>
                <div id="trader_id_input_div" class="flex items-center gap-2 mt-2 hidden">
                    <span class="text-xs text-gray-500">Enter new Trader ID:</span>
                    <input type="text" id="trader_id_input" class="flex-1 rounded-lg border-gray-300 px-2 py-1 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" placeholder="New Trader ID" disabled>
                </div>
                <input type="hidden" name="trader_id" id="trader_id_final" required value="{{ old('trader_id') }}">
                @if($errors->has('trader_id'))
                    <div class="text-red-600 text-xs mt-1">{{ $errors->first('trader_id') }}</div>
                @endif
                @if(old('trader_id'))
                    <div class="text-xs text-gray-500">Submitted value: {{ old('trader_id') }}</div>
                @endif
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-2">Trader Name</label>
                <select id="trader_name_select" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                    <option value="">Select Trader Name</option>
                    @foreach($traderNames as $name)
                        <option value="{{ $name }}">{{ $name }}</option>
                    @endforeach
                    <option value="__other__">Other</option>
                </select>
                <div id="trader_name_input_div" class="flex items-center gap-2 mt-2 hidden">
                    <span class="text-xs text-gray-500">Enter new Trader Name:</span>
                    <input type="text" id="trader_name_input" class="flex-1 rounded-lg border-gray-300 px-2 py-1 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" placeholder="New Trader Name" disabled>
                </div>
                <input type="hidden" name="trader_name" id="trader_name_final" required value="{{ old('trader_name') }}">
                @if($errors->has('trader_name'))
                    <div class="text-red-600 text-xs mt-1">{{ $errors->first('trader_name') }}</div>
                @endif
                @if(old('trader_name'))
                    <div class="text-xs text-gray-500">Submitted value: {{ old('trader_name') }}</div>
                @endif
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-2">Stock Name</label>
                <select id="stock_name_select" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                    <option value="">Select Stock Name</option>
                    @foreach($stockNames as $stock)
                        <option value="{{ $stock }}">{{ $stock }}</option>
                    @endforeach
                    <option value="__other__">Other</option>
                </select>
                <div id="stock_name_input_div" class="flex items-center gap-2 mt-2 hidden">
                    <span class="text-xs text-gray-500">Enter new Stock Name:</span>
                    <input type="text" id="stock_name_input" class="flex-1 rounded-lg border-gray-300 px-2 py-1 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" placeholder="New Stock Name" disabled>
                </div>
                <input type="hidden" name="stock_name" id="stock_name_final" required value="{{ old('stock_name') }}">
                @if($errors->has('stock_name'))
                    <div class="text-red-600 text-xs mt-1">{{ $errors->first('stock_name') }}</div>
                @endif
                @if(old('stock_name'))
                    <div class="text-xs text-gray-500">Submitted value: {{ old('stock_name') }}</div>
                @endif
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-2">Current Stock Value</label>
                <input type="number" name="current_stock_value" step="any" class="w-full rounded-lg border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" required>
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
document.addEventListener('DOMContentLoaded', function() {
    function updateInitialInvestment() {
        const own = parseFloat(document.querySelector('[name="own_money"]').value) || 0;
        const borrowed = parseFloat(document.querySelector('[name="borrowed_money"]').value) || 0;
        document.getElementById('initial-investment').textContent = own + borrowed;
    }
    document.querySelector('[name="own_money"]').addEventListener('input', updateInitialInvestment);
    document.querySelector('[name="borrowed_money"]').addEventListener('input', updateInitialInvestment);

    // Toggle input fields for Trader ID, Name, Stock
    function toggleInput(selectId, inputDivId, inputId) {
        const select = document.getElementById(selectId);
        const inputDiv = document.getElementById(inputDivId);
        const input = document.getElementById(inputId);
        select.addEventListener('change', function() {
            if (this.value === '__other__') {
                inputDiv.classList.remove('hidden');
                input.disabled = false;
                input.required = true;
            } else {
                inputDiv.classList.add('hidden');
                input.disabled = true;
                input.required = false;
            }
        });
    }
    toggleInput('trader_id_select', 'trader_id_input_div', 'trader_id_input');
    toggleInput('trader_name_select', 'trader_name_input_div', 'trader_name_input');
    toggleInput('stock_name_select', 'stock_name_input_div', 'stock_name_input');

    // On submit, set hidden input values
    const form = document.getElementById('trader-create-form');
    form.addEventListener('submit', function(e) {
        // Trader ID
        const traderIdSelect = document.getElementById('trader_id_select');
        const traderIdInput = document.getElementById('trader_id_input');
        const traderIdFinal = document.getElementById('trader_id_final');
        if (traderIdSelect.value === '__other__') {
            if (!traderIdInput.value.trim()) {
                traderIdInput.focus();
                e.preventDefault();
                return false;
            }
            traderIdFinal.value = traderIdInput.value;
        } else {
            traderIdFinal.value = traderIdSelect.value;
        }
        // Trader Name
        const traderNameSelect = document.getElementById('trader_name_select');
        const traderNameInput = document.getElementById('trader_name_input');
        const traderNameFinal = document.getElementById('trader_name_final');
        if (traderNameSelect.value === '__other__') {
            if (!traderNameInput.value.trim()) {
                traderNameInput.focus();
                e.preventDefault();
                return false;
            }
            traderNameFinal.value = traderNameInput.value;
        } else {
            traderNameFinal.value = traderNameSelect.value;
        }
        // Stock Name
        const stockNameSelect = document.getElementById('stock_name_select');
        const stockNameInput = document.getElementById('stock_name_input');
        const stockNameFinal = document.getElementById('stock_name_final');
        if (stockNameSelect.value === '__other__') {
            if (!stockNameInput.value.trim()) {
                stockNameInput.focus();
                e.preventDefault();
                return false;
            }
            stockNameFinal.value = stockNameInput.value;
        } else {
            stockNameFinal.value = stockNameSelect.value;
        }
 });
});
</script>
</form>
@endsection
