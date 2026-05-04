<link rel="stylesheet" href="../style.css">
<?php include("../config/db.php"); ?>

<h2>Add Marks</h2>

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

    Marks: <input type="number" name="marks" required><br><br>

    <button type="submit" name="submit">Submit</button>
</form>

<?php
if(isset($_POST['submit'])){
    $sid = $_POST['student_id'];
    $cid = $_POST['course_id'];
    $marks = $_POST['marks'];

    $query = "INSERT INTO grades (student_id, course_id, marks)
              VALUES ('$sid','$cid','$marks')";

    $res = pg_query($conn, $query);

    if($res) echo "<p style='color:green;'>Marks added! Grade auto-calculated.</p>";
    else echo "<p style='color:red;'>".pg_last_error($conn)."</p>";
}
?>
</div>