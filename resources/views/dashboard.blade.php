@extends('layouts.app')

@section('content')
<div id="dashboard" class="tab-content active">
    @include('partials.stats')

    <div class="card">
        <h3>Recent Transactions</h3>
        
        <!-- Filter Form -->
        <div class="card">
            <h4 style="margin-bottom: 20px; color: #4a5568;">Filter Transactions</h4>
            <form method="GET" action="@auth @if(auth()->user()->type === 'admin') {{ route('dashboard') }} @else {{ route('user.dashboard') }} @endif @endauth" id="filterForm">
                <div class="form-row">
                    <!-- Date From -->
                    <div class="form-group">
                        <label for="date_from">Dari:</label>
                        <input type="date" 
                               name="date_from" 
                               id="date_from" 
                               value="{{ $filters['date_from'] ?? '' }}">
                    </div>
                    
                    <!-- Date To -->
                    <div class="form-group">
                        <label for="date_to">Sampai:</label>
                        <input type="date" 
                               name="date_to" 
                               id="date_to" 
                               value="{{ $filters['date_to'] ?? '' }}">
                    </div>
                </div>
                
                <div class="form-row">
                    <!-- Description Filter -->
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <input type="text" 
                               name="description" 
                               id="description" 
                               placeholder="Cari deskripsi..."
                               value="{{ $filters['description'] ?? '' }}">
                    </div>
                    
                    <!-- Debit Account Filter -->
                    <div class="form-group">
                        <label for="debit_account_id">Debit Account:</label>
                        <select name="debit_account_id" id="debit_account_id">
                            <option value="">Cari debit...</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}" 
                                        {{ ($filters['debit_account_id'] ?? '') == $account->id ? 'selected' : '' }}>
                                    {{ $account->id }} - {{ $account->name }} ({{ $account->type }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <!-- Credit Account Filter -->
                    <div class="form-group">
                        <label for="credit_account_id">Credit Account:</label>
                        <select name="credit_account_id" id="credit_account_id">
                            <option value="">Cari credit...</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}" 
                                        {{ ($filters['credit_account_id'] ?? '') == $account->id ? 'selected' : '' }}>
                                    {{ $account->id }} - {{ $account->name }} ({{ $account->type }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="form-group" style="display: flex; align-items: end; gap: 10px;">
                        <button type="submit">Filter</button>
                        <a href="@auth @if(auth()->user()->type === 'admin') {{ route('dashboard') }} @else {{ route('user.dashboard') }} @endif @endauth" style="text-decoration: none;">
                            <button type="button" style="background: linear-gradient(135deg, #718096, #4a5568);">Reset</button>
                        </a>
                        <button type="button" id="exportBtn" class="secondary">Export to Excel</button>
                    </div>
                </div>
            </form>
        </div>
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
        
        <!-- Pagination -->
        <div style="text-align: center; margin-top: 30px;">
            <p style="color: #718096; margin-bottom: 20px; font-weight: 600;">
                Showing {{ $recentTransactions->firstItem() ?? 0 }} to {{ $recentTransactions->lastItem() ?? 0 }} of {{ $recentTransactions->total() }} results
            </p>
            {{ $recentTransactions->links('pagination.custom') }}
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const exportBtn = document.getElementById('exportBtn');
    
    exportBtn.addEventListener('click', function() {
        // Get current filter values
        const form = document.getElementById('filterForm');
        const formData = new FormData(form);
        
        // Build query string with current filters
        const params = new URLSearchParams();
        for (let [key, value] of formData.entries()) {
            if (value.trim() !== '') {
                params.append(key, value);
            }
        }
        
        // Create export URL with filters (check user role)
        @auth
            @if(auth()->user()->type === 'admin')
                const exportUrl = '{{ route("transactions.export") }}' + '?' + params.toString();
            @else
                const exportUrl = '{{ route("user.transactions.export") }}' + '?' + params.toString();
            @endif
        @endauth
        
        // Trigger download
        window.open(exportUrl, '_blank');
    });
});
</script>

@endsection
