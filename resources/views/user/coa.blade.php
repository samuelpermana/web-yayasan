@extends('layouts.app')

@section('content')

<div class="card">
    <h3>Chart of Accounts</h3>
    <!-- Search Box -->
    <form method="GET" action="{{ route('user.coa') }}" style="margin-bottom: 20px;">
        <div class="search-box">
            <input type="text" 
                   name="search" 
                   placeholder="Search accounts" 
                   value="{{ request('search') }}"
                   style="width: 100%;">
        </div>
        <div style="margin-top: 10px; display: flex; gap: 10px;">
            <button type="submit">Search</button>
            @if(request('search'))
                <a href="{{ route('user.coa') }}" style="text-decoration: none;">
                    <button type="button" style="background: linear-gradient(135deg, #718096, #4a5568);">Clear Search</button>
                </a>
            @endif
        </div>
    </form>
    
    <!-- Search Results Indicator -->
    @if(request('search'))
        <div style="margin-bottom: 15px; padding: 10px; background-color: #e3f2fd; border-left: 4px solid #2196f3; border-radius: 4px;">
            <strong>Search Results for "{{ request('search') }}"</strong> - Found {{ $accounts->total() }} account(s)
        </div>
    @endif
    
    <table class="table" id="coaTable">
        <thead>
            <tr>
                <th>Account Number</th>
                <th>Account Name</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accounts as $account)
                <tr>
                    <td>{{ $account->id }}</td>
                    <td>{{ $account->name }}</td>
                    <td>{{ $account->description ?? '-' }}</td>
                </tr>
            @endforeach
                </tbody>
    </table>
    
    <!-- Pagination -->
    <div style="text-align: center; margin-top: 30px;">
        <p style="color: #718096; margin-bottom: 20px; font-weight: 600;">
            Showing {{ $accounts->firstItem() ?? 0 }} to {{ $accounts->lastItem() ?? 0 }} of {{ $accounts->total() }} accounts
        </p>
        {{ $accounts->links('pagination.custom') }}
    </div>
 </div>


     
     @endsection
