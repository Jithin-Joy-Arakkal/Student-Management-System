<link rel="stylesheet" href="../style.css">
<?php include("../config/db.php"); ?>

<h2>Mark Attendance</h2>

<form method="POST">
    Student:
    <select name="student_id">
        <?php
        $res = pg_query($conn, "SELECT * FROM students");
        while($row = pg_fetch_assoc($res)){
            echo "<option value='{$row['student_id']}'>{$row['name']}</option>";
        }
        ?>
    </select><br><br>

    Course:
    <select name="course_id">
        <?php
        $res = pg_query($conn, "SELECT * FROM courses");
        while($row = pg_fetch_assoc($res)){
            echo "<option value='{$row['course_id']}'>{$row['course_name']}</option>";
        }
        ?>
    </select><br><br>

    Date: <input type="date" name="date" required><br><br>

    Status:
    <select name="status">
        <option value="Present">Present</option>
        <option value="Absent">Absent</option>
    </select><br><br>

    <button type="submit" name="submit">Submit</button>
</form>

<?php
if(isset($_POST['submit'])){
    $sid = $_POST['student_id'];
    $cid = $_POST['course_id'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    $query = "INSERT INTO attendance (student_id, course_id, date, status)
              VALUES ('$sid','$cid','$date','$status')";

    $res = pg_query($conn, $query);

    if($res) echo "<p style='color:green;'>Attendance saved!</p>";
    else echo "<p style='color:red;'>".pg_last_error($conn)."</p>";
}
?>
</div>