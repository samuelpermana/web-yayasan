@extends('layouts.app')

@section('content')

<div class="card">
    <span class="close" onclick="window.location.href='{{ route('transaction.index') }}'">&times;</span>
    <h3>Manage Deposit Master Data</h3>

    <!-- Form Create -->
    <form action="{{ route('dm.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="depositNumber">Deposit Number</label>
            <input type="text" name="number" id="depositNumber" placeholder="e.g. DEP0001" required>
        </div>

        <div class="form-group">
            <label for="depositDescription">Description</label>
            <input type="text" name="description" id="depositDescription" required>
        </div>

        <div class="form-group">
            <label for="depositDefaultAmount">Default Amount</label>
            <input type="number" name="default_amount" id="depositDefaultAmount" step="0.01" required>
        </div>

        <!-- Debit Account -->
        <div class="form-group">
            <label for="debitAccountModal">Debit Account</label>
            <select id="debitAccountModal" name="debit_account_id" required>
                <option value="">-- Select Debit Account --</option>
                @foreach ($accounts as $acc)
                    <option value="{{ $acc->id }}">{{ $acc->id }} - {{ $acc->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Credit Account -->
        <div class="form-group">
            <label for="creditAccountModal">Credit Account</label>
            <select id="creditAccountModal" name="credit_account_id" required>
                <option value="">-- Select Credit Account --</option>
                @foreach ($accounts as $acc)
                    <option value="{{ $acc->id }}">{{ $acc->id }} - {{ $acc->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create Deposit</button>
    </form>

    <!-- Table Deposit Master -->
    <h4 style="margin-top:20px;">Deposit Master List</h4>
    <table class="table" id="depositTable">
        <thead>
            <tr>
                <th>Number</th>
                <th>Description</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Default Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($deposit_masters as $deposit)
                <tr>
                    <td>{{ $deposit->number }}</td>
                    <td>{{ $deposit->description }}</td>
                    <td>
                        @if($deposit->debitAccount)
                            {{ $deposit->debitAccount->id }} - {{ $deposit->debitAccount->name }} ({{ $deposit->debitAccount->type }})
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        @if($deposit->creditAccount)
                            {{ $deposit->creditAccount->id }} - {{ $deposit->creditAccount->name }} ({{ $deposit->creditAccount->type }})
                        @else
                            -
                        @endif
                    </td>

                    <td>{{ number_format($deposit->default_amount, 2) }}</td>
                    <td>
                        <form action="{{ route('dm.edit', $deposit->id) }}" method="GET" style="display:inline-block;">
                            <button type="submit" class="btn btn-warning btn-sm">
                                Edit
                            </button>
                        </form>
                        <form action="{{ route('dm.destroy', $deposit->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
