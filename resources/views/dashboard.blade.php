@extends('layouts.app')

@section('content')
<div id="dashboard" class="tab-content active">
    @include('partials.stats')

    <div class="card">
        <h3>Recent Transactions</h3>
        <table class="table" id="recentTransactions">
            <thead>
                <tr>
                    <th>Document No.</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Debit Account</th>
                    <th>Credit Account</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentTransactions as $trx)
                <tr>
                    <td>{{ $trx->id }}</td>
                    <td>{{ $trx->transaction_date->format('d-m-Y') }}</td>
                    <td>{{ $trx->description }}</td>
                    <td>
                        {{ $trx->debitAccount 
                            ? $trx->debitAccount->id . ' - ' . $trx->debitAccount->name . ' (' . $trx->debitAccount->type . ')' 
                            : '-' }}
                    </td>
                    <td>
                        {{ $trx->creditAccount 
                            ? $trx->creditAccount->id . ' - ' . $trx->creditAccount->name . ' (' . $trx->creditAccount->type . ')' 
                            : '-' }}
                    </td>
                    <td>Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
