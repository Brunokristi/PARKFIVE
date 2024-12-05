document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.edit-user-button').forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.dataset.userId;

            fetch(`/customers/${userId}/edit`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                }
            })
                .then(response => response.json())
                .then(user => {
                    document.getElementById('editCustomerId').textContent = user.id;
                    document.getElementById('editName').value = user.name || '';
                    document.getElementById('editEmail').value = user.email || '';
                    document.getElementById('editPhone').value = user.phone || '';
                    document.getElementById('editStreet').value = user.street || '';
                    document.getElementById('editCity').value = user.city || '';
                    document.getElementById('editZipCode').value = user.zip || '';
                    document.getElementById('editCompany').checked = Boolean(user.is_company);
                    document.getElementById('editCompanyName').value = user.company_name || '';
                    document.getElementById('editICO').value = user.ico || '';
                    document.getElementById('editDIC').value = user.dic || '';
                    document.getElementById('editICDPH').value = user.ic_dph || '';
                    document.getElementById('editIBAN').value = user.iban || '';
                    document.getElementById('editBIC').value = user.bic || '';
                    document.getElementById('editAccountOwner').value = user.account_owner || '';

                    document.getElementById('editCustomerForm').action = `/users/${user.id}`;
                });
        });
    });
});
