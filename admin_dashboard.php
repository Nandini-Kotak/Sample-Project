<?php
session_start();
include "config.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM users WHERE id=$id");
    header("Location: admin_dashboard.php");
    exit();
}

if (isset($_POST['edit_user_btn'])) {
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $status = $_POST['status'];

    mysqli_query($conn, "UPDATE users SET firstname='$firstname', lastname='$lastname', email='$email', mobile='$contact', status='$status' WHERE id=$id");
    header("Location: admin_dashboard.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Admin Dashboard</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Account Creation Date</th>
                <th>Last Login</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['mobile']; ?></td>
                <td><?php echo $row['signup_time']; ?></td>
                <td><?php echo $row['last_login']; ?></td>
                <td>
                    <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                    <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit_result = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
    $user = mysqli_fetch_assoc($edit_result);
?>
<div class="container mt-5">
    <h2>Edit User</h2>
    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <div class="mb-3">
            <label for="firstname" class="form-label">First Name:</label>
            <input type="text" name="firstname" class="form-control" value="<?php echo $user['firstname']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="lastname" class="form-label">Last Name:</label>
            <input type="text" name="lastname" class="form-control" value="<?php echo $user['lastname']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="contact" class="form-label">Contact:</label>
            <input type="text" name="contact" class="form-control" value="<?php echo $user['mobile']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status:</label>
            <select name="status" class="form-control">
                <option value="active" <?php if ($user['status'] == 'active') echo 'selected'; ?>>Active</option>
                <option value="inactive" <?php if ($user['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
            </select>
        </div>
        <button type="submit" name="edit_user_btn" class="btn btn-primary">Save Changes</button>
    </form>
</div>
<?php } ?>
</body>
</html>
