<?php
include("../config/db.php");

$page_title = 'Mark Attendance';
$active_page = 'mark_attendance';
$base_path = '../';

$message = "";
$error = "";

if (isset($_POST['submit'])) {
    $sid = $_POST['student_id'];
    $cid = $_POST['course_id'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    try {
        $query = "INSERT INTO attendance (student_id, course_id, date, status)
                  VALUES (:sid, :cid, :date, :status)";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            ':sid' => $sid,
            ':cid' => $cid,
            ':date' => $date,
            ':status' => $status
        ]);

        $message = "Attendance saved successfully!";
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

include '../includes/header.php';
?>

<div class="page-header">
    <h2>Mark Attendance</h2>
    <p>Record attendance for a student in a specific course.</p>
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
                <label>Date</label>
                <input type="date" name="date" required>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                </select>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Submit Attendance</button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
