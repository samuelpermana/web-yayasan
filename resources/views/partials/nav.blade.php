<div class="nav-tabs">
    @auth
        @if(auth()->user()->type === 'admin')
            {{-- Admin Navigation --}}
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
        @else
            {{-- User Navigation --}}
            <a href="{{ route('user.dashboard') }}" 
               class="nav-tab {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
               Dashboard
            </a>

            <a href="{{ route('user.coa') }}" 
               class="nav-tab {{ request()->routeIs('user.coa') ? 'active' : '' }}">
               COA
            </a>
        @endif
    @endauth
</div>
