<?php include("../config/db.php"); ?>

<link rel="stylesheet" href="../style.css">

<div class="container">
<h2>Add Marks</h2>

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

    <label>Marks:</label>
    <input type="number" name="marks" min="0" max="100" required>

    <button type="submit" name="submit">Submit</button>
</form>

<?php
if(isset($_POST['submit'])){

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

        echo "<p style='color:green;'>Marks saved! Grade auto-calculated.</p>";

    } catch (PDOException $e) {
        echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
    }
}
?>

</div>
