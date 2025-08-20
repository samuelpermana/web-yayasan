
    <!-- Modals -->
    <div id="depositModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModal('depositModal')">&times;</span>
            <h3>Manage Deposit Master Data</h3>

            <!-- Form Input -->
            <form id="depositForm">
                @csrf
                <input type="hidden" id="depositId">

                <div class="form-group">
                    <label for="depositNumber">Deposit Number</label>
                    <input type="text" id="depositNumber" placeholder="e.g. DEP0001">
                </div>

                <div class="form-group">
                    <label for="depositDescription">Description</label>
                    <input type="text" id="depositDescription" required>
                </div>

                <div class="form-group">
                    <label for="depositDefaultAmount">Default Amount</label>
                    <input type="number" id="depositDefaultAmount" step="0.01">
                </div>

                            
                <!-- Debit Account -->
                <div class="form-group">
                    <label for="debitAccountModal">Debit Account</label>
                    <select id="debitAccountModal" name="debit_account_id">
                        <option value="">-- Select Debit Account --</option>
                        @foreach ($accounts as $acc)
                            <option value="{{ $acc->id }}">{{ $acc->id }} - {{ $acc->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Credit Account -->
                <div class="form-group">
                    <label for="creditAccountModal">Credit Account</label>
                    <select id="creditAccountModal" name="credit_account_id">
                        <option value="">-- Select Credit Account --</option>
                        @foreach ($accounts as $acc)
                            <option value="{{ $acc->id }}">{{ $acc->id }} - {{ $acc->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" id="btnSaveDeposit">Create Deposit</button>
                <button type="button" id="btnCreateDeposit" onclick="createDeposit()" disabled>
                    Reset Edit
                </button>
            </form>


            <!-- Table Deposit Master -->
            <h4 style="margin-top:20px;">Deposit Master List</h4>
            <table class="table" id="depositTable">
                <thead>
                    <tr>
                        <th>Number</th>
                        <th>Description</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Default Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deposit_masters as $deposit)
                        <tr>
                            <td>{{ $deposit->number }}</td>
                            <td>{{ $deposit->description }}</td>
                            <td>{{ $deposit->debitAccount?->name ?? '-' }}</td>
                            <td>{{ $deposit->creditAccount?->name ?? '-' }}</td>
                            <td>{{ number_format($deposit->default_amount, 2) }}</td>
                            <td>
                                <button onclick="editDeposit({{ $deposit->id }})">Edit</button>
                                <button onclick="deleteDeposit({{ $deposit->id }})">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="expenseFormModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModal('expenseFormModal')">&times;</span>
            <div id="printableExpenseForm"></div>
            <button onclick="printExpenseForm()">Print Form</button>
        </div>
    </div>