<?php
require('model/database.php');
require('model/assignment_db.php');
require('model/course_db.php');

$assignment_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$assignment = null;

if ($assignment_id) {
    $assignments = get_assignments_by_course(null);
    foreach ($assignments as $a) {
        if ($a['ID'] == $assignment_id) {
            $assignment = $a;
            break;
        }
    }
}

$courses = get_courses();
?>

<?php include("header.php"); ?>
<section>
    <h2>Update Assignment</h2>
    <?php if ($assignment) : ?>
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="update_assignment">
        <input type="hidden" name="assignment_id" value="<?= $assignment['ID'] ?>">
        
        <label for="description">Description:</label>
        <input type="text" name="description" id="description" value="<?= htmlspecialchars($assignment['Description']) ?>" required>
        
        <label for="course_id">Course:</label>
        <select name="course_id" id="course_id" required>
            <?php foreach ($courses as $course) : ?>
                <option value="<?= $course['courseID'] ?>" <?= $course['courseName'] == $assignment['courseName'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($course['courseName']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Update Assignment</button>
    </form>
    <?php else: ?>
        <p>Assignment not found.</p>
    <?php endif; ?>
</section>
<?php include("footer.php"); ?>