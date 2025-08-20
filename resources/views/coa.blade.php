@extends('layouts.app')

@section('content')

        <!-- COA Tab -->

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
            </div>

@endsection
