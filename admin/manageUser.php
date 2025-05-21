<?php
include('../includes/config.php'); // Database connection

// Fetch all users safely
$users = [];
$result = $conn->query("SELECT userId, full_name, email, role FROM users");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rooms</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .section-admin{
            display: flex;
        }
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: #343a40;
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .nav-links {
            flex-grow: 1;
            margin-left: 0px;
        }
        .nav-links i{
            margin-right: 10px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: block;
            margin-bottom: 5px;
        }
        .sidebar a:hover {
            background: #495057;
            border-radius: 5px;
        }
        .logout {
            margin-top: auto;
            padding-bottom: 20px;
        }
        .logout i{
            margin-right: 20px;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        .content-section {
            display: none;
        }
        .content-section.active {
            display: block;
        }
        .iconAdmin i{
            font-size: 60px;
            color: white;
            text-align: center;
            margin-bottom: 20px;
            border: 3px solid white;
            border-radius: 50%;
            padding: 20px;
        }
    </style>
</head>
<body>

<?php require_once "../includes/adminDashboardNavBar.php"; ?>

<div class="container py-4">
    <h2>Manage Users</h2>
    <table class="table table-bordered table-hover" id="usersTable">
        <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Role</th>
            <th style="width: 160px;">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $index => $user): ?>
                <tr data-userid="<?php echo (int)$user['userId']; ?>">
                    <td><?php echo $index + 1; ?></td>
                    <td class="full_name"><?php echo htmlspecialchars($user['full_name']); ?></td>
                    <td class="email"><?php echo htmlspecialchars($user['email']); ?></td>
                    <td class="role"><?php echo htmlspecialchars($user['role']); ?></td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm btn-edit"
                                data-userid="<?php echo (int)$user['userId']; ?>"
                                data-full_name="<?php echo htmlspecialchars($user['full_name'], ENT_QUOTES); ?>"
                                data-email="<?php echo htmlspecialchars($user['email'], ENT_QUOTES); ?>"
                                data-role="<?php echo htmlspecialchars($user['role'], ENT_QUOTES); ?>">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        <button type="button" class="btn btn-danger btn-sm btn-delete" data-userid="<?php echo (int)$user['userId']; ?>">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" class="text-center">No users found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editUserForm" novalidate>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_user_id" name="userId" />
                    <input type="hidden" name="action" value="edit" />
                    <div class="mb-3">
                        <label for="edit_full_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="edit_full_name" name="full_name" required />
                        <div class="invalid-feedback">Please enter full name.</div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required />
                        <div class="invalid-feedback">Please enter a valid email.</div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_role" class="form-label">Role</label>
                        <input type="text" class="form-control" id="edit_role" name="role" required />
                        <div class="invalid-feedback">Please enter user role.</div>
                    </div>
                    <div id="editUserMessage" class="text-danger"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
$(function() {
    // Delete user with confirmation and AJAX
    $('.btn-delete').click(function() {
        if (!confirm('Are you sure you want to delete this user?')) return;

        const userId = $(this).data('userid');
        const row = $(this).closest('tr');

        $.post('../function/user_actions/userDelete.php', { userId }, function(response) {
            if (response.success) {
                alert(response.message);
                row.remove();
            } else {
                alert('Error: ' + response.message);
            }
        }, 'json').fail(() => alert('Failed to contact server.'));
    });

    // Open edit modal and populate data
    $('.btn-edit').click(function() {
        const userId = $(this).data('userid');
        $('#edit_user_id').val(userId);
        $('#edit_full_name').val($(this).data('full_name'));
        $('#edit_email').val($(this).data('email'));
        $('#edit_role').val($(this).data('role'));
        $('#editUserMessage').text('');
        const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
        editModal.show();
    });

    // Client-side validation and submit edit form via AJAX
$('#editUserForm').on('submit', function(e) {
    e.preventDefault();

    const form = this;
    if (!form.checkValidity()) {
        e.stopPropagation();
        $(form).addClass('was-validated');
        return;
    }

    const formData = $(form).serialize();

    // Submit to editUser.php
    $.post('../function/user_actions/editUser.php', formData, function(response) {
        if (response.success) {
            alert(response.message);

            const userId = $('#edit_user_id').val();
            const row = $(`tr[data-userid="${userId}"]`);
            row.find('.full_name').text($('#edit_full_name').val());
            row.find('.email').text($('#edit_email').val());
            row.find('.role').text($('#edit_role').val());

            row.find('.btn-edit').data('full_name', $('#edit_full_name').val());
            row.find('.btn-edit').data('email', $('#edit_email').val());
            row.find('.btn-edit').data('role', $('#edit_role').val());

            bootstrap.Modal.getInstance(document.getElementById('editUserModal')).hide();
            $(form).removeClass('was-validated');
        } else {
            $('#editUserMessage').text(response.message);
        }
    }, 'json').fail(() => {
        $('#editUserMessage').text('Failed to contact server.');
    });
});

});
</script>

</body>
</html>
