<!DOCTYPE html>
<html>
<head>
    <title>Zippy Used Autos</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: auto; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #eee; }
        select, button { padding: 5px; margin: 5px; }
        .filter-form { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1 style="text-align:center;">Zippy Used Autos</h1>

    <div class="filter-form">
        <form method="get" action="vehicles.php">
            Sort by:
            <button type="submit" name="sort" value="price">Price</button>
            <button type="submit" name="sort" value="year">Year</button>
            <br><br>

            Filter by:
            <select name="filter_type" id="filter_type" onchange="this.form.submit()">
                <option value="">--Select Category--</option>
                <option value="make">Make</option>
                <option value="type">Type</option>
                <option value="class">Class</option>
            </select>

            <select name="filter_id" id="filter_id" onchange="this.form.submit()">
                <option value="">--Select Value--</option>
                <optgroup label="Makes">
                    <?php foreach ($makes as $make): ?>
                        <option value="<?= $make['make_id'] ?>"><?= $make['make_name'] ?></option>
                    <?php endforeach; ?>
                </optgroup>
                <optgroup label="Types">
                    <?php foreach ($types as $type): ?>
                        <option value="<?= $type['type_id'] ?>"><?= $type['type_name'] ?></option>
                    <?php endforeach; ?>
                </optgroup>
                <optgroup label="Classes">
                    <?php foreach ($classes as $class): ?>
                        <option value="<?= $class['class_id'] ?>"><?= $class['class_name'] ?></option>
                    <?php endforeach; ?>
                </optgroup>
            </select>
        </form>
    </div>

    <table>
        <tr>
            <th>Year</th>
            <th>Make</th>
            <th>Model</th>
            <th>Type</th>
            <th>Class</th>
            <th>Price</th>
        </tr>
        <?php foreach ($vehicles as $v): ?>
            <tr>
                <td><?= $v['year'] ?></td>
                <td><?= $v['make_name'] ?></td>
                <td><?= $v['model'] ?></td>
                <td><?= $v['type_name'] ?></td>
                <td><?= $v['class_name'] ?></td>
                <td>$<?= number_format($v['price'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>