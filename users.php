<?php
require_once("util-db.php");
require_once("model-users.php");
session_start(); // Start session to show messages

$pageTitle = "Users";
include "view-header.php";

// Fetch all users
$users = selectUsers();
?>

<h1>Users</h1>

<!-- Session Message for Add/Edit/Delete -->
<?php if (isset($_SESSION['message'])) { ?>
    <div class="alert alert-success">
        <?php echo $_SESSION['message']; ?>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php } ?>

<!-- Add User Button -->
<a href="add-user.php" class="btn btn-success mb-3">Add New User</a>

<table class="table">
    <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Contact Info</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($user = $users->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $user['username']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo $user['contact_info']; ?></td>
            <td>
                <a href="edit-user.php?id=<?php echo $user['user_id']; ?>" class="btn btn-primary">Edit</a>

                <!-- Delete button with confirmation prompt -->
                <form action="delete-user.php" method="POST" style="display:inline;" onsubmit="return confirmDelete()">
                    <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<script>
function confirmDelete() {
    return confirm("Are you sure you want to delete this user along with all associated cars?");
}
</script>

<?php include "view-footer.php"; ?>
