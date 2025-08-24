<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yayasan Ayah Bigel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .header h1 {
            color: #4a5568;
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .header p {
            color: #718096;
            font-size: 1.1rem;
        }

        .nav-tabs {
            display: flex;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 5px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        .nav-tab {
            flex: 1;
            padding: 15px 20px;
            background: transparent;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            color: #718096;
            white-space: nowrap;
            min-width: 120px;
        }

        .nav-tab.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .nav-tab:hover:not(.active) {
            background: rgba(102, 126, 234, 0.1);
            transform: translateY(-1px);
        }

        .tab-content {
            display: none;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #4a5568;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-1px);
        }

        button {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        button.secondary {
            background: linear-gradient(135deg, #48bb78, #38a169);
        }

        button.danger {
            background: linear-gradient(135deg, #f56565, #e53e3e);
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .table th, .table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .table th {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            font-weight: 600;
        }

        .table tr:hover {
            background: rgba(102, 126, 234, 0.05);
        }

        .status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status.posted {
            background: #c6f6d5;
            color: #22543d;
        }

        .status.pending {
            background: #fef5e7;
            color: #c05621;
        }

        .amount {
            font-weight: 700;
            font-size: 1.1em;
        }

        .amount.debit {
            color: #e53e3e;
        }

        .amount.credit {
            color: #38a169;
        }

        .search-box {
            position: relative;
            margin-bottom: 20px;
        }

        .search-box input {
            padding-left: 45px;
        }

        .search-box::before {
            content: "🔍";
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
        }

        .upload-area {
            border: 2px dashed #cbd5e0;
            border-radius: 15px;
            padding: 40px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.5);
        }

        .upload-area:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }

        .upload-area.dragover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.7));
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .stat-label {
            color: #718096;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        .print-form {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            font-family: 'Courier New', monospace;
        }

        @media print {
            body { background: white; }
            .nav-tabs, .header, button { display: none; }
            .print-form { box-shadow: none; }
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            z-index: 1000;
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border-radius: 20px;
            padding: 30px;
            max-width: 500px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 24px;
            cursor: pointer;
            color: #718096;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .alert.success {
            background: #c6f6d5;
            color: #22543d;
            border-left: 4px solid #38a169;
        }

        .alert.error {
            background: #fed7d7;
            color: #742a2a;
            border-left: 4px solid #e53e3e;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .nav-tabs {
                flex-direction: column;
            }
            
            .nav-tab {
                margin-bottom: 5px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>YAYASAN AYAH BIGEL</h1>
            <p>Comprehensive solution for income tracking, expense management, and financial reporting</p>
        </div>

        <div class="nav-tabs">
            <button class="nav-tab active" onclick="showTab('dashboard')">Dashboard</button>
            <button class="nav-tab" onclick="showTab('income')">Income</button>
            <button class="nav-tab" onclick="showTab('expense')">Expense</button>
            <button class="nav-tab" onclick="showTab('journal')">Journal</button>
            <button class="nav-tab" onclick="showTab('accounts')">Accounts</button>
            <button class="nav-tab" onclick="showTab('balance')">Balance</button>
            <button class="nav-tab" onclick="showTab('reports')">Reports</button>
            <button class="nav-tab" onclick="showTab('coa')">COA</button>
        </div>

        <!-- Dashboard Tab -->
        <div id="dashboard" class="tab-content active">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value" style="color: #38a169;" id="totalIncome">Rp 0</div>
                    <div class="stat-label">Total Income</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" style="color: #e53e3e;" id="totalExpense">Rp 0</div>
                    <div class="stat-label">Total Expense</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" style="color: #667eea;" id="netBalance">Rp 0</div>
                    <div class="stat-label">Net Balance</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" style="color: #764ba2;" id="totalTransactions">0</div>
                    <div class="stat-label">Total Transactions</div>
                </div>
            </div>

            <div class="card">
                <h3>Recent Transactions</h3>
                <table class="table" id="recentTransactions">
                    <thead>
                        <tr>
                            <th>Document No.</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Account</th>
                            <th>Amount</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <!-- Income Tab -->
        <div id="income" class="tab-content">
            <div class="card">
                <h3>Income Entry</h3>
                <form id="incomeForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="incomeDate">Date</label>
                            <input type="date" id="incomeDate" required>
                        </div>
                        <div class="form-group">
                            <label for="incomeDepositId">Deposit Master ID</label>
                            <select id="incomeDepositId" onchange="fillIncomeFields()">
                                <option value="">Select Deposit ID</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="incomeDescription">Description</label>
                            <input type="text" id="incomeDescription" required>
                        </div>
                        <div class="form-group">
                            <label for="incomeAmount">Amount</label>
                            <input type="number" id="incomeAmount" step="0.01" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="incomeCreditSource">Credit Source</label>
                            <select id="incomeCreditSource" required>
                                <option value="">Select Credit Source</option>
                                <option value="1100100">1100100 - Kas</option>
                                <option value="1200100">1200100 - Bank BSI</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="incomeAccount">Income Account</label>
                            <select id="incomeAccount" required>
                                <option value="">Select Income Account</option>
                                <option value="6100100">6100100 - Pendapatan SPP</option>
                                <option value="6100101">6100101 - Pendapatan Lain-lain</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit">Post Income Transaction</button>
                    <button type="button" onclick="showModal('depositModal')">Manage Deposit Master</button>
                </form>
            </div>

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

        <!-- Expense Tab -->
        <div id="expense" class="tab-content">
            <div class="card">
                <h3>Expense Entry</h3>
                <form id="expenseForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="expenseDate">Date</label>
                            <input type="date" id="expenseDate" required>
                        </div>
                        <div class="form-group">
                            <label for="expenseTo">Paid To</label>
                            <input type="text" id="expenseTo" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="expenseDescription">Description</label>
                            <input type="text" id="expenseDescription" required>
                        </div>
                        <div class="form-group">
                            <label for="expenseAmount">Amount</label>
                            <input type="number" id="expenseAmount" step="0.01" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="expenseAccount">Expense Account</label>
                            <select id="expenseAccount" required></select>
                        </div>
                        <div class="form-group">
                            <label for="expensePaymentMethod">Payment Method</label>
                            <select id="expensePaymentMethod" required>
                                <option value="">Select Payment Method</option>
                                <option value="1100100">Cash (Kas)</option>
                                <option value="1200100">Bank Transfer (Bank BSI)</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit">Post Expense Transaction</button>
                    <button type="button" onclick="generateExpenseForm()">Generate Expense Form</button>
                </form>
            </div>
        </div>

        <!-- Journal Tab -->
        <div id="journal" class="tab-content">
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
                            <th>Account</th>
                            <th>Description</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <!-- Accounts Tab -->
        <div id="accounts" class="tab-content">
            <div class="card">
                <h3>Display Account</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="accountSelect">Select Account</label>
                        <select id="accountSelect" onchange="displayAccountTransactions()"></select>
                    </div>
                    <div class="form-group">
                        <label for="accountDateRange">Date Range</label>
                        <input type="month" id="accountDateRange" onchange="displayAccountTransactions()">
                    </div>
                </div>
                <div id="accountTransactions"></div>
            </div>
        </div>

        <!-- Balance Tab -->
        <div id="balance" class="tab-content">
            <div class="card">
                <h3>Display Balance</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="balanceAccount">Account Number</label>
                        <select id="balanceAccount"></select>
                    </div>
                    <div class="form-group">
                        <label for="balancePeriod">Period</label>
                        <select id="balancePeriod">
                            <option value="monthly">Monthly</option>
                            <option value="yearly">Yearly</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="balanceStartDate">Start Date</label>
                        <input type="date" id="balanceStartDate">
                    </div>
                    <div class="form-group">
                        <label for="balanceEndDate">End Date</label>
                        <input type="date" id="balanceEndDate">
                    </div>
                </div>
                <button onclick="displayBalance()">Show Balance</button>
                <div id="balanceResult"></div>
            </div>
        </div>

        <!-- Reports Tab -->
        <div id="reports" class="tab-content">
            <div class="card">
                <h3>Financial Reports</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="reportType">Report Type</label>
                        <select id="reportType">
                            <option value="income_statement">Income Statement</option>
                            <option value="balance_sheet">Balance Sheet</option>
                            <option value="trial_balance">Trial Balance</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="reportPeriod">Period</label>
                        <input type="month" id="reportPeriod">
                    </div>
                </div>
                <button onclick="generateReport()">Generate Report</button>
                <div id="reportResult"></div>
            </div>
        </div>

        <!-- COA Tab -->
        <div id="coa" class="tab-content">
            <div class="card">
                <h3>Chart of Accounts</h3>
                <div class="search-box">
                    <input type="text" placeholder="Search accounts..." onkeyup="filterCOA(this.value)">
                </div>
                <table class="table" id="coaTable">
                    <thead>
                        <tr>
                            <th>Account Number</th>
                            <th>Account Name</th>
                            <th>Description</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div id="depositModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModal('depositModal')">&times;</span>
            <h3>Manage Deposit Master Data</h3>
            <form id="depositForm">
                <div class="form-group">
                    <label for="depositId">Deposit ID</label>
                    <input type="text" id="depositId" required>
                </div>
                <div class="form-group">
                    <label for="depositDescription">Description</label>
                    <input type="text" id="depositDescription" required>
                </div>
                <div class="form-group">
                    <label for="depositDefaultAmount">Default Amount</label>
                    <input type="number" id="depositDefaultAmount" step="0.01">
                </div>
                <button type="submit">Save Deposit</button>
            </form>
            <div id="depositList"></div>
        </div>
    </div>

    <div id="expenseFormModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModal('expenseFormModal')">&times;</span>
            <div id="printableExpenseForm"></div>
            <button onclick="printExpenseForm()">Print Form</button>
        </div>
    </div>

    <script>
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
            populateCOATable();
            loadDepositMaster();
            updateDashboard();
            
            // Set up form event listeners
            document.getElementById('incomeForm').addEventListener('submit', handleIncomeSubmit);
            document.getElementById('expenseForm').addEventListener('submit', handleExpenseSubmit);
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

        function populateAccountDropdowns() {
            const incomeAccountSelect = document.getElementById('incomeAccount');
            const expenseAccountSelect = document.getElementById('expenseAccount');
            const accountSelect = document.getElementById('accountSelect');
            const balanceAccountSelect = document.getElementById('balanceAccount');

            // Clear existing options
            [incomeAccountSelect, expenseAccountSelect, accountSelect, balanceAccountSelect].forEach(select => {
                select.innerHTML = '<option value="">Select Account</option>';
            });

            chartOfAccounts.forEach(account => {
                const option = new Option(`${account.number} - ${account.name}`, account.number);
                
                if (account.type === 'Income') {
                    incomeAccountSelect.appendChild(option.cloneNode(true));
                } else if (account.type === 'Expense') {
                    expenseAccountSelect.appendChild(option.cloneNode(true));
                }
                
                accountSelect.appendChild(option.cloneNode(true));
                balanceAccountSelect.appendChild(option.cloneNode(true));
            });
        }

        function populateCOATable() {
            const tbody = document.querySelector('#coaTable tbody');
            tbody.innerHTML = '';

            chartOfAccounts.forEach(account => {
                const row = tbody.insertRow();
                row.innerHTML = `
                    <td><strong>${account.number}</strong></td>
                    <td>${account.name}</td>
                    <td>${account.description}</td>
                    <td><span class="status ${account.type.toLowerCase()}">${account.type}</span></td>
                `;
            });
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

        function fillIncomeFields() {
            const depositId = document.getElementById('incomeDepositId').value;
            const deposit = depositMaster.find(d => d.id === depositId);
            
            if (deposit) {
                document.getElementById('incomeDescription').value = deposit.description;
                if (deposit.defaultAmount > 0) {
                    document.getElementById('incomeAmount').value = deposit.defaultAmount;
                }
            }
        }

        function updateDepositList() {
            const depositList = document.getElementById('depositList');
            if (!depositList) return;
            
            let html = '<h4>Existing Deposits</h4>';
            if (depositMaster.length === 0) {
                html += '<p>No deposits found.</p>';
            } else {
                html += '<table class="table"><thead><tr><th>ID</th><th>Description</th><th>Default Amount</th><th>Actions</th></tr></thead><tbody>';
                depositMaster.forEach((deposit, index) => {
                    html += `
                        <tr>
                            <td><strong>${deposit.id}</strong></td>
                            <td>${deposit.description}</td>
                            <td>${formatCurrency(deposit.defaultAmount)}</td>
                            <td>
                                <button onclick="editDeposit(${index})" style="background: #48bb78; margin-right: 5px;">Edit</button>
                                <button onclick="deleteDeposit(${index})" style="background: #f56565;">Delete</button>
                            </td>
                        </tr>
                    `;
                });
                html += '</tbody></table>';
            }
            depositList.innerHTML = html;
        }

        function editDeposit(index) {
            const deposit = depositMaster[index];
            document.getElementById('depositId').value = deposit.id;
            document.getElementById('depositDescription').value = deposit.description;
            document.getElementById('depositDefaultAmount').value = deposit.defaultAmount;
        }

        function deleteDeposit(index) {
            if (confirm('Are you sure you want to delete this deposit?')) {
                depositMaster.splice(index, 1);
                loadDepositMaster();
                showAlert('Deposit deleted successfully!', 'success');
            }
        }

        // Expense Form Generation
        function generateExpenseForm() {
            const formData = {
                date: document.getElementById('expenseDate').value,
                paidTo: document.getElementById('expenseTo').value,
                description: document.getElementById('expenseDescription').value,
                amount: parseFloat(document.getElementById('expenseAmount').value),
                expenseAccount: document.getElementById('expenseAccount').value,
                paymentMethod: document.getElementById('expensePaymentMethod').value
            };

            if (!formData.amount || formData.amount <= 0) {
                showAlert('Please enter a valid amount first', 'error');
                return;
            }

            const expenseAccount = chartOfAccounts.find(acc => acc.number === formData.expenseAccount);
            const paymentAccount = chartOfAccounts.find(acc => acc.number === formData.paymentMethod);
            const docNumber = 'FORM-' + Date.now();

            const expenseFormHtml = `
                <div class="print-form">
                    <h2 style="text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px;">
                        BUKTI PENGELUARAN
                    </h2>
                    
                    <div style="margin-bottom: 20px;">
                        <strong>NO. ${docNumber}</strong>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <strong>DIBAYAR KEPADA:</strong> ${formData.paidTo}
                    </div>
                    
                    <div style="margin-bottom: 30px;">
                        <strong>JUMLAH:</strong> ${formatCurrency(formData.amount)}
                    </div>
                    
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
                                <td style="border: 1px solid #333; padding: 10px;">${formData.expenseAccount}</td>
                                <td style="border: 1px solid #333; padding: 10px; text-align: center;">40</td>
                                <td style="border: 1px solid #333; padding: 10px;">${expenseAccount.name}</td>
                                <td style="border: 1px solid #333; padding: 10px; text-align: right;">${formatCurrency(formData.amount)}</td>
                            </tr>
                            <tr style="border: 1px solid #333;">
                                <td style="border: 1px solid #333; padding: 10px;">${formData.paymentMethod}</td>
                                <td style="border: 1px solid #333; padding: 10px; text-align: center;">50</td>
                                <td style="border: 1px solid #333; padding: 10px;">${paymentAccount.name}</td>
                                <td style="border: 1px solid #333; padding: 10px; text-align: right;">${formatCurrency(formData.amount)}</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div style="margin-bottom: 30px;">
                        <strong>Terbilang:</strong> ${numberToWords(formData.amount)} Rupiah
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 30px;">
                        <div>
                            <input type="checkbox" ${formData.paymentMethod === '1100100' ? 'checked' : ''}> TUNAI
                        </div>
                        <div>
                            <input type="checkbox" ${formData.paymentMethod === '1200100' ? 'checked' : ''}> TRANSFER BANK
                        </div>
                        <div>
                            <input type="checkbox"> LAINNYA
                        </div>
                    </div>
                    
                    <div style="text-align: right; margin-bottom: 50px;">
                        <strong>TANGERANG, ${new Date(formData.date).toLocaleDateString('id-ID')}</strong>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between;">
                        <div style="text-align: center; width: 200px;">
                            <div style="border-bottom: 1px solid #333; height: 80px; margin-bottom: 10px;"></div>
                            <strong>DIBUAT OLEH</strong>
                        </div>
                        <div style="text-align: center; width: 200px;">
                            <div style="border-bottom: 1px solid #333; height: 80px; margin-bottom: 10px;"></div>
                            <strong>FINANCE ACCOUNTING</strong>
                        </div>
                        <div style="text-align: center; width: 200px;">
                            <div style="border-bottom: 1px solid #333; height: 80px; margin-bottom: 10px;"></div>
                            <strong>DISETUJUI OLEH</strong>
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('printableExpenseForm').innerHTML = expenseFormHtml;
            showModal('expenseFormModal');
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
            if (modalId === 'depositModal') {
                updateDepositList();
            }
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

        // Sample data for demonstration
        function loadSampleData() {
            // Add some sample deposit master data
            depositMaster.push(
                { id: 'SPP001', description: 'SPP Bulanan Santri', defaultAmount: 500000 },
                { id: 'REG001', description: 'Pendaftaran Santri Baru', defaultAmount: 1000000 },
                { id: 'INF001', description: 'Infaq Operasional', defaultAmount: 0 }
            );
            
            // Add some sample transactions
            const sampleTransactions = [
                {
                    date: '2024-01-15',
                    description: 'Penerimaan SPP Januari',
                    amount: 25000000,
                    creditSource: '1200100',
                    incomeAccount: '6100100',
                    type: 'Income'
                },
                {
                    date: '2024-01-16',
                    paidTo: 'PT Listrik Negara',
                    description: 'Pembayaran Listrik Januari',
                    amount: 3500000,
                    expenseAccount: '7100113',
                    paymentMethod: '1200100',
                    type: 'Expense'
                }
            ];
            
            sampleTransactions.forEach(transaction => {
                const docNumber = generateDocumentNumber();
                
                if (transaction.type === 'Income') {
                    const creditSourceAccount = chartOfAccounts.find(acc => acc.number === transaction.creditSource);
                    const incomeAccount = chartOfAccounts.find(acc => acc.number === transaction.incomeAccount);

                    journalEntries.push({
                        documentNumber: docNumber,
                        date: transaction.date,
                        account: transaction.creditSource,
                        accountName: creditSourceAccount.name,
                        description: transaction.description,
                        debit: transaction.amount,
                        credit: 0,
                        type: 'Income',
                        status: 'Posted'
                    });

                    journalEntries.push({
                        documentNumber: docNumber,
                        date: transaction.date,
                        account: transaction.incomeAccount,
                        accountName: incomeAccount.name,
                        description: transaction.description,
                        debit: 0,
                        credit: transaction.amount,
                        type: 'Income',
                        status: 'Posted'
                    });
                } else {
                    const expenseAccount = chartOfAccounts.find(acc => acc.number === transaction.expenseAccount);
                    const paymentAccount = chartOfAccounts.find(acc => acc.number === transaction.paymentMethod);

                    journalEntries.push({
                        documentNumber: docNumber,
                        date: transaction.date,
                        account: transaction.expenseAccount,
                        accountName: expenseAccount.name,
                        description: transaction.description,
                        debit: transaction.amount,
                        credit: 0,
                        type: 'Expense',
                        status: 'Posted'
                    });

                    journalEntries.push({
                        documentNumber: docNumber,
                        date: transaction.date,
                        account: transaction.paymentMethod,
                        accountName: paymentAccount.name,
                        description: transaction.description,
                        debit: 0,
                        credit: transaction.amount,
                        type: 'Expense',
                        status: 'Posted'
                    });
                }
                
                transactions.push({
                    ...transaction,
                    documentNumber: docNumber
                });
            });
            
            loadDepositMaster();
            updateJournalTable();
            updateDashboard();
        }

        // Load sample data on initialization
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(loadSampleData, 1000);
        });
    </script>
</body>
</html>