<?php
require('model/database.php');
require('model/assignment_db.php');
require('model/course_db.php');

// Get input
$assignment_id   = filter_input(INPUT_POST, 'assignment_id', FILTER_VALIDATE_INT) ?: filter_input(INPUT_GET, 'assignment_id', FILTER_VALIDATE_INT);
$description     = filter_input(INPUT_POST, 'description', FILTER_UNSAFE_RAW);
$course_name     = filter_input(INPUT_POST, 'course_name', FILTER_UNSAFE_RAW);
$course_id       = filter_input(INPUT_POST, 'course_id', FILTER_VALIDATE_INT) ?: filter_input(INPUT_GET, 'course_id', FILTER_VALIDATE_INT);
$action          = filter_input(INPUT_POST, 'action', FILTER_UNSAFE_RAW) ?: filter_input(INPUT_GET, 'action', FILTER_UNSAFE_RAW) ?: 'list';

// Handle actions
if ($action === 'add_course' && $course_name) {
    add_course($course_name);
} elseif ($action === 'delete_course' && $course_id) {
    delete_course($course_id);
} elseif ($action === 'update_course' && $course_id && $course_name) {
    update_course($course_id, $course_name);
} elseif ($action === 'add_assignment' && $description && $course_id) {
    add_assignment($course_id, $description);
} elseif ($action === 'delete_assignment' && $assignment_id) {
    delete_assignment($assignment_id);
} elseif ($action === 'update_assignment' && $assignment_id && $description && $course_id) {
    update_assignment($assignment_id, $description, $course_id);
}

// Get updated lists
$courses = get_courses();


$assignments = ($course_id) ? get_assignments_by_course($course_id) : get_assignments_by_course(null);


$edit_course = ($action === 'edit_course' && $course_id) ? get_course_name($course_id) : '';


$edit_assignment = null;
if ($action === 'edit_assignment' && $assignment_id) {
    // Fetch single assignment
    $stmt = $db->prepare('SELECT A.ID, A.Description, C.courseID, C.courseName 
                          FROM assignments A 
                          LEFT JOIN courses C ON A.courseID = C.courseID 
                          WHERE A.ID = :id');
    $stmt->bindValue(':id', $assignment_id);
    $stmt->execute();
    $edit_assignment = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
}
?>

<?php include("view/header.php"); ?>

<section>
    <h2>Courses</h2>

    <?php if ($action === 'edit_course' && $course_id) : ?>
        <form action="index.php" method="post">
            <input type="hidden" name="action" value="update_course">
            <input type="hidden" name="course_id" value="<?= $course_id ?>">
            <label for="course_name">Course Name:</label>
            <input type="text" name="course_name" id="course_name" value="<?= htmlspecialchars($edit_course) ?>" required>
            <button type="submit">Update Course</button>
            <button type="button" onclick="window.location.href='index.php'">Cancel</button>
        </form>
    <?php else: ?>
        <form action="index.php" method="post">
            <input type="hidden" name="action" value="add_course">
            <label for="course_name">Course Name:</label>
            <input type="text" name="course_name" id="course_name" required>
            <button type="submit">Add Course</button>
        </form>
    <?php endif; ?>

    <h3>Existing Courses</h3>
    <ul>
        <?php foreach ($courses as $course) : ?>
            <li>
                <?= htmlspecialchars($course['courseName']) ?>
                <form action="index.php" method="post" style="display:inline;">
                    <input type="hidden" name="action" value="delete_course">
                    <input type="hidden" name="course_id" value="<?= $course['courseID'] ?>">
                    <button type="submit" onclick="return confirm('Delete this course?')">X</button>
                </form>
                <form action="index.php" method="get" style="display:inline;">
                    <input type="hidden" name="action" value="edit_course">
                    <input type="hidden" name="course_id" value="<?= $course['courseID'] ?>">
                    <button type="submit">Edit</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<section>
    <h2>Assignments</h2>

    <?php if ($action === 'edit_assignment' && $edit_assignment) : ?>
        <form action="index.php" method="post">
            <input type="hidden" name="action" value="update_assignment">
            <input type="hidden" name="assignment_id" value="<?= $edit_assignment['ID'] ?>">

            <label for="description">Description:</label>
            <input type="text" name="description" id="description" value="<?= htmlspecialchars($edit_assignment['Description']) ?>" required>

            <label for="course_id">Course:</label>
            <select name="course_id" id="course_id" required>
                <?php foreach ($courses as $course) : ?>
                    <option value="<?= $course['courseID'] ?>" <?= $course['courseID'] == $edit_assignment['courseID'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($course['courseName']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Update Assignment</button>
            <button type="button" onclick="window.location.href='index.php'">Cancel</button>
        </form>
    <?php else: ?>
        <form action="index.php" method="post">
            <input type="hidden" name="action" value="add_assignment">
            <label for="description">Description:</label>
            <input type="text" name="description" id="description" required>

            <label for="course_id">Course:</label>
            <select name="course_id" id="course_id" required>
                <?php foreach ($courses as $course) : ?>
                    <option value="<?= $course['courseID'] ?>"><?= htmlspecialchars($course['courseName']) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Add Assignment</button>
        </form>
    <?php endif; ?>

    <h3>Existing Assignments</h3>
    <?php if (!empty($assignments)) : ?>
        <?php foreach ($assignments as $assignment) : ?>
            <div>
                <p><strong><?= htmlspecialchars($assignment['courseName']) ?></strong></p>
                <p><?= htmlspecialchars($assignment['Description']) ?></p>

                <form action="index.php" method="post" style="display:inline;">
                    <input type="hidden" name="action" value="delete_assignment">
                    <input type="hidden" name="assignment_id" value="<?= $assignment['ID'] ?>">
                    <button type="submit" onclick="return confirm('Delete this assignment?')">X</button>
                </form>

                <form action="index.php" method="get" style="display:inline;">
                    <input type="hidden" name="action" value="edit_assignment">
                    <input type="hidden" name="assignment_id" value="<?= $assignment['ID'] ?>">
                    <button type="submit">Edit</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No assignments exist <?= $course_id ? 'for this course' : '' ?> yet.</p>
    <?php endif; ?>
</section>

<?php include("view/footer.php"); ?>