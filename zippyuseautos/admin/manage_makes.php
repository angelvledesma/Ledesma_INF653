<?php
require_once('../model/makes_db.php');


if (isset($_POST['add_make'])) {
    $make_name = trim($_POST['make_name']);
    if ($make_name != '') {
        add_make($make_name);
        header("Location: makes.php");
        exit();
    }
}


if (isset($_GET['delete_id'])) {
    delete_make($_GET['delete_id']);
    header("Location: makes.php");
    exit();
}


$makes = get_makes();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Makes</title>
    <style>
        table { border-collapse: collapse; width: 50%; margin: auto; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #eee; }
        form { text-align: center; margin-bottom: 20px; }
        input[type=text] { padding: 5px; }
        input[type=submit] { padding: 5px 10px; }
    </style>
</head>
<body>
    <h1 style="text-align:center;">Manage Makes</h1>

    <form method="post" action="makes.php">
        <input type="text" name="make_name" placeholder="New Make">
        <input type="submit" name="add_make" value="Add Make">
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Make Name</th>
            <th>Delete</th>
        </tr>
        <?php foreach ($makes as $make): ?>
            <tr>
                <td><?= $make['make_id'] ?></td>
                <td><?= $make['make_name'] ?></td>
                <td><a href="makes.php?delete_id=<?= $make['make_id'] ?>">Delete</a></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p style="text-align:center;"><a href="index.php">Back to Admin Home</a></p>
</body>
</html>