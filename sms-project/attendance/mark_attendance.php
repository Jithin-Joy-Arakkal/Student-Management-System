<?php include("../config/db.php"); ?>

<link rel="stylesheet" href="../style.css">

<div class="container">
<h2>Mark Attendance</h2>

<a href="../index.php">← Back to Home</a>

<form method="POST">

    <label>Student:</label>
    <select name="student_id" required>
        <option value="">-- Select Student --</option>
        <?php
        $stmt = $conn->query("SELECT * FROM students");
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            echo "<option value='{$row['student_id']}'>{$row['name']}</option>";
        }
        ?>
    </select>

    <label>Course:</label>
    <select name="course_id" required>
        <option value="">-- Select Course --</option>
        <?php
        $stmt = $conn->query("SELECT * FROM courses");
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            echo "<option value='{$row['course_id']}'>{$row['course_name']}</option>";
        }
        ?>
    </select>

    <label>Date:</label>
    <input type="date" name="date" required>

    <label>Status:</label>
    <select name="status">
        <option value="Present">Present</option>
        <option value="Absent">Absent</option>
    </select>

    <button type="submit" name="submit">Submit</button>
</form>

<?php
if(isset($_POST['submit'])){

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

        echo "<p style='color:green;'>Attendance saved successfully!</p>";

    } catch (PDOException $e) {
        echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
    }
}
?>

</div>
