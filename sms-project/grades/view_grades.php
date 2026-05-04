<link rel="stylesheet" href="../style.css">
<?php include("../config/db.php"); ?>

<h2>Student Grades</h2>

<table border="1" cellpadding="10">
<tr>
    <th>Student</th>
    <th>Course</th>
    <th>Marks</th>
    <th>Grade</th>
</tr>

<?php
$query = "
SELECT s.name, c.course_name, g.marks, g.grade
FROM grades g
JOIN students s ON g.student_id = s.student_id
JOIN courses c ON g.course_id = c.course_id
";

$res = pg_query($conn, $query);

while($row = pg_fetch_assoc($res)){
    echo "<tr>
            <td>{$row['name']}</td>
            <td>{$row['course_name']}</td>
            <td>{$row['marks']}</td>
            <td>{$row['grade']}</td>
          </tr>";
}
?>
</table>
</div>