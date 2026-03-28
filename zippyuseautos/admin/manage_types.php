<?php
require_once('../model/types_db.php');


if (isset($_POST['add_type'])) {
    $type_name = trim($_POST['type_name']);
    if ($type_name != '') {
        add_type($type_name);
        header("Location: manage_types.php");
        exit();
    }
}


if (isset($_GET['delete_id'])) {
    delete_type($_GET['delete_id']);
    header("Location: manage_types.php");
    exit();
}


$types = get_types();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Types</title>
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
    <h1 style="text-align:center;">Manage Types</h1>

    <form method="post" action="manage_types.php">
        <input type="text" name="type_name" placeholder="New Type">
        <input type="submit" name="add_type" value="Add Type">
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Type Name</th>
            <th>Delete</th>
        </tr>
        <?php foreach ($types as $type): ?>
            <tr>
                <td><?= $type['type_id'] ?></td>
                <td><?= $type['type_name'] ?></td>
                <td><a href="manage_types.php?delete_id=<?= $type['type_id'] ?>">Delete</a></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p style="text-align:center;"><a href="index.php">Back to Admin Home</a></p>
</body>
</html>