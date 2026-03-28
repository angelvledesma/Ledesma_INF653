<?php
require_once('database.php');

function get_vehicles($sort = 'price', $filter_type = null, $filter_id = null) {
    global $db;

    $order_by = "price DESC";
    if ($sort === 'year') {
        $order_by = "year DESC";
    }

    $query = "
        SELECT v.*, m.make_name, t.type_name, c.class_name
        FROM vehicles v
        LEFT JOIN makes m ON v.make_id = m.make_id
        LEFT JOIN types t ON v.type_id = t.type_id
        LEFT JOIN classes c ON v.class_id = c.class_id
    ";

    if ($filter_type && $filter_id) {
        if ($filter_type === 'make') {
            $query .= " WHERE v.make_id = :id";
        } elseif ($filter_type === 'type') {
            $query .= " WHERE v.type_id = :id";
        } elseif ($filter_type === 'class') {
            $query .= " WHERE v.class_id = :id";
        }
    }

    $query .= " ORDER BY $order_by";

    $statement = $db->prepare($query);

    if ($filter_type && $filter_id) {
        $statement->bindValue(':id', $filter_id);
    }

    $statement->execute();
    $vehicles = $statement->fetchAll();
    $statement->closeCursor();

    return $vehicles;
}

function delete_vehicle($vehicle_id) {
    global $db;
    $query = "DELETE FROM vehicles WHERE vehicle_id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $vehicle_id);
    $statement->execute();
    $statement->closeCursor();
}
?>