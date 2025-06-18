// Users management JS

document.addEventListener('DOMContentLoaded', function() {
    loadUsers();
    document.getElementById('addUserBtn').onclick = function() {
        showUserModal();
    };
    document.getElementById('userForm').onsubmit = function(e) {
        e.preventDefault();
        saveUser();
    };
});

function loadUsers() {
    fetch('../api/users.php?action=list')
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById('usersTableBody');
            tbody.innerHTML = '';
            if (data.success && Array.isArray(data.users)) {
                data.users.forEach(user => {
                    let row = `<tr>
                        <td>${user.id}</td>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.role}</td>
                        <td>${user.status}</td>
                        <td>
                            <button class='btn btn-info btn-sm' onclick='showUserModal(${JSON.stringify(user)})'>Edit</button>
                            <button class='btn btn-danger btn-sm' onclick='deleteUser(${user.id})'>Delete</button>
                            <button class='btn btn-warning btn-sm' onclick='resetPassword(${user.id})'>Reset Password</button>
                        </td>
                    </tr>`;
                    tbody.innerHTML += row;
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center">No users found.</td></tr>';
            }
        });
}

function showUserModal(user = null) {
    const modal = new bootstrap.Modal(document.getElementById('userModal'));
    document.getElementById('userId').value = user ? user.id : '';
    document.getElementById('userName').value = user ? user.name : '';
    document.getElementById('userEmail').value = user ? user.email : '';
    document.getElementById('userRole').value = user ? user.role : 'manager';
    document.getElementById('userStatus').value = user ? user.status : 'active';
    document.getElementById('userPassword').value = '';
    document.getElementById('userModalLabel').textContent = user ? 'Edit User' : 'Add User';
    document.getElementById('userPassword').parentElement.style.display = user ? 'none' : '';
    modal.show();
}

function saveUser() {
    const form = document.getElementById('userForm');
    const errorDiv = document.getElementById('userFormError');
    if (errorDiv) errorDiv.remove();
    const isEdit = !!form.userId.value;
    const password = form.userPassword.value;
    if (!isEdit && (!password || password.length < 6)) {
        showUserFormError('Password is required and must be at least 6 characters.');
        return;
    }
    const formData = new FormData(form);
    fetch('../api/users.php', {
        method: 'POST',
        body: formData
    })
    .then(async res => {
        let data;
        try {
            data = await res.json();
        } catch (e) {
            data = { success: false, message: 'Server error or invalid response.' };
        }
        if (!res.ok) {
            showUserFormError(data.message || (`HTTP ${res.status}`));
            return;
        }
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('userModal')).hide();
            loadUsers();
            form.reset();
        } else {
            showUserFormError(data.message || 'Failed to save user.');
        }
    })
    .catch(err => {
        showUserFormError('Network or server error.');
        console.error('User save error:', err);
    });
}

function showUserFormError(msg) {
    let errorDiv = document.getElementById('userFormError');
    if (!errorDiv) {
        errorDiv = document.createElement('div');
        errorDiv.className = 'alert alert-danger';
        errorDiv.id = 'userFormError';
        document.querySelector('#userForm .modal-body').prepend(errorDiv);
    }
    errorDiv.textContent = msg;
}

function deleteUser(id) {
    if (confirm('Are you sure you want to delete this user?')) {
        const formData = new FormData();
        formData.append('action', 'delete');
        formData.append('id', id);
        fetch('../api/users.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                loadUsers();
            } else {
                alert(data.message || 'Failed to delete user.');
            }
        });
    }
}

function resetPassword(id) {
    if (confirm('Reset password for this user?')) {
        const formData = new FormData();
        formData.append('action', 'reset_password');
        formData.append('id', id);
        fetch('../api/users.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message || (data.success ? 'Password reset.' : 'Failed to reset password.'));
        });
    }
}
