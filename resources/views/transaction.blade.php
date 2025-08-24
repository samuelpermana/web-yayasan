@extends('layouts.app')

@section('content')
<div id="transaction-entry" class="tab-content active">
    <!-- Transaction Tab -->
    <div class="card">
        <h3>Transaction Entry</h3>
        <form method="POST" action="{{ route('transaction.store') }}">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label for="transactionDate">Date</label>
                    <input type="date" id="transactionDate" name="transaction_date" required>
                </div>
                <div class="form-group">
                    <label for="transactionMaster">Transaction Master</label>
                    <select id="transactionMaster" name="transaction_master_id">
                        <option value="">Select Transaction Master</option>
                        @foreach($deposit_masters as $deposit_master)
                            <option value="{{ $deposit_master->id }}"
                                    data-description="{{ $deposit_master->description }}"
                                    data-amount="{{ $deposit_master->default_amount }}"
                                    data-debit="{{ $deposit_master->debit_account_id }}"
                                    data-credit="{{ $deposit_master->credit_account_id }}">
                                {{ $deposit_master->id }} - {{ $deposit_master->description }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="transactionDescription">Description</label>
                    <input type="text" id="transactionDescription" name="description" required>
                </div>
                <div class="form-group">
                    <label for="transactionAmount">Amount</label>
                    <input type="number" id="transactionAmount" name="amount" step="0.01" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="creditAccount">Credit Account</label>
                    <select id="creditAccount" name="credit_account_id">
                        <option value="">Select Credit Account</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->id }} - {{ $account->name }} ({{ $account->type }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="creditDK">Credit D/K Reference</label>
                    <input type="text" id="creditDK" name="credit_dk_reference" placeholder="e.g., 50" value="50" maxlength="10">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="debitAccount">Debit Account</label>
                    <select id="debitAccount" name="debit_account_id">
                        <option value="">Select Debit Account</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->id }} - {{ $account->name }} ({{ $account->type }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="debitDK">Debit D/K Reference</label>
                    <input type="text" id="debitDK" name="debit_dk_reference" placeholder="e.g., 40" value="40" maxlength="10">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="transactionFromTo">Received from / Paid to</label>
                    <input type="text" id="transactionFromTo" name="from_to" placeholder="Enter name or source" required>
                </div>
            </div>

            <button type="submit">Post Income Transaction</button>
            <button type="button" onclick="window.location.href='{{ route('dm.index') }}'">Manage Deposit Master</button>
        </form>
    </div>

    <!-- Upload Card -->
    <div class="card">
        <h3>Upload Income Data</h3>
        <div class="upload-area" onclick="document.getElementById('incomeUpload').click()">
            <div style="font-size: 48px; margin-bottom: 20px;">📄</div>
            <h4>Click to upload income data file</h4>
            <p>Supports CSV, Excel files</p>
        </div>
        <input type="file" id="incomeUpload" style="display: none;" accept=".csv,.xlsx,.xls" onchange="handleFileUpload(this, 'income')">
    </div>
</div>

<script src="{{ asset('js/transaction.js') }}"></script>
@stack('scripts')
@include('partials.modals')
@endsection
