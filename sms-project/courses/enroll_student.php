<?php
require_once '../config/db.php';

$page_title = 'Enroll Student';
$active_page = 'enroll_student';
$base_path = '../';

$message = "";
$error = "";

// Fetch all students for the dropdown
try {
    $stmt = $conn->prepare("SELECT student_id, name FROM students ORDER BY name ASC");
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching students: " . $e->getMessage());
}

// Fetch all courses for the dropdown
try {
    $stmt = $conn->prepare("SELECT course_id, course_name FROM courses ORDER BY course_name ASC");
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching courses: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'] ?? '';
    $course_id = $_POST['course_id'] ?? '';

    if (empty($student_id) || empty($course_id)) {
        $error = "Please select both a student and a course.";
    } else {
        try {
            $sql = "INSERT INTO enrollment (student_id, course_id)
                    VALUES (:student_id, :course_id)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':student_id' => $student_id,
                ':course_id' => $course_id
            ]);

            $message = "Student enrolled successfully.";
        } catch (PDOException $e) {
            if ($e->getCode() == '23505') {
                $error = "This student is already enrolled in the selected course.";
            } else {
                $error = "Error enrolling student: " . $e->getMessage();
            }
        }
    }
}

include '../includes/header.php';
?>

<div class="page-header">
    <h2>Enroll Student</h2>
    <p>Register a student into a course.</p>
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
                <label for="student_id">Select Student</label>
                <select id="student_id" name="student_id" required>
                    <option value="">-- Choose a Student --</option>
                    <?php foreach ($students as $s) : ?>
                        <option value="<?php echo $s['student_id']; ?>"
                            <?php echo (isset($student_id) && $student_id == $s['student_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($s['name'], ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="course_id">Select Course</label>
                <select id="course_id" name="course_id" required>
                    <option value="">-- Choose a Course --</option>
                    <?php foreach ($courses as $c) : ?>
                        <option value="<?php echo $c['course_id']; ?>"
                            <?php echo (isset($course_id) && $course_id == $c['course_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($c['course_name'], ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Enroll Student</button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
