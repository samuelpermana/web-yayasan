@extends('layouts.app')

@section('content')
<div class="card">
    <h3>Edit Journal Entry</h3>

    <form action="{{ route('journal.update', $journal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Description -->
        <div class="form-group">
            <label>Description</label>
            <input type="text" name="description" value="{{ old('description', $journal->description) }}" class="form-control" required>
        </div>

        <!-- Debit Account -->
        <div class="form-group">
            <label>Debit Account</label>
            <select name="debit_account_id" class="form-control" required>
                <option value="">-- Select Debit Account --</option>
                @foreach($accounts as $acc)
                    <option value="{{ $acc->id }}" {{ $journal->debit_account_id == $acc->id ? 'selected' : '' }}>
                        {{ $acc->id }} - {{ $acc->name }} ({{ $acc->type }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Credit Account -->
        <div class="form-group">
            <label>Credit Account</label>
            <select name="credit_account_id" class="form-control" required>
                <option value="">-- Select Credit Account --</option>
                @foreach($accounts as $acc)
                    <option value="{{ $acc->id }}" {{ $journal->credit_account_id == $acc->id ? 'selected' : '' }}>
                        {{ $acc->id }} - {{ $acc->name }} ({{ $acc->type }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Amount -->
        <div class="form-group">
            <label>Amount</label>
            <input type="number" name="amount" value="{{ old('amount', $journal->amount) }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('journal.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
