<?php
require_once('../model/vehicles_db.php');
require_once('../model/makes_db.php');
require_once('../model/types_db.php');
require_once('../model/classes_db.php');


$sort = isset($_GET['sort']) ? $_GET['sort'] : 'price';


$filter_type = isset($_GET['filter_type']) ? $_GET['filter_type'] : null;
$filter_id   = isset($_GET['filter_id']) ? $_GET['filter_id'] : null;


$vehicles = get_vehicles($sort, $filter_type, $filter_id);


$makes  = get_makes();
$types  = get_types();
$classes = get_classes();

include('../view/vehicle_list.php');
?>