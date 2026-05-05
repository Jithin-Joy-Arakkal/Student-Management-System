<?php
require_once '../config/db.php';

$page_title = 'Edit Course';
$active_page = 'view_courses';
$base_path = '../';

$message = "";
$error = "";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: view_courses.php");
    exit;
}

$course_id = $_GET['id'];

try {
    $sql = "SELECT * FROM courses WHERE course_id = :course_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':course_id' => $course_id]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$course) {
        die("Course not found.");
    }
} catch (PDOException $e) {
    die("Error fetching course: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = trim($_POST['course_name'] ?? '');
    $credits = $_POST['credits'] ?? '';

    if (empty($course_name) || empty($credits)) {
        $error = "All fields are required.";
    } elseif ($credits < 1 || $credits > 6) {
        $error = "Credits must be between 1 and 6.";
    } else {
        try {
            $sql = "UPDATE courses
                    SET course_name = :course_name,
                        credits = :credits
                    WHERE course_id = :course_id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':course_name' => $course_name,
                ':credits' => $credits,
                ':course_id' => $course_id
            ]);

            $message = "Course updated successfully.";

            $course['course_name'] = $course_name;
            $course['credits'] = $credits;

        } catch (PDOException $e) {
            $error = "Error updating course: " . $e->getMessage();
        }
    }
}

include '../includes/header.php';
?>

<div class="page-header">
    <h2>Edit Course</h2>
    <p>Update the details for this course.</p>
</div>

<div class="card">
    <div class="form-container">

        <?php if (!empty($message)) : ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if (!empty($error)) : ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="course_name">Course Name</label>
                <input type="text" id="course_name" name="course_name" value="<?php echo htmlspecialchars($course['course_name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="credits">Credits (1–6)</label>
                <input type="number" id="credits" name="credits" min="1" max="6" value="<?php echo htmlspecialchars($course['credits']); ?>" required>
            </div>

            <button type="submit" class="btn btn-success">Update Course</button>
            <a href="view_courses.php" class="btn btn-outline">Cancel</a>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
