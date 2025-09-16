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
                                    data-credit="{{ $deposit_master->credit_account_id }}"
                                    data-role="{{ $deposit_master->role_area }}">
                                {{ $deposit_master->id }} - {{ $deposit_master->description }} - {{ $deposit_master->role_area }}
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
                    <label for="creditAccount">Credit Account (50)</label>
                    <select id="creditAccount" name="credit_account_id">
                        <option value="">Select Credit Account</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}" data-role="{{ $account->role_area }}">{{ $account->id }} - {{ $account->name }} ({{ $account->type }}) [{{ $account->role_area }}]</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="debitAccount">Debit Account (40)</label>
                    <select id="debitAccount" name="debit_account_id">
                        <option value="">Select Debit Account</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}" data-role="{{ $account->role_area }}">{{ $account->id }} - {{ $account->name }} ({{ $account->type }}) [{{ $account->role_area }}]</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="paidToSource">Received from / Paid to</label>
                    <input type="text" id="paidToSource" name="paid_to_source" placeholder="Enter name or source" required>
                </div>


                <div class="form-group">
                    <label for="roleArea">Role Area</label>
                    <select id="roleArea" name="role_area" required>
                        <option value="">Select Role Area</option>
                        <option value="mahad">Mahad</option>
                        <option value="yayasan">Yayasan</option>
                    </select>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Simpan semua opsi akun asli
    const creditAccount = document.getElementById('creditAccount');
    const debitAccount = document.getElementById('debitAccount');
    const roleAreaSelect = document.getElementById('roleArea');
    
    // Simpan semua opsi akun untuk referensi
    const allCreditOptions = Array.from(creditAccount.options);
    const allDebitOptions = Array.from(debitAccount.options);
    
    // Fungsi untuk memfilter akun berdasarkan role area
    function filterAccountsByRole(role) {
        // Filter credit account
        creditAccount.innerHTML = '<option value="">Select Credit Account</option>';
        allCreditOptions.forEach(option => {
            if (option.value === "" || option.getAttribute('data-role') === role) {
                creditAccount.appendChild(option.cloneNode(true));
            }
        });
        
        // Filter debit account
        debitAccount.innerHTML = '<option value="">Select Debit Account</option>';
        allDebitOptions.forEach(option => {
            if (option.value === "" || option.getAttribute('data-role') === role) {
                debitAccount.appendChild(option.cloneNode(true));
            }
        });
    }
    
    // Event listener untuk perubahan role area
    roleAreaSelect.addEventListener('change', function() {
        const selectedRole = this.value;
        if (selectedRole) {
            filterAccountsByRole(selectedRole);
        } else {
            // Tampilkan semua akun jika tidak ada role yang dipilih
            creditAccount.innerHTML = '';
            allCreditOptions.forEach(option => {
                creditAccount.appendChild(option.cloneNode(true));
            });
            
            debitAccount.innerHTML = '';
            allDebitOptions.forEach(option => {
                debitAccount.appendChild(option.cloneNode(true));
            });
        }
    });
    
    // Event listener untuk transaction master
    const transactionMaster = document.getElementById('transactionMaster');
    transactionMaster.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption && selectedOption.value) {
            const role = selectedOption.getAttribute('data-role');
            if (role) {
                // Set role area sesuai dengan transaction master
                roleAreaSelect.value = role;
                
                // Trigger change event pada role area untuk memfilter akun
                const event = new Event('change');
                roleAreaSelect.dispatchEvent(event);
                
                // Isi field lainnya
                document.getElementById('transactionDescription').value = selectedOption.getAttribute('data-description') || '';
                document.getElementById('transactionAmount').value = selectedOption.getAttribute('data-amount') || '';
                
                // Set debit dan credit account jika ada
                const debitAccountId = selectedOption.getAttribute('data-debit');
                const creditAccountId = selectedOption.getAttribute('data-credit');
                
                if (debitAccountId) {
                    setTimeout(() => {
                        document.getElementById('debitAccount').value = debitAccountId;
                    }, 100);
                }
                
                if (creditAccountId) {
                    setTimeout(() => {
                        document.getElementById('creditAccount').value = creditAccountId;
                    }, 100);
                }
            }
        }
    });
});
</script>

<script src="{{ asset('js/transaction.js') }}"></script>
@stack('scripts')
@include('partials.modals')
@endsection