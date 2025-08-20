
        // Global variables
        let transactions = [];
        let journalEntries = [];
        let depositMaster = [];
        let documentCounter = 1;
        
        // Chart of Accounts based on provided data
        const chartOfAccounts = [
            {number: '1100100', name: 'Kas', description: 'Transaksi untuk pembayaran dan penerimaan uang melalui Kas', type: 'Asset'},
            {number: '1100101', name: 'Money Intransit', description: 'Transaksi Kas penampungan atas penerimaan dan pengeluaran', type: 'Asset'},
            {number: '1200100', name: 'Bank BSI', description: 'Transaksi untuk pembayaran dan penerimaan uang melalui Transfer bank', type: 'Asset'},
            {number: '1300100', name: 'Deposito Bank BSI', description: 'Penempatan Deposito melalui bank', type: 'Asset'},
            {number: '1400100', name: 'Piutang Karyawan', description: 'Piutang ke karyawan atas yang belum terima pembayarannya', type: 'Asset'},
            {number: '1400101', name: 'Piutang Lain-Lain', description: 'Piutang ke pihak ke tiga atas yang belum terima pembayarannya', type: 'Asset'},
            {number: '1500100', name: 'Uang Muka', description: 'Transaksi Uang muka untuk biaya operasional kantor', type: 'Asset'},
            {number: '2100100', name: 'Asset Bangunan', description: 'Transaksi untuk pembangunan gedung', type: 'Asset'},
            {number: '2200100', name: 'Asset Computer', description: 'Transaksi untuk pembelian Computer dan sejenis nya', type: 'Asset'},
            {number: '2300100', name: 'Asset Furniture', description: 'Transaksi untuk pembelian meja,kursi dan sejenis nya', type: 'Asset'},
            {number: '2400100', name: 'Asset Transportasi', description: 'Transaksi untuk pembelian alat-alat transportasi', type: 'Asset'},
            {number: '2900100', name: 'Pinjaman Koperasi', description: 'Pinjaman uang atau barang melalaui koperasi', type: 'Liability'},
            {number: '3100100', name: 'Titipan', description: 'Transaksi atas titipan Uang kepada pihak pertama', type: 'Liability'},
            {number: '4100100', name: 'Hutang Dagang', description: 'Hutang ke pihak ke tiga atas hutang yang belum di bayarkan', type: 'Liability'},
            {number: '6100100', name: 'Pendapatan SPP', description: 'Transaksi atas penerimaan SPP dan Daftar ulang santri', type: 'Income'},
            {number: '6100101', name: 'Pendapatan Lain-lain', description: 'Transaksi atas penerimaan Lain-lain', type: 'Income'},
            {number: '7100101', name: 'Biaya Gaji', description: 'Transaksi atas pembayaran gaji karyawan', type: 'Expense'},
            {number: '7100102', name: 'Biaya Lembur', description: 'Transaksi atas pembayaran lembur karyawan', type: 'Expense'},
            {number: '7100103', name: 'Biaya Transportasi', description: 'Transaksi atas biaya-biaya terkait dengan transportasi', type: 'Expense'},
            {number: '7100104', name: 'Biaya Pengobatan', description: 'Transaksi atas pengobatan karyawan dan Santri', type: 'Expense'},
            {number: '7100105', name: 'Biaya THR', description: 'Transaksi atas pembayaran THR karyawan', type: 'Expense'},
            {number: '7100106', name: 'Biaya Astek', description: 'Transaksi atas pembayaran Astek karyawan', type: 'Expense'},
            {number: '7100107', name: 'Biaya BPJS', description: 'Transaksi atas pembayaran BPJS karyawan', type: 'Expense'},
            {number: '7100108', name: 'Biaya Training', description: 'Transaksi atas pembayaran Training karyawan', type: 'Expense'},
            {number: '7100109', name: 'Biaya Rumah Sakit', description: 'Transaksi atas pembayaran Rumah sakit karyawan', type: 'Expense'},
            {number: '7100110', name: 'Biaya PBB', description: 'Transaksi atas pembayaran PBB', type: 'Expense'},
            {number: '7100111', name: 'Biaya Makan dan Minum', description: 'Transaksi atas pembayaran Makan dan minum', type: 'Expense'},
            {number: '7100112', name: 'Biaya Pembelian ATK', description: 'Transaksi atas pembayaran pembelian ATK', type: 'Expense'},
            {number: '7100113', name: 'Biaya Listrik', description: 'Transaksi atas pembayaran Listrik', type: 'Expense'},
            {number: '7100114', name: 'Biaya Maintenance', description: 'Transaksi atas pembayaran pemeliharaan gedung dan sejenis nya', type: 'Expense'},
            {number: '7100115', name: 'Biaya Telephone', description: 'Transaksi atas pembayaran Telephone kantor', type: 'Expense'},
            {number: '7100116', name: 'Biaya Internet', description: 'Transaksi atas pembayaran Internet kantor', type: 'Expense'},
            {number: '7100117', name: 'Biaya Foto copy', description: 'Transaksi atas pembayaran Foto copy dan sejenis nya', type: 'Expense'},
            {number: '7100118', name: 'Biaya Pengiriman', description: 'Transaksi atas pembayaran pengirima barang dan sejenis nya', type: 'Expense'},
            {number: '7100119', name: 'Biaya Pengamanan', description: 'Transaksi atas pembayaran keamanan dan termasuk gaji security nya', type: 'Expense'},
            {number: '7100120', name: 'Biaya Pemakaian air PAM', description: 'Transaksi atas pembayaran pemakaian air PAM', type: 'Expense'},
            {number: '7100121', name: 'Biaya Ifthor Puasa', description: 'Transaksi atas pemberian makan buka puasa', type: 'Expense'},
            {number: '7100122', name: 'Biaya Ujian', description: 'Transaksi atas biaya ujian', type: 'Expense'},
            {number: '7100123', name: 'Biaya PPDB', description: 'Transaksi atas biaya PPDB', type: 'Expense'},
            {number: '7100124', name: 'Biaya Cetakan', description: 'Transaksi atas pembayaran pencetakan', type: 'Expense'},
            {number: '7100125', name: 'Biaya Kegiatan santri', description: 'Transaksi atas Outing Guru dan Santri', type: 'Expense'},
            {number: '7100126', name: 'Biaya Konsumsi', description: 'Transaksi atas pembayaran konsumsi', type: 'Expense'},
            {number: '7100200', name: 'Biaya Bank', description: 'Transaksi atas pemdebitan biaya administrasi bank', type: 'Expense'},
            {number: '7100999', name: 'Biaya Lain-lain', description: 'Transaksi atas pembayaran biaya oprasional lain-lain nya', type: 'Expense'},
            {number: '8100100', name: 'Bunga Bank BSI', description: 'Pendapatan bunga bank', type: 'Income'}
        ];

        // Initialize the application
        document.addEventListener('DOMContentLoaded', function() {
            initializeApp();
            setDefaultDates();
        });

        function initializeApp() {
            populateAccountDropdowns();
            // populateCOATable();
            loadDepositMaster();
            updateDashboard();
            
            // Set up form event listeners
            document.getElementById('incomeForm').addEventListener('submit', handleIncomeSubmit);
            document.getElementById('transactionForm').addEventListener('submit', handleExpenseSubmit);
            document.getElementById('depositForm').addEventListener('submit', handleDepositSubmit);
        }

        function setDefaultDates() {
            const today = new Date().toISOString().split('T')[0];
            const currentMonth = new Date().toISOString().slice(0, 7);
            
            document.getElementById('incomeDate').value = today;
            document.getElementById('expenseDate').value = today;
            document.getElementById('accountDateRange').value = currentMonth;
            document.getElementById('reportPeriod').value = currentMonth;
            document.getElementById('balanceStartDate').value = today;
            document.getElementById('balanceEndDate').value = today;
        }

        function showTab(tabName) {
            // Hide all tabs
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => tab.classList.remove('active'));
            
            // Remove active class from all nav tabs
            const navTabs = document.querySelectorAll('.nav-tab');
            navTabs.forEach(tab => tab.classList.remove('active'));
            
            // Show selected tab
            document.getElementById(tabName).classList.add('active');
            event.target.classList.add('active');
        }


        function filterCOA(searchTerm) {
            const rows = document.querySelectorAll('#coaTable tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm.toLowerCase()) ? '' : 'none';
            });
        }

        function generateDocumentNumber() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            const counter = String(documentCounter++).padStart(4, '0');
            return `DOC${year}${month}${day}${counter}`;
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount);
        }

        function handleIncomeSubmit(e) {
            e.preventDefault();
            
            const formData = {
                date: document.getElementById('incomeDate').value,
                depositId: document.getElementById('incomeDepositId').value,
                description: document.getElementById('incomeDescription').value,
                amount: parseFloat(document.getElementById('incomeAmount').value),
                creditSource: document.getElementById('incomeCreditSource').value,
                incomeAccount: document.getElementById('incomeAccount').value
            };

            if (!formData.amount || formData.amount <= 0) {
                showAlert('Amount must be greater than 0', 'error');
                return;
            }

            const docNumber = generateDocumentNumber();
            
            // Create journal entries
            const creditSourceAccount = chartOfAccounts.find(acc => acc.number === formData.creditSource);
            const incomeAccount = chartOfAccounts.find(acc => acc.number === formData.incomeAccount);

            const journalEntry1 = {
                documentNumber: docNumber,
                date: formData.date,
                account: formData.creditSource,
                accountName: creditSourceAccount.name,
                description: formData.description,
                debit: formData.amount,
                credit: 0,
                type: 'Income',
                status: 'Posted'
            };

            const journalEntry2 = {
                documentNumber: docNumber,
                date: formData.date,
                account: formData.incomeAccount,
                accountName: incomeAccount.name,
                description: formData.description,
                debit: 0,
                credit: formData.amount,
                type: 'Income',
                status: 'Posted'
            };

            journalEntries.push(journalEntry1, journalEntry2);
            transactions.push({
                ...formData,
                documentNumber: docNumber,
                type: 'Income'
            });

            updateJournalTable();
            updateDashboard();
            showAlert('Income transaction posted successfully!', 'success');
            document.getElementById('incomeForm').reset();
            setDefaultDates();
        }

        function handleExpenseSubmit(e) {
            e.preventDefault();
            
            const formData = {
                date: document.getElementById('expenseDate').value,
                paidTo: document.getElementById('expenseTo').value,
                description: document.getElementById('expenseDescription').value,
                amount: parseFloat(document.getElementById('expenseAmount').value),
                expenseAccount: document.getElementById('expenseAccount').value,
                paymentMethod: document.getElementById('expensePaymentMethod').value
            };

            if (!formData.amount || formData.amount <= 0) {
                showAlert('Amount must be greater than 0', 'error');
                return;
            }

            const docNumber = generateDocumentNumber();
            
            // Create journal entries
            const expenseAccount = chartOfAccounts.find(acc => acc.number === formData.expenseAccount);
            const paymentAccount = chartOfAccounts.find(acc => acc.number === formData.paymentMethod);

            const journalEntry1 = {
                documentNumber: docNumber,
                date: formData.date,
                account: formData.expenseAccount,
                accountName: expenseAccount.name,
                description: formData.description,
                debit: formData.amount,
                credit: 0,
                type: 'Expense',
                status: 'Posted'
            };

            const journalEntry2 = {
                documentNumber: docNumber,
                date: formData.date,
                account: formData.paymentMethod,
                accountName: paymentAccount.name,
                description: formData.description,
                debit: 0,
                credit: formData.amount,
                type: 'Expense',
                status: 'Posted'
            };

            journalEntries.push(journalEntry1, journalEntry2);
            transactions.push({
                ...formData,
                documentNumber: docNumber,
                type: 'Expense'
            });

            updateJournalTable();
            updateDashboard();
            showAlert('Expense transaction posted successfully!', 'success');
            document.getElementById('expenseForm').reset();
            setDefaultDates();
        }

        function updateJournalTable() {
            const tbody = document.querySelector('#journalTable tbody');
            tbody.innerHTML = '';

            journalEntries.forEach(entry => {
                const row = tbody.insertRow();
                row.innerHTML = `
                    <td><strong>${entry.documentNumber}</strong></td>
                    <td>${new Date(entry.date).toLocaleDateString('id-ID')}</td>
                    <td>${entry.account} - ${entry.accountName}</td>
                    <td>${entry.description}</td>
                    <td class="amount ${entry.debit > 0 ? 'debit' : ''}">${entry.debit > 0 ? formatCurrency(entry.debit) : '-'}</td>
                    <td class="amount ${entry.credit > 0 ? 'credit' : ''}">${entry.credit > 0 ? formatCurrency(entry.credit) : '-'}</td>
                    <td><span class="status ${entry.status.toLowerCase()}">${entry.status}</span></td>
                `;
            });
        }

        function updateDashboard() {
            const totalIncome = transactions
                .filter(t => t.type === 'Income')
                .reduce((sum, t) => sum + t.amount, 0);
            
            const totalExpense = transactions
                .filter(t => t.type === 'Expense')
                .reduce((sum, t) => sum + t.amount, 0);
            
            const netBalance = totalIncome - totalExpense;
            const totalTransactionCount = transactions.length;

            document.getElementById('totalIncome').textContent = formatCurrency(totalIncome);
            document.getElementById('totalExpense').textContent = formatCurrency(totalExpense);
            document.getElementById('netBalance').textContent = formatCurrency(netBalance);
            document.getElementById('totalTransactions').textContent = totalTransactionCount;

            // Update recent transactions table
            const recentTbody = document.querySelector('#recentTransactions tbody');
            recentTbody.innerHTML = '';

            const recentTransactions = transactions.slice(-10).reverse();
            recentTransactions.forEach(transaction => {
                const row = recentTbody.insertRow();
                row.innerHTML = `
                    <td><strong>${transaction.documentNumber}</strong></td>
                    <td>${new Date(transaction.date).toLocaleDateString('id-ID')}</td>
                    <td>${transaction.description}</td>
                    <td>${transaction.type === 'Income' ? transaction.incomeAccount : transaction.expenseAccount}</td>
                    <td class="amount">${formatCurrency(transaction.amount)}</td>
                    <td><span class="status ${transaction.type.toLowerCase()}">${transaction.type}</span></td>
                `;
            });
        }

        function filterJournalEntries(searchTerm) {
            const rows = document.querySelectorAll('#journalTable tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm.toLowerCase()) ? '' : 'none';
            });
        }

        function displayAccountTransactions() {
            const accountNumber = document.getElementById('accountSelect').value;
            const dateRange = document.getElementById('accountDateRange').value;
            
            if (!accountNumber) {
                document.getElementById('accountTransactions').innerHTML = '';
                return;
            }

            const account = chartOfAccounts.find(acc => acc.number === accountNumber);
            const filteredEntries = journalEntries.filter(entry => {
                const entryDate = new Date(entry.date);
                const entryMonth = entryDate.getFullYear() + '-' + String(entryDate.getMonth() + 1).padStart(2, '0');
                
                return entry.account === accountNumber && (!dateRange || entryMonth === dateRange);
            });

            let html = `
                <div class="card">
                    <h4>Account: ${accountNumber} - ${account.name}</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Document No.</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            let runningBalance = 0;
            filteredEntries.forEach(entry => {
                if (account.type === 'Asset' || account.type === 'Expense') {
                    runningBalance += entry.debit - entry.credit;
                } else {
                    runningBalance += entry.credit - entry.debit;
                }

                html += `
                    <tr>
                        <td><strong>${entry.documentNumber}</strong></td>
                        <td>${new Date(entry.date).toLocaleDateString('id-ID')}</td>
                        <td>${entry.description}</td>
                        <td class="amount ${entry.debit > 0 ? 'debit' : ''}">${entry.debit > 0 ? formatCurrency(entry.debit) : '-'}</td>
                        <td class="amount ${entry.credit > 0 ? 'credit' : ''}">${entry.credit > 0 ? formatCurrency(entry.credit) : '-'}</td>
                        <td class="amount"><strong>${formatCurrency(runningBalance)}</strong></td>
                    </tr>
                `;
            });

            html += `
                        </tbody>
                    </table>
                </div>
            `;

            document.getElementById('accountTransactions').innerHTML = html;
        }

        function displayBalance() {
            const accountNumber = document.getElementById('balanceAccount').value;
            const period = document.getElementById('balancePeriod').value;
            const startDate = document.getElementById('balanceStartDate').value;
            const endDate = document.getElementById('balanceEndDate').value;

            if (!accountNumber || !startDate || !endDate) {
                showAlert('Please select account and date range', 'error');
                return;
            }

            const account = chartOfAccounts.find(acc => acc.number === accountNumber);
            const filteredEntries = journalEntries.filter(entry => {
                const entryDate = new Date(entry.date);
                const start = new Date(startDate);
                const end = new Date(endDate);
                
                return entry.account === accountNumber && entryDate >= start && entryDate <= end;
            });

            let balance = 0;
            filteredEntries.forEach(entry => {
                if (account.type === 'Asset' || account.type === 'Expense') {
                    balance += entry.debit - entry.credit;
                } else {
                    balance += entry.credit - entry.debit;
                }
            });

            const html = `
                <div class="card">
                    <h4>Balance Report</h4>
                    <div class="form-row">
                        <div class="stat-card">
                            <div class="stat-value">${account.number}</div>
                            <div class="stat-label">Account Number</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value">${account.name}</div>
                            <div class="stat-label">Account Name</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value">${formatCurrency(balance)}</div>
                            <div class="stat-label">Balance</div>
                        </div>
                    </div>
                    <p><strong>Period:</strong> ${new Date(startDate).toLocaleDateString('id-ID')} - ${new Date(endDate).toLocaleDateString('id-ID')}</p>
                    <p><strong>Total Transactions:</strong> ${filteredEntries.length}</p>
                </div>
            `;

            document.getElementById('balanceResult').innerHTML = html;
        }

        function generateReport() {
            const reportType = document.getElementById('reportType').value;
            const period = document.getElementById('reportPeriod').value;

            if (!period) {
                showAlert('Please select a period', 'error');
                return;
            }

            const [year, month] = period.split('-');
            const filteredEntries = journalEntries.filter(entry => {
                const entryDate = new Date(entry.date);
                return entryDate.getFullYear() == year && (entryDate.getMonth() + 1) == month;
            });

            let html = `<div class="card"><h4>${reportType.replace('_', ' ').toUpperCase()} - ${new Date(year, month - 1).toLocaleDateString('id-ID', {year: 'numeric', month: 'long'})}</h4>`;

            if (reportType === 'trial_balance') {
                const accountBalances = {};
                
                filteredEntries.forEach(entry => {
                    if (!accountBalances[entry.account]) {
                        const account = chartOfAccounts.find(acc => acc.number === entry.account);
                        accountBalances[entry.account] = {
                            name: account.name,
                            type: account.type,
                            debit: 0,
                            credit: 0
                        };
                    }
                    accountBalances[entry.account].debit += entry.debit;
                    accountBalances[entry.account].credit += entry.credit;
                });

                html += `
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Account</th>
                                <th>Account Name</th>
                                <th>Debit</th>
                                <th>Credit</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                let totalDebit = 0;
                let totalCredit = 0;

                Object.entries(accountBalances).forEach(([accountNumber, balance]) => {
                    totalDebit += balance.debit;
                    totalCredit += balance.credit;
                    
                    html += `
                        <tr>
                            <td><strong>${accountNumber}</strong></td>
                            <td>${balance.name}</td>
                            <td class="amount">${formatCurrency(balance.debit)}</td>
                            <td class="amount">${formatCurrency(balance.credit)}</td>
                        </tr>
                    `;
                });

                html += `
                        <tr style="font-weight: bold; background: #f8f9fa;">
                            <td colspan="2"><strong>TOTAL</strong></td>
                            <td class="amount"><strong>${formatCurrency(totalDebit)}</strong></td>
                            <td class="amount"><strong>${formatCurrency(totalCredit)}</strong></td>
                        </tr>
                        </tbody>
                    </table>
                `;
            }

            html += '</div>';
            document.getElementById('reportResult').innerHTML = html;
        }

        // Deposit Master Functions
        function loadDepositMaster() {
            const depositSelect = document.getElementById('incomeDepositId');
            depositSelect.innerHTML = '<option value="">Select Deposit ID</option>';
            
            depositMaster.forEach(deposit => {
                const option = new Option(`${deposit.id} - ${deposit.description}`, deposit.id);
                depositSelect.appendChild(option);
            });
            
            updateDepositList();
        }

        function handleDepositSubmit(e) {
            e.preventDefault();
            
            const depositData = {
                id: document.getElementById('depositId').value,
                description: document.getElementById('depositDescription').value,
                defaultAmount: parseFloat(document.getElementById('depositDefaultAmount').value) || 0
            };

            const existingIndex = depositMaster.findIndex(d => d.id === depositData.id);
            if (existingIndex >= 0) {
                depositMaster[existingIndex] = depositData;
                showAlert('Deposit updated successfully!', 'success');
            } else {
                depositMaster.push(depositData);
                showAlert('Deposit added successfully!', 'success');
            }

            loadDepositMaster();
            document.getElementById('depositForm').reset();
        }


    // AJAX submit form
    document.getElementById("transactionForm").addEventListener("submit", function(e) {
        e.preventDefault();

        const formData = {
            _token: '{{ csrf_token() }}',
            transaction_date: document.getElementById("transactionDate").value,
            deposit_master_id: document.getElementById("transactionMaster").value,
            description: document.getElementById("transactionDescription").value,
            amount: document.getElementById("transactionAmount").value,
            credit_account_id: document.getElementById("creditAccount").value,
            debit_account_id: document.getElementById("debitAccount").value,
            paid_to_source: document.getElementById("transactionFromTo").value,
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
        .catch(err => {
            console.error(err);
            alert(err);
        });
    });

    // Placeholder fungsi generateTransactionForm
    function generateTransactionForm() {
        alert('Fungsi generate expense form belum diimplementasikan');
    }

    function showModal(modalId) {
        alert('Fungsi showModal("' + modalId + '") belum diimplementasikan');
    }


        function printExpenseForm() {
            const printContent = document.getElementById('printableExpenseForm').innerHTML;
            const originalContent = document.body.innerHTML;
            
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
            
            // Reinitialize after print
            initializeApp();
        }

        function numberToWords(num) {
            const ones = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'];
            const teens = ['sepuluh', 'sebelas', 'dua belas', 'tiga belas', 'empat belas', 'lima belas', 'enam belas', 'tujuh belas', 'delapan belas', 'sembilan belas'];
            const tens = ['', '', 'dua puluh', 'tiga puluh', 'empat puluh', 'lima puluh', 'enam puluh', 'tujuh puluh', 'delapan puluh', 'sembilan puluh'];
            const thousands = ['', 'ribu', 'juta', 'miliar', 'triliun'];

            if (num === 0) return 'nol';

            function convertGroup(n) {
                let result = '';
                
                if (n >= 100) {
                    const hundreds = Math.floor(n / 100);
                    result += (hundreds === 1 ? 'seratus' : ones[hundreds] + ' ratus');
                    n %= 100;
                    if (n > 0) result += ' ';
                }
                
                if (n >= 20) {
                    result += tens[Math.floor(n / 10)];
                    n %= 10;
                    if (n > 0) result += ' ' + ones[n];
                } else if (n >= 10) {
                    result += teens[n - 10];
                } else if (n > 0) {
                    result += ones[n];
                }
                
                return result;
            }

            let result = '';
            let groupIndex = 0;
            
            while (num > 0) {
                const group = num % 1000;
                if (group > 0) {
                    let groupText = convertGroup(group);
                    if (groupIndex > 0) {
                        if (groupIndex === 1 && group === 1) {
                            groupText = 'se';
                        }
                        groupText += ' ' + thousands[groupIndex];
                    }
                    result = groupText + (result ? ' ' + result : '');
                }
                num = Math.floor(num / 1000);
                groupIndex++;
            }
            
            return result.charAt(0).toUpperCase() + result.slice(1);
        }

        // File Upload Handling
        function handleFileUpload(input, type) {
            const file = input.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    let data;
                    if (file.name.endsWith('.csv')) {
                        data = parseCSV(e.target.result);
                    } else {
                        showAlert('Currently only CSV files are supported', 'error');
                        return;
                    }
                    
                    processUploadedData(data, type);
                } catch (error) {
                    showAlert('Error processing file: ' + error.message, 'error');
                }
            };
            reader.readAsText(file);
        }

        function parseCSV(csvText) {
            const lines = csvText.split('\n').filter(line => line.trim());
            const headers = lines[0].split(',').map(h => h.trim());
            const data = [];
            
            for (let i = 1; i < lines.length; i++) {
                const values = lines[i].split(',').map(v => v.trim());
                const row = {};
                headers.forEach((header, index) => {
                    row[header] = values[index] || '';
                });
                data.push(row);
            }
            
            return data;
        }

        function processUploadedData(data, type) {
            let processed = 0;
            let errors = 0;
            
            data.forEach((row, index) => {
                try {
                    if (type === 'income') {
                        const incomeData = {
                            date: row.date || new Date().toISOString().split('T')[0],
                            description: row.description || '',
                            amount: parseFloat(row.amount) || 0,
                            creditSource: row.creditSource || '1100100',
                            incomeAccount: row.incomeAccount || '6100101'
                        };
                        
                        if (incomeData.amount > 0) {
                            const docNumber = generateDocumentNumber();
                            
                            // Create journal entries
                            const creditSourceAccount = chartOfAccounts.find(acc => acc.number === incomeData.creditSource);
                            const incomeAccount = chartOfAccounts.find(acc => acc.number === incomeData.incomeAccount);

                            const journalEntry1 = {
                                documentNumber: docNumber,
                                date: incomeData.date,
                                account: incomeData.creditSource,
                                accountName: creditSourceAccount.name,
                                description: incomeData.description,
                                debit: incomeData.amount,
                                credit: 0,
                                type: 'Income',
                                status: 'Posted'
                            };

                            const journalEntry2 = {
                                documentNumber: docNumber,
                                date: incomeData.date,
                                account: incomeData.incomeAccount,
                                accountName: incomeAccount.name,
                                description: incomeData.description,
                                debit: 0,
                                credit: incomeData.amount,
                                type: 'Income',
                                status: 'Posted'
                            };

                            journalEntries.push(journalEntry1, journalEntry2);
                            transactions.push({
                                ...incomeData,
                                documentNumber: docNumber,
                                type: 'Income'
                            });
                            
                            processed++;
                        } else {
                            errors++;
                        }
                    }
                } catch (error) {
                    errors++;
                    console.error(`Error processing row ${index + 1}:`, error);
                }
            });
            
            updateJournalTable();
            updateDashboard();
            
            if (processed > 0) {
                showAlert(`Successfully processed ${processed} transactions${errors > 0 ? ` (${errors} errors)` : ''}`, errors > 0 ? 'error' : 'success');
            } else {
                showAlert('No valid transactions found in the file', 'error');
            }
            
            // Clear the file input
            document.getElementById('incomeUpload').value = '';
        }

        // Modal Functions
        function showModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }

        function hideModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Alert Functions
        function showAlert(message, type) {
            const existingAlert = document.querySelector('.alert');
            if (existingAlert) {
                existingAlert.remove();
            }
            
            const alert = document.createElement('div');
            alert.className = `alert ${type}`;
            alert.textContent = message;
            
            const container = document.querySelector('.container');
            container.insertBefore(alert, container.firstChild);
            
            setTimeout(() => {
                alert.remove();
            }, 5000);
        }

        // Drag and Drop for Upload Areas
        document.addEventListener('DOMContentLoaded', function() {
            const uploadAreas = document.querySelectorAll('.upload-area');
            
            uploadAreas.forEach(area => {
                area.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    this.classList.add('dragover');
                });
                
                area.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    this.classList.remove('dragover');
                });
                
                area.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.classList.remove('dragover');
                    
                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        const fileInput = document.getElementById('incomeUpload');
                        fileInput.files = files;
                        handleFileUpload(fileInput, 'income');
                    }
                });
            });
        });

        // Close modals when clicking outside
        window.addEventListener('click', function(e) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey || e.metaKey) {
                switch (e.key) {
                    case '1':
                        e.preventDefault();
                        showTab('dashboard');
                        break;
                    case '2':
                        e.preventDefault();
                        showTab('income');
                        break;
                    case '3':
                        e.preventDefault();
                        showTab('expense');
                        break;
                    case '4':
                        e.preventDefault();
                        showTab('journal');
                        break;
                }
            }
            
            if (e.key === 'Escape') {
                const openModals = document.querySelectorAll('.modal[style*="display: block"]');
                openModals.forEach(modal => {
                    modal.style.display = 'none';
                });
            }
        });