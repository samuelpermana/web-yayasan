@extends('layouts.app')

@section('content')
<div id="dashboard" class="tab-content active">
    @include('partials.dashboard-buttons')
    @include('partials.stats')


    <div class="card">
        <h3>Recent Transactions (Mahad)</h3>

        <!-- Filter Form -->
        <div class="card">
            <h4 style="margin-bottom: 20px; color: #4a5568;">Filter Transactions</h4>

            <form method="GET" action="{{ route('dashboard.yayasan') }}" id="filterForm">
                <div class="form-row">
                    <!-- Date From -->
                    <div class="form-group">
                        <label for="date_from">Dari:</label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}">
                    </div>

                    <!-- Date To -->
                    <div class="form-group">
                        <label for="date_to">Sampai:</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}">
                    </div>
                </div>

                <div class="form-row">
                    <!-- Description Filter -->
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <input type="text" name="description" id="description" placeholder="Cari deskripsi..."
                            value="{{ request('description') }}">
                    </div>

                    <!-- Debit Account Filter -->
                    <div class="form-group">
                        <label for="debit_account_id">Debit Account:</label>
                        <select name="debit_account_id" id="debit_account_id">
                            <option value="">Cari debit...</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}"
                                    {{ request('debit_account_id') == $account->id ? 'selected' : '' }}>
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
                                    {{ request('credit_account_id') == $account->id ? 'selected' : '' }}>
                                    {{ $account->id }} - {{ $account->name }} ({{ $account->type }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="form-group" style="display: flex; align-items: end; gap: 10px;">
                        <button type="submit">Filter</button>

                        <a href="{{ route('dashboard.yayasan') }}" style="text-decoration: none;">
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
                    <th>GL Account</th>
                    <th>Area</th>
                    <th>Description</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                @php
                    // Tracking saldo per account
                    $saldoPerAccount = [];
                @endphp

                @foreach($transactions as $trx)
                    @php
                        $debitAccount  = $trx->debitAccount;
                        $creditAccount = $trx->creditAccount;
                    @endphp

                    {{-- Baris Debit --}}
                    <tr>
                        <td>{{ $trx->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($trx->transaction_date)->format('d-m-Y') }}</td>
                        <td>
                            @if($debitAccount)
                                {{ $debitAccount->id }} - {{ $debitAccount->name }}
                                ({{ $debitAccount->type }}, {{ $debitAccount->role_area }})
                            @else
                                -
                            @endif
                        </td>


                        {{-- Area pakai rowspan --}}
                        <td rowspan="2" style="vertical-align: middle; text-align: center;">
                            {{ $trx->role_area }}
                        </td>

                        <td>{{ $trx->description }}</td>
                        <td>{{ $debitAccount ? number_format($trx->amount, 0, ',', '.') : '' }}</td>
                        <td></td>

                        @php
                            if ($debitAccount) {
                                if (!isset($saldoPerAccount[$debitAccount->id])) {
                                    $saldoPerAccount[$debitAccount->id] = $debitAccount->nilai_awal ?? 0;
                                }

                                // 🔑 Cek jenis akun
                                if (in_array($debitAccount->type, ['Asset','Expense'])) {
                                    $saldoPerAccount[$debitAccount->id] += $trx->amount; // debit menambah
                                } else {
                                    $saldoPerAccount[$debitAccount->id] -= $trx->amount; // debit mengurangi
                                }
                            }
                        @endphp

                        <td>
                            {{ $debitAccount ? 'Rp ' . number_format($saldoPerAccount[$debitAccount->id], 0, ',', '.') : '-' }}
                        </td>
                    </tr>

                    {{-- Baris Credit --}}
                    <tr>
                        <td>{{ $trx->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($trx->transaction_date)->format('d-m-Y') }}</td>
                        <td>
                            @if($creditAccount)
                                {{ $creditAccount->id }} - {{ $creditAccount->name }}
                                ({{ $creditAccount->type }}, {{ $creditAccount->role_area }})
                            @else
                                -
                            @endif
                        </td>

                        <td>{{ $trx->description }}</td>
                        <td></td>
                        <td>{{ $creditAccount ? number_format($trx->amount, 0, ',', '.') : '' }}</td>

                        @php
                            if ($creditAccount) {
                                if (!isset($saldoPerAccount[$creditAccount->id])) {
                                    $saldoPerAccount[$creditAccount->id] = $creditAccount->nilai_awal ?? 0;
                                }

                                // 🔑 Cek jenis akun
                                if (in_array($creditAccount->type, ['Liability','Equity','Revenue'])) {
                                    $saldoPerAccount[$creditAccount->id] += $trx->amount; // credit menambah
                                } else {
                                    $saldoPerAccount[$creditAccount->id] -= $trx->amount; // credit mengurangi
                                }
                            }
                        @endphp

                        <td>
                            {{ $creditAccount ? 'Rp ' . number_format($saldoPerAccount[$creditAccount->id], 0, ',', '.') : '-' }}
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>



        <!-- Pagination -->
        <div style="text-align: center; margin-top: 30px;">
            <p style="color: #718096; margin-bottom: 20px; font-weight: 600;">
                Showing {{ $transactions->firstItem() ?? 0 }} to {{ $transactions->lastItem() ?? 0 }} of
                {{ $transactions->total() }} results
            </p>
            {{ $transactions->links('pagination.custom') }}
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const exportBtn = document.getElementById('exportBtn');
        exportBtn.addEventListener('click', function() {
            const form = document.getElementById('filterForm');
            const formData = new FormData(form);

            const params = new URLSearchParams();
            for (let [key, value] of formData.entries()) {
                if (value.trim() !== '') {
                    params.append(key, value);
                }
            }

            // Export khusus Mahad
            const exportUrl = '{{ route("transactions.export") }}' + '?' + params.toString();
            window.open(exportUrl, '_blank');
        });
    });
</script>
@endsection
