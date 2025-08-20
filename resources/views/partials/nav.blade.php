<div class="nav-tabs">
    <a href="{{ route('dashboard') }}" 
       class="nav-tab {{ request()->routeIs('dashboard') ? 'active' : '' }}">
       Dashboard
    </a>

    <a href="{{ route('transaction.index') }}" 
       class="nav-tab {{ request()->routeIs('transaction.index') ? 'active' : '' }}">
       Transaction Entry
    </a>

    <a href="{{ route('journal.index') }}" 
       class="nav-tab {{ request()->routeIs('journal.index') ? 'active' : '' }}">
       Journal
    </a>

    <a href="{{ route('accounts.index', ['id' => 1]) }}" 
       class="nav-tab {{ request()->routeIs('accounts.index') ? 'active' : '' }}">
       Accounts
    </a>

    <a href="{{ route('coa.index') }}" 
       class="nav-tab {{ request()->routeIs('coa.index') ? 'active' : '' }}">
       COA
    </a>
</div>
