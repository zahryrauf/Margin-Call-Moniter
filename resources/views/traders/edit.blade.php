@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gradient-to-br from-blue-50 to-gray-100 py-8">
    <div class="w-full max-w-2xl bg-white shadow-xl rounded-2xl p-10 border border-blue-100">
        <h2 class="text-3xl font-extrabold mb-8 text-blue-800 text-center tracking-tight">Edit Trader</h2>
    <form id="edit-trader-form" action="{{ route('traders.update', $trader->_id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-blue-700 font-semibold mb-2">Trader ID</label>
                <input type="text" name="trader_id" class="w-full rounded-lg border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" value="{{ $trader->trader_id }}" required>
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-2">Trader Name</label>
                <input type="text" name="trader_name" class="w-full rounded-lg border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" value="{{ $trader->trader_name }}" required>
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-2">Stock Name</label>
                <input type="text" name="stock_name" class="w-full rounded-lg border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" value="{{ $trader->stock_name }}" required>
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-2">Current Stock Value</label>
                <input type="number" name="current_stock_value" step="any" class="w-full rounded-lg border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" value="{{ $trader->current_stock_value }}" required>
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-2">Own Money</label>
                <input type="number" name="own_money" step="any" class="w-full rounded-lg border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" value="{{ $trader->own_money }}" required>
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-2">Borrowed Money</label>
                <input type="number" name="borrowed_money" step="any" class="w-full rounded-lg border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" value="{{ $trader->borrowed_money }}" required>
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-2">Margin Threshold</label>
                <input type="number" step="0.01" name="margin_threshold" class="w-full rounded-lg border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" value="{{ $trader->margin_threshold }}" required>
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-2">Stock Count</label>
                <input type="number" name="current_stock_count" class="w-full rounded-lg border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" value="{{ $trader->current_stock_count }}" required>
            </div>
            <div class="flex gap-4 mt-8 justify-center">
                <button id="update-btn" type="submit" class="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-bold px-8 py-2 rounded-lg shadow-lg transition">Update Trader</button>
                <a href="{{ route('traders.index') }}" class="bg-gray-100 hover:bg-gray-200 text-blue-700 font-bold px-8 py-2 rounded-lg shadow-lg transition">Cancel</a>
            </div>
        </form>
        <!-- Modal -->
        <div id="confirm-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
            <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full text-center">
                <div id="modal-message" class="text-lg font-semibold text-blue-800 mb-6">Are you sure you want to update this trader?</div>
                <div class="flex justify-center gap-6">
                    <button id="modal-yes" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2 rounded-lg transition">Yes</button>
                    <button id="modal-no" class="bg-gray-200 hover:bg-gray-300 text-blue-700 font-bold px-6 py-2 rounded-lg transition">No</button>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('edit-trader-form');
    const updateBtn = document.getElementById('update-btn');
    const modal = document.getElementById('confirm-modal');
    const modalYes = document.getElementById('modal-yes');
    const modalNo = document.getElementById('modal-no');
    const modalMsg = document.getElementById('modal-message');
    // Store initial form data
    const initialData = new FormData(form);
    let hasChanged = false;

    // Detect changes
    form.addEventListener('input', function() {
        hasChanged = false;
        const currentData = new FormData(form);
        for (let [key, value] of currentData.entries()) {
            if (initialData.get(key) !== value) {
                hasChanged = true;
                break;
            }
        }
    });

    // Intercept submit
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (hasChanged) {
            modalMsg.textContent = 'Are you sure you want to update this trader?';
        } else {
            modalMsg.textContent = 'No changes detected. Do you still want to submit?';
        }
        modal.classList.remove('hidden');
    });

    // Modal buttons
    modalYes.addEventListener('click', function() {
        modal.classList.add('hidden');
        form.removeEventListener('submit', arguments.callee);
        form.submit();
    });
    modalNo.addEventListener('click', function() {
        modal.classList.add('hidden');
    });
});
</script>
@endsection