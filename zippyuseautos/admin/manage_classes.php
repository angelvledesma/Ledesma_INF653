<?php
require_once('../model/classes_db.php');


if (isset($_POST['add_class'])) {
    $class_name = trim($_POST['class_name']);
    if ($class_name != '') {
        add_class($class_name);
        header("Location: manage_classes.php");
        exit();
    }
}


if (isset($_GET['delete_id'])) {
    delete_class($_GET['delete_id']);
    header("Location: manage_classes.php");
    exit();
}


$classes = get_classes();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Classes</title>
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
    <h1 style="text-align:center;">Manage Classes</h1>

    <form method="post" action="manage_classes.php">
        <input type="text" name="class_name" placeholder="New Class">
        <input type="submit" name="add_class" value="Add Class">
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Class Name</th>
            <th>Delete</th>
        </tr>
        <?php foreach ($classes as $class): ?>
            <tr>
                <td><?= $class['class_id'] ?></td>
                <td><?= $class['class_name'] ?></td>
                <td><a href="manage_classes.php?delete_id=<?= $class['class_id'] ?>">Delete</a></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p style="text-align:center;"><a href="index.php">Back to Admin Home</a></p>
</body>
</html>