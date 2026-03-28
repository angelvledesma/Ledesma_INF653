<?php
require_once('../model/vehicles_db.php');
require_once('../model/makes_db.php');
require_once('../model/types_db.php');
require_once('../model/classes_db.php');

if (isset($_GET['delete_id'])) {
    delete_vehicle($_GET['delete_id']);
    header("Location: index.php");
    exit();
}


$vehicles = get_vehicles();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Zippy Used Autos</title>
    <style>
        table { border-collapse: collapse; width: 90%; margin: auto; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #eee; }
        a { text-decoration: none; color: blue; }
        .actions { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1 style="text-align:center;">Zippy Admin</h1>

    <div class="actions">
        <a href="add_vehicle.php">Add Vehicle</a> |
        <a href="makes.php">Manage Makes</a> |
        <a href="types.php">Manage Types</a> |
        <a href="classes.php">Manage Classes</a>
    </div>

    <table>
        <tr>
            <th>Year</th>
            <th>Make</th>
            <th>Model</th>
            <th>Type</th>
            <th>Class</th>
            <th>Price</th>
            <th>Delete</th>
        </tr>
        <?php foreach ($vehicles as $v): ?>
            <tr>
                <td><?= $v['year'] ?></td>
                <td><?= $v['make_name'] ?></td>
                <td><?= $v['model'] ?></td>
                <td><?= $v['type_name'] ?></td>
                <td><?= $v['class_name'] ?></td>
                <td>$<?= number_format($v['price'], 2) ?></td>
                <td><a href="index.php?delete_id=<?= $v['vehicle_id'] ?>">Delete</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>