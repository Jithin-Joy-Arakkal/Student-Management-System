<?php
include("../config/db.php");

$page_title = 'Add Marks';
$active_page = 'add_grade';
$base_path = '../';

$message = "";
$error = "";

if (isset($_POST['submit'])) {
    $sid = $_POST['student_id'];
    $cid = $_POST['course_id'];
    $marks = $_POST['marks'];

    try {
        // Insert marks (grade auto handled by trigger)
        $query = "INSERT INTO grades (student_id, course_id, marks)
                  VALUES (:sid, :cid, :marks)
                  ON CONFLICT (student_id, course_id)
                  DO UPDATE SET marks = EXCLUDED.marks";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            ':sid' => $sid,
            ':cid' => $cid,
            ':marks' => $marks
        ]);

        $message = "Marks saved! Grade auto-calculated.";
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

include '../includes/header.php';
?>

<div class="page-header">
    <h2>Add Marks</h2>
    <p>Enter marks for a student. Grades are calculated automatically by the database trigger.</p>
</div>

<div class="card">
    <div class="form-container">

        <?php if (!empty($message)) : ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if (!empty($error)) : ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Student</label>
                <select name="student_id" required>
                    <option value="">-- Select Student --</option>
                    <?php
                    $stmt = $conn->query("SELECT * FROM students ORDER BY name ASC");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . htmlspecialchars($row['student_id']) . "'>" . htmlspecialchars($row['name']) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Course</label>
                <select name="course_id" required>
                    <option value="">-- Select Course --</option>
                    <?php
                    $stmt = $conn->query("SELECT * FROM courses ORDER BY course_name ASC");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . htmlspecialchars($row['course_id']) . "'>" . htmlspecialchars($row['course_name']) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Marks (0–100)</label>
                <input type="number" name="marks" min="0" max="100" required>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Submit Marks</button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
