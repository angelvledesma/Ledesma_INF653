<?php
require('model/database.php');
require('model/course_db.php');

$course_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$course_name = '';

if ($course_id) {
    $courses = get_courses();
    foreach ($courses as $c) {
        if ($c['courseID'] == $course_id) {
            $course_name = $c['courseName'];
            break;
        }
    }
}
?>

<?php include("header.php"); ?>
<section>
    <h2>Update Course</h2>
    <?php if ($course_id) : ?>
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="update_course">
        <input type="hidden" name="course_id" value="<?= $course_id ?>">

        <label for="course_name">Course Name:</label>
        <input type="text" name="course_name" id="course_name" value="<?= htmlspecialchars($course_name) ?>" required>

        <button type="submit">Update Course</button>
    </form>
    <?php else: ?>
        <p>Course not found.</p>
    <?php endif; ?>
</section>
<?php include("footer.php"); ?>