<div class="stats-grid">
    <!-- Total Income -->
    <div class="stat-card">
        <div class="stat-value" style="color: #38a169;">
            Rp {{ number_format($total_income, 0, ',', '.') }}
        </div>
        <div class="stat-label">Total Income</div>
    </div>

    <!-- Total Expense -->
    <div class="stat-card">
        <div class="stat-value" style="color: #e53e3e;">
            Rp {{ number_format($total_expenses, 0, ',', '.') }}
        </div>
        <div class="stat-label">Total Expense</div>
    </div>

    <!-- Net Income -->
    <div class="stat-card">
        <div class="stat-value" style="color: #667eea;">
            Rp {{ number_format($net_income, 0, ',', '.') }}
        </div>
        <div class="stat-label">Net Income</div>
    </div>

    <!-- Total Transactions -->
    <div class="stat-card">
        <div class="stat-value" style="color: #764ba2;">
            {{ $total_transactions }}
        </div>
        <div class="stat-label">Total Transactions</div>
    </div>

    <!-- Total Assets -->
    <div class="stat-card">
        <div class="stat-value" style="color: #38b2ac;">
            Rp {{ number_format($total_assets, 0, ',', '.') }}
        </div>
        <div class="stat-label">Total Assets</div>
    </div>

    <!-- Total Liabilities -->
    <div class="stat-card">
        <div class="stat-value" style="color: #dd6b20;">
            Rp {{ number_format($total_liabilities, 0, ',', '.') }}
        </div>
        <div class="stat-label">Total Liabilities</div>
    </div>

    <!-- Total Equity -->
    <div class="stat-card">
        <div class="stat-value" style="color: #805ad5;">
            Rp {{ number_format($total_equity, 0, ',', '.') }}
        </div>
        <div class="stat-label">Total Equity</div>
    </div>

    <!-- Balance Check -->
    <div class="stat-card">
        <div class="stat-value" style="color: #e53e3e;">
            Rp {{ number_format($balance_check, 0, ',', '.') }}
        </div>
        <div class="stat-label">Balance Check</div>
    </div>
</div>
