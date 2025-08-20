        function createDeposit() {
            // Reset form manual
            document.getElementById("depositForm").reset();

            // Kosongkan hidden ID supaya dianggap "create"
            document.getElementById("depositId").value = "";

            // Kosongkan field number kalau ada
            if (document.getElementById("depositNumber")) {
                document.getElementById("depositNumber").value = "";
            }

            // Tombol Reset Edit dimatikan (karena sudah mode create)
            document.getElementById("btnCreateDeposit").disabled = true;

            // Ubah tombol Save jadi "Create Deposit"
            document.getElementById("btnSaveDeposit").innerText = "Create Deposit";

            // Show modal
            showModal('depositModal');
        }
async function editDeposit(id) {
    const res = await fetch(`/deposit-masters/edit`);
    const data = await res.json();

    // data = { deposit_masters: [...], accounts: [...] }
    const deposits = data.deposit_masters;
    const deposit = deposits.find(d => d.id === id);

    // isi form
    document.getElementById("depositId").value = deposit.id;
    document.getElementById("depositNumber").value = deposit.number;
    document.getElementById("depositDescription").value = deposit.description;
    document.getElementById("depositDefaultAmount").value = deposit.default_amount;

    // Set dropdown debit & credit (convert ke string biar cocok dengan option.value)
    document.getElementById("debitAccountModal").value = deposit.debit_account_id ? String(deposit.debit_account_id) : "";
    document.getElementById("creditAccountModal").value = deposit.credit_account_id ? String(deposit.credit_account_id) : "";

    // Aktifkan tombol Reset Edit (karena mode edit)
    document.getElementById("btnCreateDeposit").disabled = false;

    // Ubah tombol Save jadi "Edit Deposit"
    document.getElementById("btnSaveDeposit").innerText = "Edit Deposit";

    // Show modal
    showModal('depositModal');
}
document.getElementById("depositForm").addEventListener("submit", async function (e) {
    e.preventDefault();

    const id = document.getElementById("depositId").value;
    const url = id ? `/deposit-masters/${id}` : `/deposit-masters`;
    const method = id ? "PUT" : "POST";

    const payload = {
        number: document.getElementById("depositNumber").value,
        description: document.getElementById("depositDescription").value,
        default_amount: document.getElementById("depositDefaultAmount").value,
        debit_account_id: document.getElementById("debitAccountModal").value,
        credit_account_id: document.getElementById("creditAccountModal").value,
    };

    const res = await fetch(url, {
        method: method,
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(payload),
    });

    const data = await res.json();
    if (data.success) {
        location.reload();
    } else {
        alert("Error saving deposit");
    }
});

// Edit
async function editDeposit(id) {
    const row = document.querySelector(`#depositTable tr td button[onclick="editDeposit(${id})"]`).closest("tr");
    const cols = row.querySelectorAll("td");

    document.getElementById("depositId").value = id;
    document.getElementById("depositNumber").value = cols[0].innerText;
    document.getElementById("depositDescription").value = cols[1].innerText;
    document.getElementById("depositDefaultAmount").value = cols[4].innerText.replace(/,/g,"");

    // dropdown
    document.getElementById("debitAccountModal").value = cols[2].dataset.accountId || "";
    document.getElementById("creditAccountModal").value = cols[3].dataset.accountId || "";

    // toggle tombol
    document.getElementById("btnSaveDeposit").innerText = "Update Deposit";
    document.getElementById("btnCreateDeposit").disabled = false;
}

// Delete
async function deleteDeposit(id) {
    if (!confirm("Are you sure?")) return;

    const res = await fetch(`/deposit-masters/${id}`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        }
    });

    const data = await res.json();
    if (data.success) {
        location.reload();
    } else {
        alert("Error deleting deposit");
    }
}

// Reset Create mode
function createDeposit() {
    document.getElementById("depositForm").reset();
    document.getElementById("depositId").value = "";
    document.getElementById("btnSaveDeposit").innerText = "Create Deposit";
    document.getElementById("btnCreateDeposit").disabled = true;
}
