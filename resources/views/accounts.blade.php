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
        <p><strong>Total Saldo Akhir:</strong> Rp {{ isset($totalSaldo) ? number_format($totalSaldo,0,',','.') : '-' }}</p>

        <!-- Tombol Export -->
        <div style="margin: 15px 0;">
            <button onclick="exportToExcel()" 
                style="background:green; color:white; padding:6px 12px; border:none; cursor:pointer; border-radius:5px;">
                Export to Excel
            </button>
            <button onclick="exportToPDF()" 
                style="background:red; color:white; padding:6px 12px; border:none; cursor:pointer; border-radius:5px;">
                Export to PDF
            </button>
        </div>

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

<!-- SheetJS -->
<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
<!-- jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
<script>
    function exportToExcel() {
        // --- Account Info ---
        let accountInfo = [
            ["Account Info"],
            ["GL Account:", "{{ $selectedAccount->name ?? '-' }} ({{ $selectedAccount->type ?? '-' }})"],
            ["Description:", "{{ $selectedAccount->description ?? '-' }}"],
            ["Saldo Awal:", "Rp {{ isset($selectedAccount) ? number_format($selectedAccount->nilai_awal,0,',','.') : '-' }}"],
            ["Total Saldo Akhir:", "Rp {{ isset($totalSaldo) ? number_format($totalSaldo,0,',','.') : '-' }}"],
            [], // row kosong sebelum tabel
        ];

        // --- Ambil data tabel transaksi ---
        let table = document.getElementById("accountTransactionTable");
        let wsTransaksi = XLSX.utils.table_to_sheet(table);

        // --- Buat worksheet kosong ---
        let ws = XLSX.utils.aoa_to_sheet(accountInfo);

        // --- Sisipkan tabel mulai row ke-7 ---
        XLSX.utils.sheet_add_json(ws, XLSX.utils.sheet_to_json(wsTransaksi), { origin: "A7" });

        // --- Simpan ke file ---
        let wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Mutasi Transaksi");
        XLSX.writeFile(wb, 'account_transactions.xlsx');
    }

    function exportToPDF() {
        const { jsPDF } = window.jspdf;
        let doc = new jsPDF();

        // Account Info
        doc.setFontSize(12);
        doc.text("Account Info", 14, 15);
        doc.setFontSize(10);
        doc.text("GL Account: {{ $selectedAccount->name ?? '-' }} ({{ $selectedAccount->type ?? '-' }})", 14, 22);
        doc.text("Description: {{ $selectedAccount->description ?? '-' }}", 14, 28);
        doc.text("Saldo Awal: Rp {{ isset($selectedAccount) ? number_format($selectedAccount->nilai_awal,0,',','.') : '-' }}", 14, 34);
        doc.text("Total Saldo Akhir: Rp {{ isset($totalSaldo) ? number_format($totalSaldo,0,',','.') : '-' }}", 14, 40);

        // Tabel transaksi mulai setelah info
        doc.autoTable({
            html: '#accountTransactionTable',
            startY: 48,
            theme: 'grid',
            styles: { fontSize: 10 }
        });

        doc.save('account_transactions.pdf');
    }
</script>

@endsection
