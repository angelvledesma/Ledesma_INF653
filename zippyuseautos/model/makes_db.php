<?php
require_once('database.php');

function get_makes() {
    global $db;
    $query = "SELECT * FROM makes ORDER BY make_name";
    $statement = $db->prepare($query);
    $statement->execute();
    $makes = $statement->fetchAll();
    $statement->closeCursor();
    return $makes;
}

function add_make($make_name) {
    global $db;
    $query = "INSERT INTO makes (make_name) VALUES (:make_name)";
    $statement = $db->prepare($query);
    $statement->bindValue(':make_name', $make_name);
    $statement->execute();
    $statement->closeCursor();
}

function delete_make($make_id) {
    global $db;
    $query = "DELETE FROM makes WHERE make_id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $make_id);
    $statement->execute();
    $statement->closeCursor();
}
?>