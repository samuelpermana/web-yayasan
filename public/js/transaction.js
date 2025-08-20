// Auto-fill description, amount, debit & credit accounts
document.getElementById("transactionMaster").addEventListener("change", function() {
    const selected = this.options[this.selectedIndex];

    // Fill description & amount
    document.getElementById("transactionDescription").value = selected.dataset.description || '';
    document.getElementById("transactionAmount").value = selected.dataset.amount || '';
    console.log(selected)

    // Fill debit & credit selects
    const debitId = selected.dataset.debit;
    const creditId = selected.dataset.credit;

    if (debitId) {
        document.getElementById("debitAccount").value = debitId;
    } else {
        document.getElementById("debitAccount").value = '';
    }

    if (creditId) {
        document.getElementById("creditAccount").value = creditId;
    } else {
        document.getElementById("creditAccount").value = '';
    }
});
