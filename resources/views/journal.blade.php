@extends('layouts.app')

@section('content')
<div class="card">
    <h3>Journal Entries</h3>
    <div class="search-box">
        <input type="text" placeholder="Search journal entries..." onkeyup="filterJournalEntries(this.value)">
    </div>
    <table class="table" id="journalTable">
        <thead>
            <tr>
                <th>Document No.</th>
                <th>Date</th>
                <th>Description</th>
                <th>Debit Account</th>
                <th>Credit Account</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($journals as $journal)
                <tr>
                    <td>{{ $journal->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($journal->transaction_date)->format('d-m-Y') }}</td>
                    <td>{{ $journal->description }}</td>
                    <td>{{ $journal->debitAccount?->id ?? '-' }} - {{ $journal->debitAccount?->name ?? '-' }} ({{ $journal->debitAccount?->type ?? '-' }})</td>
                    <td>{{ $journal->creditAccount?->id ?? '-' }} - {{ $journal->creditAccount?->name ?? '-' }} ({{ $journal->creditAccount?->type ?? '-' }})</td>
                    <td>{{ number_format($journal->amount, 0, ',', '.') }}</td>
                    <td>
                        <!-- Tombol sementara tanpa redirect -->
                        <button type="button" title="Edit" onclick="alert('Edit button clicked')">Edit</button>
                        <button type="button" title="Print" onclick="alert('Print button clicked')">Print</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
