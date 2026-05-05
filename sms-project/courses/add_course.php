<?php
require_once '../config/db.php';

$page_title = 'Add Course';
$active_page = 'add_course';
$base_path = '../';

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = trim($_POST['course_name'] ?? '');
    $credits = $_POST['credits'] ?? '';

    if (empty($course_name) || empty($credits)) {
        $error = "All fields are required.";
    } elseif ($credits < 1 || $credits > 6) {
        $error = "Credits must be between 1 and 6.";
    } else {
        try {
            $sql = "INSERT INTO courses (course_name, credits)
                    VALUES (:course_name, :credits)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':course_name' => $course_name,
                ':credits' => $credits
            ]);

            $message = "Course added successfully.";

            $course_name = "";
            $credits = "";
        } catch (PDOException $e) {
            $error = "Error adding course: " . $e->getMessage();
        }
    }
}

include '../includes/header.php';
?>

<div class="page-header">
    <h2>Add Course</h2>
    <p>Create a new course in the system.</p>
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
                <input type="text" id="course_name" name="course_name" value="<?php echo htmlspecialchars($course_name ?? ''); ?>" placeholder="e.g. Database Management Systems" required>
            </div>

            <div class="form-group">
                <label for="credits">Credits (1–6)</label>
                <input type="number" id="credits" name="credits" min="1" max="6" value="<?php echo htmlspecialchars($credits ?? ''); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Course</button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
