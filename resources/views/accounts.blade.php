@extends('layouts.app')

@section('content')
<div class="card">
    <h3>Display Account</h3>
    <form method="GET" action="{{ route('accounts.index') }}">
        <div class="form-row">
            <div class="form-group">
                <label for="accountSelect">GL Account</label>
                <select name="account_id" id="accountSelect">
                    <option value="">-- Select Account --</option>
                    @foreach($accounts as $account)
                        <option value="{{ $account->id }}" 
                            {{ (isset($selectedAccount) && $selectedAccount->id == $account->id) ? 'selected' : '' }}>
                            {{ $account->id }} - {{ $account->name }} ({{ $account->type }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="startDate">Start Date</label>
                <input type="date" name="start_date" id="startDate" value="{{ $startDate ?? '' }}">
            </div>
            <div class="form-group">
                <label for="endDate">End Date</label>
                <input type="date" name="end_date" id="endDate" value="{{ $endDate ?? '' }}">
            </div>
        </div>
        <button type="submit">Show</button>
    </form>

    <div id="accountDetails" style="margin-top:20px;">
        <h4>Account Info</h4>
        <p><strong>GL Account:</strong> {{ $selectedAccount->name ?? '-' }} ({{ $selectedAccount->type ?? '-' }})</p>
        <p><strong>Description:</strong> {{ $selectedAccount->description ?? '-' }}</p>
        <p><strong>Saldo Awal:</strong> Rp {{ isset($selectedAccount) ? number_format($selectedAccount->nilai_awal,0,',','.') : '-' }}</p>

        <h4>Mutasi Transaksi</h4>
        <table class="table" id="accountTransactionTable">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $runningBalance = $selectedAccount->nilai_awal ?? 0;
                @endphp
                @forelse($transactions as $tx)
                    @php
                        $debit = $tx->debit_account_id == ($selectedAccount->id ?? 0) ? $tx->amount : 0;
                        $credit = $tx->credit_account_id == ($selectedAccount->id ?? 0) ? $tx->amount : 0;

                        if(($selectedAccount->type ?? '') === 'Asset') {
                            $runningBalance += $debit - $credit;
                        } else {
                            $runningBalance += $credit - $debit;
                        }
                    @endphp
                    <tr>
                        <td>{{ $tx->transaction_date }}</td>
                        <td>{{ $tx->description }}</td>
                        <td>{{ $debit ? number_format($debit,0,',','.') : '-' }}</td>
                        <td>{{ $credit ? number_format($credit,0,',','.') : '-' }}</td>
                        <td>{{ number_format($runningBalance,0,',','.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;">-</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
