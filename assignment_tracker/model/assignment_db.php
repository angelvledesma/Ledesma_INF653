<?php
require_once('database.php');

function get_assignments_by_course($course_id) {
    global $db;

    if ($course_id) {
        $query = 'SELECT A.ID, A.Description, C.courseName FROM assignments A
                 LEFT JOIN courses C ON A.courseID = C.courseID
                 WHERE A.courseID = :courseID ORDER BY A.ID';
    } else {
        $query = 'SELECT A.ID, A.Description, C.courseName FROM assignments A
                 LEFT JOIN courses C ON A.courseID = C.courseID
                 ORDER BY C.courseID';
    }

    $statement = $db->prepare($query);

    if ($course_id) {
        $statement->bindValue(':courseID', $course_id);
    }

    $statement->execute();
    $assignments = $statement->fetchAll();
    $statement->closeCursor();
    return $assignments;
}

function add_assignment($course_id, $description) {
    global $db;

    $query = 'INSERT INTO assignments (courseID, Description)
              VALUES (:courseID, :Description)';

    $statement = $db->prepare($query);
    $statement->bindValue(':courseID', $course_id);
    $statement->bindValue(':Description', $description);
    $statement->execute();
    $statement->closeCursor();
}

function delete_assignment($assignment_id) {
    global $db;

    $query = 'DELETE FROM assignments WHERE ID = :assignment_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':assignment_id', $assignment_id);
    $statement->execute();
    $statement->closeCursor();
}

function update_assignment($assignment_id, $description, $course_id) {
    global $db;
    $query = 'UPDATE assignments 
              SET Description = :description, courseID = :courseID 
              WHERE ID = :assignment_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':courseID', $course_id);
    $statement->bindValue(':assignment_id', $assignment_id);
    $statement->execute();
    $statement->closeCursor();
}
