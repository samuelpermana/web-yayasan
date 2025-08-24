@extends('layouts.app')

@section('content')
<div class="card">
    <h3>Journal Entries</h3>
    <!-- Filter Form -->
    <div style="margin-bottom: 15px; display:flex; flex-wrap:wrap; gap:10px; align-items:center;">
        <div>
            <label>Dari:</label>
            <input type="date" id="fromDate" onchange="applyFilters()">
        </div>
        <div>
            <label>Sampai:</label>
            <input type="date" id="toDate" onchange="applyFilters()">
        </div>
        <div>
            <label>Document No.:</label>
            <input type="text" id="docFilter" placeholder="Cari document no..." onkeyup="applyFilters()">
        </div>
        <div>
            <label>Description:</label>
            <input type="text" id="descFilter" placeholder="Cari deskripsi..." onkeyup="applyFilters()">
        </div>
        <div>
            <label>Debit Account:</label>
            <input type="text" id="debitFilter" placeholder="Cari debit..." onkeyup="applyFilters()">
        </div>
        <div>
            <label>Credit Account:</label>
            <input type="text" id="creditFilter" placeholder="Cari credit..." onkeyup="applyFilters()">
        </div>
    </div>

    <!-- Tombol Export Excel -->
    <div style="margin-bottom: 15px;">
        <button onclick="exportToExcel()" style="background:green; color:white; padding:6px 12px; border:none; cursor:pointer; border-radius:5px;">
            Export to Excel
        </button>
    </div>

    <table class="table" id="journalTable">
        <thead>
            <tr>
                <th>Document No.</th>
                <th>Date</th>
                <th>Account</th>
                <th>Description</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($journals as $journal)
                {{-- Baris Debit --}}
                <tr>
                    <td>{{ $journal->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($journal->transaction_date)->format('Y-m-d') }}</td>
                    <td>{{ $journal->debitAccount?->name ?? '-' }}</td>
                    <td>{{ $journal->description }}</td>
                    <td>{{ $journal->debitAccount ? number_format($journal->amount, 0, ',', '.') : '' }}</td>
                    <td></td>
                    <td rowspan="2" style="vertical-align: middle; text-align: center;">
                        <a href="{{ route('journal.edit', $journal->id) }}">
                            <button type="button" title="Edit">Edit</button>
                        </a>
                        <button type="button" title="Print"
                            onclick="openPrintModal(
                                '{{ $journal->id }}',
                                '{{ \Carbon\Carbon::parse($journal->transaction_date)->format('d-m-Y') }}',
                                '{{ $journal->description }}',
                                '{{ $journal->paid_to_source ?? '-' }}',
                                '{{ $journal->debitAccount?->id ?? '-' }}',
                                '{{ $journal->debitAccount?->name ?? '-' }}',
                                '{{ $journal->creditAccount?->id ?? '-' }}',
                                '{{ $journal->creditAccount?->name ?? '-' }}',
                                '{{ number_format($journal->amount, 0, ',', '.') }}',
                                '{{ $journal->debit_dk_reference ?? '40' }}',
                                '{{ $journal->credit_dk_reference ?? '50' }}'
                            )">
                            Print
                        </button>
                    </td>
                </tr>

                {{-- Baris Credit --}}
                <tr>
                    <td>{{ $journal->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($journal->transaction_date)->format('Y-m-d') }}</td>
                    <td>{{ $journal->creditAccount?->name ?? '-' }}</td>
                    <td>{{ $journal->description }}</td>
                    <td></td>
                    <td>{{ $journal->creditAccount ? number_format($journal->amount, 0, ',', '.') : '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


<!-- Modal Print -->
<div id="printModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
    <div class="modal-content" style="background:#fff; padding:20px; margin:50px auto; width:70%; max-width:800px; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.3); position:relative;">
        <span class="close" style="position:absolute; top:10px; right:15px; cursor:pointer; font-size:20px; font-weight:bold;" onclick="closePrintModal()">&times;</span>
        <div id="printArea"></div>
        <div style="text-align:right; margin-top:20px;">
            <button onclick="printPDF()" style="background:blue; color:white; padding:6px 12px; border:none; cursor:pointer; border-radius:5px;">Print</button>
        </div>
    </div>
</div>

<!-- SheetJS -->
<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>

<script>
    function applyFilters() {
        const fromDate = document.getElementById("fromDate").value;
        const toDate = document.getElementById("toDate").value;
        const docFilter = document.getElementById("docFilter").value.toLowerCase();
        const descFilter = document.getElementById("descFilter").value.toLowerCase();
        const debitFilter = document.getElementById("debitFilter").value.toLowerCase();
        const creditFilter = document.getElementById("creditFilter").value.toLowerCase();

        const rows = document.querySelectorAll("#journalTable tbody tr");

        rows.forEach(row => {
            const docNo = row.cells[0].innerText.toLowerCase();
            const date = row.cells[1].innerText.trim();
            const account = row.cells[2].innerText.toLowerCase();
            const desc = row.cells[3].innerText.toLowerCase();
            const debit = row.cells[4].innerText.toLowerCase();
            const credit = row.cells[5].innerText.toLowerCase();

            let show = true;

            if (fromDate && date < fromDate) show = false;
            if (toDate && date > toDate) show = false;
            if (docFilter && !docNo.includes(docFilter)) show = false;
            if (descFilter && !desc.includes(descFilter)) show = false;
            if (debitFilter && !account.includes(debitFilter)) show = false;
            if (creditFilter && !account.includes(creditFilter)) show = false;

            row.style.display = show ? "" : "none";
        });
    }
    
    function exportToExcel() {
        let table = document.getElementById("journalTable");
        let clonedTable = table.cloneNode(true);
        let rows = clonedTable.querySelectorAll("tbody tr");

        rows.forEach(row => {
            if (row.style.display === "none") row.remove();
            // hapus kolom Action
            if (row.cells.length > 6) {
                row.deleteCell(6);
            }
            // konversi angka agar tidak salah parsing
            row.querySelectorAll("td").forEach((cell, index) => {
                let text = cell.innerText.trim();

                // cek kalau angka (pakai . sebagai pemisah ribuan)
                if (/^[\d.]+$/.test(text)) {
                    // hapus titik → biar jadi angka asli
                    let num = parseInt(text.replace(/\./g, ""), 10);
                    cell.innerText = num;
                }
            });
        });

        // hapus header kolom Action
        clonedTable.querySelector("thead tr th:last-child").remove();

        // buat workbook
        let wb = XLSX.utils.table_to_book(clonedTable, { sheet: "Journal Entries" });

        // tulis file
        XLSX.writeFile(wb, 'journal_entries.xlsx');
    }


    // ===== Modal Print =====
    function openPrintModal(id, date, desc, paidTo, debitId, debitName, creditId, creditName, amount, debitDK, creditDK) {
        const printHtml = `
            <div class="print-form">
                <h2 style="text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px;">BUKTI TRANSAKSI</h2>
                <div style="margin-bottom: 20px;"><strong>NO. ${id}</strong></div>
                <div style="margin-bottom: 20px;"><strong>DIBAYAR KEPADA:</strong> ${paidTo}</div>
                <div style="margin-bottom: 30px;"><strong>JUMLAH:</strong> Rp ${amount}</div>
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
                    <thead>
                        <tr style="border: 1px solid #333;">
                            <th style="border: 1px solid #333; padding: 10px;">NO. GL ACCOUNT</th>
                            <th style="border: 1px solid #333; padding: 10px;">D/K</th>
                            <th style="border: 1px solid #333; padding: 10px;">KETERANGAN</th>
                            <th style="border: 1px solid #333; padding: 10px;">SUB TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border: 1px solid #333;">
                            <td style="border: 1px solid #333; padding: 10px;">${debitId}</td>
                            <td style="border: 1px solid #333; padding: 10px; text-align: center;">${debitDK}</td>
                            <td style="border: 1px solid #333; padding: 10px;">${debitName}</td>
                            <td style="border: 1px solid #333; padding: 10px; text-align: right;">Rp ${amount}</td>
                        </tr>
                        <tr style="border: 1px solid #333;">
                            <td style="border: 1px solid #333; padding: 10px;">${creditId}</td>
                            <td style="border: 1px solid #333; padding: 10px; text-align: center;">${creditDK}</td>
                            <td style="border: 1px solid #333; padding: 10px;">${creditName}</td>
                            <td style="border: 1px solid #333; padding: 10px; text-align: right;">Rp ${amount}</td>
                        </tr>
                    </tbody>
                </table>
                <div style="margin-bottom: 30px;"><strong>Keterangan:</strong> ${desc}</div>
                <div style="text-align: right; margin-bottom: 50px;"><strong>TANGGAL, ${date}</strong></div>
                <div style="display: flex; justify-content: space-between;">
                    <div style="text-align: center; width: 200px;"><div style="border-bottom: 1px solid #333; height: 80px; margin-bottom: 10px;"></div><strong>DIBUAT OLEH</strong></div>
                    <div style="text-align: center; width: 200px;"><div style="border-bottom: 1px solid #333; height: 80px; margin-bottom: 10px;"></div><strong>FINANCE ACCOUNTING</strong></div>
                    <div style="text-align: center; width: 200px;"><div style="border-bottom: 1px solid #333; height: 80px; margin-bottom: 10px;"></div><strong>DISETUJUI OLEH</strong></div>
                </div>
            </div>`;
        document.getElementById('printArea').innerHTML = printHtml;
        document.getElementById('printModal').style.display = 'block';
    }

    function closePrintModal() {
        document.getElementById('printModal').style.display = 'none';
    }

    function printPDF() {
        let printContents = document.getElementById('printArea').innerHTML;
        let newWin = window.open('', '', 'width=800,height=600');
        newWin.document.write('<html><head><title>Bukti Transaksi</title></head><body>');
        newWin.document.write(printContents);
        newWin.document.write('</body></html>');
        newWin.document.close();
        newWin.print();
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
@endsection
