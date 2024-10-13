<?php
require_once("util-db.php");
require_once("model-users.php");

$pageTitle = "Users";
include "view-header.php";

// Fetch all users
$users = selectUsers();
?>

<h1>Users</h1>
<table class="table">
    <thead>
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Contact Info</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php while ($user = $users->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $user['user_id']; ?></td>
            <td><?php echo $user['username']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo $user['contact_info']; ?></td>
            <td><a href="user-details.php?id=<?php echo $user['user_id']; ?>">Details</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<?php include "view-footer.php"; ?>
