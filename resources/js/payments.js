document.addEventListener('DOMContentLoaded', function () {
    const issueDateInput = document.getElementById('issueDate');
    const today = new Date().toISOString().split('T')[0];
    issueDateInput.value = today;
});
