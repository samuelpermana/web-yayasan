// Auto-fill description, amount, debit, credit & role area
document.getElementById("transactionMaster").addEventListener("change", function () {
    const selected = this.options[this.selectedIndex];

    // Fill description & amount
    document.getElementById("transactionDescription").value = selected.dataset.description || '';
    document.getElementById("transactionAmount").value = selected.dataset.amount || '';

    // Fill debit & credit
    const debitId = selected.dataset.debit;
    const creditId = selected.dataset.credit;

    document.getElementById("debitAccount").value = debitId || '';
    document.getElementById("creditAccount").value = creditId || '';

    // Fill role area
    const roleArea = selected.dataset.role || '';
    document.getElementById("roleArea").value = roleArea;

    // Filter debit & credit account options sesuai role area
    filterAccountsByRole(roleArea);
});

function filterAccountsByRole(role) {
    const debitSelect = document.getElementById("debitAccount");
    const creditSelect = document.getElementById("creditAccount");

    // Reset options (show all dulu)
    Array.from(debitSelect.options).forEach(opt => {
        if (!opt.value) return; // skip "Select" option
        const accountRole = opt.text.match(/\[(.*?)\]/)?.[1]; // ambil isi [role]
        opt.style.display = role && accountRole !== role ? "none" : "block";
    });

    Array.from(creditSelect.options).forEach(opt => {
        if (!opt.value) return;
        const accountRole = opt.text.match(/\[(.*?)\]/)?.[1];
        opt.style.display = role && accountRole !== role ? "none" : "block";
    });
}
