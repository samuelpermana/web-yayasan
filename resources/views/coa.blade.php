@extends('layouts.app')

@section('content')

<div class="card">
    <h3>Chart of Accounts Management</h3>
    
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif
    
    @if($errors->any())
        <div class="alert error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
    
    <!-- Add/Edit Account Form -->
    <div class="card" style="margin-bottom: 30px;">
        <h4 style="margin-bottom: 20px; color: #4a5568;" id="formTitle">Add New Account</h4>
        <form id="accountForm" method="POST" action="{{ route('coa.store') }}">
            @csrf
            <input type="hidden" id="accountId" name="account_id">
            <input type="hidden" id="formMethod" name="_method" value="POST">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="account_number">Account Number:</label>
                    <input type="number" 
                           name="account_number" 
                           id="account_number" 
                           placeholder="Enter account number"
                           required>
                </div>
                
                <div class="form-group">
                    <label for="account_type">Account Type:</label>
                    <select name="account_type" id="account_type" required>
                        <option value="">Select account type...</option>
                        <option value="Asset">Asset</option>
                        <option value="Liability">Liability</option>
                        <option value="Equity">Equity</option>
                        <option value="Income">Income</option>
                        <option value="Expense">Expense</option>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="account_name">Account Name:</label>
                    <input type="text" 
                           name="account_name" 
                           id="account_name" 
                           placeholder="Enter account name"
                           required>
                </div>
                
                <div class="form-group">
                    <label for="initial_value">Initial Value (Optional):</label>
                    <input type="number" 
                           name="initial_value" 
                           id="initial_value" 
                           placeholder="0"
                           step="0.01">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="role_area">Role Area:</label>
                    <select name="role_area" id="role_area" required>
                        <option value="">Select role area...</option>
                        <option value="yayasan">Yayasan</option>
                        <option value="mahad">Mahad</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="description">Description (Optional):</label>
                <input type="text" 
                       name="description" 
                       id="description" 
                       placeholder="Enter account description">
            </div>
            
            <div class="form-group" style="display: flex; gap: 10px;">
                <button type="submit" id="submitBtn">Add Account</button>
                <button type="button" id="cancelBtn" onclick="resetForm()" style="background: linear-gradient(135deg, #718096, #4a5568);">Cancel</button>
            </div>
        </form>
    </div>
    
    <!-- Search Box -->
    <form method="GET" action="{{ route('coa.index') }}" style="margin-bottom: 20px;">
        <div class="search-box">
            <input type="text" 
                   name="search" 
                   placeholder="Search all accounts..." 
                   value="{{ request('search') }}"
                   style="width: 100%;">
        </div>
        <div style="margin-top: 10px; display: flex; gap: 10px;">
            <button type="submit">Search</button>
            @if(request('search'))
                <a href="{{ route('coa.index') }}" style="text-decoration: none;">
                    <button type="button" style="background: linear-gradient(135deg, #718096, #4a5568);">Clear Search</button>
                </a>
            @endif
        </div>
    </form>
    
    <!-- Search Results Indicator -->
    @if(request('search'))
        <div style="margin-bottom: 15px; padding: 10px; background-color: #e3f2fd; border-left: 4px solid #2196f3; border-radius: 4px;">
            <strong>Search Results for "{{ request('search') }}"</strong> - Found {{ $accounts->total() }} account(s)
        </div>
    @endif
    
    <!-- Accounts Table -->
    <table class="table" id="coaTable">
        <thead>
            <tr>
                <th>Account Number</th>
                <th>Account Name</th>
                <th>Account Type</th> <!-- ✅ Tambahan -->
                <th>Role Area</th>
                <th>Initial Value</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accounts as $account)
                <tr id="account-{{ $account->id }}">
                    <td>{{ $account->id }}</td>
                    <td>{{ $account->name }}</td>
                    <td>{{ $account->type }}</td> <!-- ✅ Tambahan -->
                    <td>{{ ucfirst($account->role_area) }}</td>
                    <td>{{ number_format($account->nilai_awal, 2) }}</td>
                    <td>{{ $account->description ?? '-' }}</td>
                    <td>
                        <button type="button" onclick="editAccount({{ $account->id }})">Edit</button>
                        <button type="button" onclick="deleteAccount({{ $account->id }})" class="danger">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Pagination -->
    <div style="text-align: center; margin-top: 30px;">
        <p style="color: #718096; margin-bottom: 20px; font-weight: 600;">
            Showing {{ $accounts->firstItem() ?? 0 }} to {{ $accounts->lastItem() ?? 0 }} of {{ $accounts->total() }} accounts
        </p>
        {{ $accounts->links('pagination.custom') }}
    </div>
</div>

<script>
function editAccount(accountId) {
    const row = document.getElementById('account-' + accountId);
    const cells = row.getElementsByTagName('td');

    const accountNumber = cells[0].textContent;
    const accountName   = cells[1].textContent;
    const accountType   = cells[2].textContent; // ✅ ambil account type
    const roleArea      = cells[3].textContent.toLowerCase();
    const initialValue  = cells[4].textContent.replace(/,/g, '');
    const description   = cells[5].textContent === '-' ? '' : cells[5].textContent;

    document.getElementById('accountId').value = accountId;
    document.getElementById('account_number').value = accountNumber;
    document.getElementById('account_name').value = accountName;
    document.getElementById('account_type').value = accountType;
    document.getElementById('role_area').value = roleArea;
    document.getElementById('initial_value').value = initialValue;
    document.getElementById('description').value = description;

    document.getElementById('formTitle').textContent = 'Edit Account';
    document.getElementById('submitBtn').textContent = 'Update Account';
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('accountForm').action = '/coa/' + accountId;

    document.getElementById('accountForm').scrollIntoView({ behavior: 'smooth' });
}

function deleteAccount(accountId) {
    if (confirm('Are you sure you want to delete this account? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/coa/' + accountId;

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';

        form.appendChild(csrfInput);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}

function resetForm() {
    document.getElementById('accountForm').reset();
    document.getElementById('accountId').value = '';
    document.getElementById('formTitle').textContent = 'Add New Account';
    document.getElementById('submitBtn').textContent = 'Add Account';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('accountForm').action = '{{ route("coa.store") }}';
}
</script>

@endsection
