<?php
require_once('../model/vehicles_db.php');
require_once('../model/makes_db.php');
require_once('../model/types_db.php');
require_once('../model/classes_db.php');


if (isset($_POST['add_vehicle'])) {
    $year = intval($_POST['year']);
    $model = trim($_POST['model']);
    $price = floatval($_POST['price']);
    $make_id = intval($_POST['make_id']);
    $type_id = intval($_POST['type_id']);
    $class_id = intval($_POST['class_id']);

    if ($year && $model && $price && $make_id && $type_id && $class_id) {
        global $db;
        $query = "INSERT INTO vehicles (year, model, price, type_id, class_id, make_id)
                  VALUES (:year, :model, :price, :type_id, :class_id, :make_id)";
        $statement = $db->prepare($query);
        $statement->bindValue(':year', $year);
        $statement->bindValue(':model', $model);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':type_id', $type_id);
        $statement->bindValue(':class_id', $class_id);
        $statement->bindValue(':make_id', $make_id);
        $statement->execute();
        $statement->closeCursor();

        header("Location: index.php");
        exit();
    } else {
        $error = "Please fill in all fields.";
    }
}


$makes  = get_makes();
$types  = get_types();
$classes = get_classes();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Vehicle</title>
    <style>
        form { width: 400px; margin: auto; padding: 20px; border: 1px solid #ccc; }
        label { display: block; margin-top: 10px; }
        input, select { width: 100%; padding: 5px; margin-top: 5px; }
        input[type=submit] { margin-top: 15px; }
    </style>
</head>
<body>
    <h1 style="text-align:center;">Add Vehicle</h1>

    <?php if (isset($error)) echo "<p style='color:red;text-align:center;'>$error</p>"; ?>

    <form method="post" action="add_vehicle.php">
        <label>Year</label>
        <input type="number" name="year" required>

        <label>Model</label>
        <input type="text" name="model" required>

        <label>Price</label>
        <input type="number" name="price" step="0.01" required>

        <label>Make</label>
        <select name="make_id" required>
            <option value="">--Select Make--</option>
            <?php foreach ($makes as $make): ?>
                <option value="<?= $make['make_id'] ?>"><?= $make['make_name'] ?></option>
            <?php endforeach; ?>
        </select>

        <label>Type</label>
        <select name="type_id" required>
            <option value="">--Select Type--</option>
            <?php foreach ($types as $type): ?>
                <option value="<?= $type['type_id'] ?>"><?= $type['type_name'] ?></option>
            <?php endforeach; ?>
        </select>

        <label>Class</label>
        <select name="class_id" required>
            <option value="">--Select Class--</option>
            <?php foreach ($classes as $class): ?>
                <option value="<?= $class['class_id'] ?>"><?= $class['class_name'] ?></option>
            <?php endforeach; ?>
        </select>

        <input type="submit" name="add_vehicle" value="Add Vehicle">
    </form>

    <p style="text-align:center;"><a href="index.php">Back to Admin Home</a></p>
</body>
</html>