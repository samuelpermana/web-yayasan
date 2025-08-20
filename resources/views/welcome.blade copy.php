<!-- Transaction Tab -->
<div id="transaction-entry" class="tab-content">
    <div class="card">
        <h3>Transaction Entry</h3>
        <form id="transactionForm">
            @csrf
            <!-- Row 1: Date & Transaction Master -->
            <div class="form-row">
                <div class="form-group">
                    <label for="transactionDate">Date</label>
                    <input type="date" id="transactionDate" required>
                </div>
                <div class="form-group">
                    <label for="transactionMaster">Transaction Master</label>
                    <select id="transactionMaster">
                        <option value="">Select Transaction Master</option>
                        @foreach($deposit_masters as $deposit_master)
                            <option value="{{ $deposit_master->id }}"
                                    data-description="{{ $deposit_master->description }}"
                                    data-amount="{{ $deposit_master->default_amount }}">
                                {{ $deposit_master->id }} - {{ $deposit_master->description }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Row 2: Description & Amount -->
            <div class="form-row">
                <div class="form-group">
                    <label for="transactionDescription">Description</label>
                    <input type="text" id="transactionDescription" required>
                </div>
                <div class="form-group">
                    <label for="transactionAmount">Amount</label>
                    <input type="number" id="transactionAmount" step="0.01" required>
                </div>
            </div>

            <!-- Row 3: Credit & Debit Account -->
            <div class="form-row">
                <div class="form-group">
                    <label for="creditAccount">Credit Account</label>
                    <select id="creditAccount">
                        <option value="">Select Credit Account</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}" data-type="{{ $account->type }}">
                                {{ $account->id }} - {{ $account->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="debitAccount">Debit Account</label>
                    <select id="debitAccount">
                        <option value="">Select Debit Account</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}" data-type="{{ $account->type }}">
                                {{ $account->id }} - {{ $account->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Row 4: From/To -->
            <div class="form-row">
                <div class="form-group">
                    <label for="transactionFromTo">Received from / Paid to</label>
                    <input type="text" id="transactionFromTo" placeholder="Enter name or source" required>
                </div>
            </div>

            <button type="submit">Post Income Transaction</button>
            <button type="button" onclick="generateTransactionForm()">Generate Expense Form</button>
            <button type="button" onclick="showModal('depositModal')">Manage Deposit Master</button>
        </form>

        <!-- Bukti transaksi -->
        <div id="transactionReceipt" style="display:none; border:1px solid #ccc; padding:15px; margin-top:20px;">
            <h3>Bukti Transaksi</h3>
            <p><strong>Voucher:</strong> <span id="receiptVoucher"></span></p>
            <p><strong>Tanggal:</strong> <span id="receiptDate"></span></p>
            <p><strong>Deskripsi:</strong> <span id="receiptDescription"></span></p>
            <p><strong>Jumlah:</strong> Rp <span id="receiptAmount"></span></p>
            <p><strong>Dari/Kepada:</strong> <span id="receiptFromTo"></span></p>
            <p><strong>Akun Kredit:</strong> <span id="receiptCredit"></span></p>
            <p><strong>Akun Debit:</strong> <span id="receiptDebit"></span></p>
            <button onclick="window.print()">🖨️ Print</button>
        </div>
    </div>
</div>

<script>
    // Auto-fill description & amount from Transaction Master
    document.getElementById("transactionMaster").addEventListener("change", function() {
        const selected = this.options[this.selectedIndex];
        document.getElementById("transactionDescription").value = selected.dataset.description || '';
        document.getElementById("transactionAmount").value = selected.dataset.amount || '';
    });

    // AJAX submit form
    document.getElementById("transactionForm").addEventListener("submit", function(e) {
        e.preventDefault();

        const formData = {
            _token: '{{ csrf_token() }}',
            date: document.getElementById("transactionDate").value,
            deposit_master_id: document.getElementById("transactionMaster").value,
            description: document.getElementById("transactionDescription").value,
            amount: document.getElementById("transactionAmount").value,
            credit_account_id: document.getElementById("creditAccount").value,
            debit_account_id: document.getElementById("debitAccount").value,
            from_to: document.getElementById("transactionFromTo").value,
        };

        fetch("{{ route('transactions.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": formData._token,
            },
            body: JSON.stringify(formData),
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Tampilkan bukti transaksi
                document.getElementById("receiptVoucher").innerText = data.transaction.voucher_number;
                document.getElementById("receiptDate").innerText = data.transaction.date;
                document.getElementById("receiptDescription").innerText = data.transaction.description;
                document.getElementById("receiptAmount").innerText = data.transaction.amount;
                document.getElementById("receiptFromTo").innerText = data.transaction.from_to;
                document.getElementById("receiptCredit").innerText = data.credit_account.name;
                document.getElementById("receiptDebit").innerText = data.debit_account.name;

                document.getElementById("transactionReceipt").style.display = "block";

                alert("Transaksi berhasil ditambahkan!");
            } else {
                alert("Gagal menyimpan transaksi.");
            }
        })
        .catch(err => {
            console.error(err);
            alert("Terjadi kesalahan.");
        });
    });

    // Placeholder fungsi generateTransactionForm
    function generateTransactionForm() {
        alert('Fungsi generate expense form belum diimplementasikan');
    }

    function showModal(modalId) {
        alert('Fungsi showModal("' + modalId + '") belum diimplementasikan');
    }
</script>
