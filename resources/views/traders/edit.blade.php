@extends('layouts.app')

@section('content')
<h2>Edit Trader</h2>
<form action="{{ route('traders.update', $trader->_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to update this trader?');">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Trader ID</label>
        <input type="text" name="trader_id" class="form-control" value="{{ $trader->trader_id }}" required>
    </div>
    <div class="mb-3">
        <label>Trader Name</label>
        <input type="text" name="trader_name" class="form-control" value="{{ $trader->trader_name }}" required>
    </div>
    <div class="mb-3">
        <label>Stock Name</label>
        <input type="text" name="stock_name" class="form-control" value="{{ $trader->stock_name }}" required>
    </div>
    <div class="mb-3">
        <label>Current Stock Value</label>
        <input type="number" name="current_stock_value" class="form-control" value="{{ $trader->current_stock_value }}" required>
    </div>
    <div class="mb-3">
        <label>Own Money</label>
        <input type="number" name="own_money" class="form-control" value="{{ $trader->own_money }}" required>
    </div>
    <div class="mb-3">
        <label>Borrowed Money</label>
        <input type="number" name="borrowed_money" class="form-control" value="{{ $trader->borrowed_money }}" required>
    </div>
    <div class="mb-3">
        <label>Margin Threshold</label>
        <input type="number" step="0.01" name="margin_threshold" class="form-control" value="{{ $trader->margin_threshold }}" required>
    </div>
    <div class="mb-3">
        <label>Stock Count</label>
        <input type="number" name="current_stock_count" class="form-control" value="{{ $trader->current_stock_count }}" required>
    </div>
    <button type="submit" class="btn btn-success">Update Trader</button>
    <a href="{{ route('traders.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection