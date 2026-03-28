<?php
require_once('database.php');

function get_types() {
    global $db;
    $query = "SELECT * FROM types ORDER BY type_name";
    $statement = $db->prepare($query);
    $statement->execute();
    $types = $statement->fetchAll();
    $statement->closeCursor();
    return $types;
}

function add_type($type_name) {
    global $db;
    $query = "INSERT INTO types (type_name) VALUES (:type_name)";
    $statement = $db->prepare($query);
    $statement->bindValue(':type_name', $type_name);
    $statement->execute();
    $statement->closeCursor();
}

function delete_type($type_id) {
    global $db;
    $query = "DELETE FROM types WHERE type_id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $type_id);
    $statement->execute();
    $statement->closeCursor();
}
?>