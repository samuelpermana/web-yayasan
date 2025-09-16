@extends('layouts.app')

@section('content')
<div class="card">
    <span class="close" onclick="window.location.href='{{ route('dm.index') }}'">&times;</span>
    <h3>Edit Deposit Master</h3>

    <form action="{{ route('dm.update', $deposit->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Deposit Number -->
        <div class="form-group">
            <label for="depositNumber">Deposit Number</label>
            <input type="text" name="number" id="depositNumber" 
                   value="{{ old('number', $deposit->number) }}" required>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="depositDescription">Description</label>
            <input type="text" name="description" id="depositDescription" 
                   value="{{ old('description', $deposit->description) }}" required>
        </div>

        <!-- Default Amount -->
        <div class="form-group">
            <label for="depositDefaultAmount">Default Amount</label>
            <input type="number" name="default_amount" id="depositDefaultAmount" 
                   step="0.01" value="{{ old('default_amount', $deposit->default_amount) }}" required>
        </div>

        <!-- Debit Account -->
        <div class="form-group">
            <label for="debitAccountModal">Debit Account</label>
            <select id="debitAccountModal" name="debit_account_id" required>
                <option value="">-- Select Debit Account --</option>
                @foreach ($accounts as $acc)
                    <option value="{{ $acc->id }}" 
                        data-role="{{ $acc->role_area }}" {{-- tambahkan atribut role --}}
                        {{ old('debit_account_id', $deposit->debit_account_id) == $acc->id ? 'selected' : '' }}>
                        {{ $acc->id }} - {{ $acc->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Credit Account -->
        <div class="form-group">
            <label for="creditAccountModal">Credit Account</label>
            <select id="creditAccountModal" name="credit_account_id" required>
                <option value="">-- Select Credit Account --</option>
                @foreach ($accounts as $acc)
                    <option value="{{ $acc->id }}" 
                        data-role="{{ $acc->role_area }}"
                        {{ old('credit_account_id', $deposit->credit_account_id) == $acc->id ? 'selected' : '' }}>
                        {{ $acc->id }} - {{ $acc->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Role Area -->
        <div class="form-group">
            <label for="roleArea">Role Area</label>
            <select id="roleArea" name="role_area" required>
                <option value="yayasan" {{ old('role_area', $deposit->role_area) == 'yayasan' ? 'selected' : '' }}>Yayasan</option>
                <option value="mahad" {{ old('role_area', $deposit->role_area) == 'mahad' ? 'selected' : '' }}>Mahad</option>
            </select>
        </div>

        <!-- Buttons -->
        <div class="mt-3">
            <button type="submit" class="btn btn-success">Update Deposit</button>
            <a href="{{ route('dm.index') }}" class="btn btn-warning btn-sm">Cancel</a>
        </div>
    </form>
</div>

{{-- Script filter akun by role --}}
<script>
    function filterAccounts() {
        let selectedRole = document.getElementById('roleArea').value;

        ['debitAccountModal', 'creditAccountModal'].forEach(selectId => {
            let select = document.getElementById(selectId);
            Array.from(select.options).forEach(opt => {
                if (opt.value === "") return; // skip placeholder
                opt.style.display = (opt.getAttribute('data-role') === selectedRole) ? 'block' : 'none';
            });

            // kalau option terpilih tidak sesuai role, reset
            if (select.value && select.selectedOptions[0].getAttribute('data-role') !== selectedRole) {
                select.value = "";
            }
        });
    }

    // Jalankan saat role_area berubah
    document.getElementById('roleArea').addEventListener('change', filterAccounts);

    // Jalankan pertama kali saat load
    window.addEventListener('load', filterAccounts);
</script>
@endsection
