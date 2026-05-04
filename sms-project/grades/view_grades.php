<?php include("../config/db.php"); ?>

<link rel="stylesheet" href="../style.css">

<div class="container">
<h2>Student Grades</h2>

<a href="../index.php">← Back to Home</a>

<table>
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
ORDER BY s.name
";

$stmt = $conn->query($query);

if(!$stmt){
    echo "<tr><td colspan='4'>Error loading data</td></tr>";
} else {
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo "<tr>
                <td>{$row['name']}</td>
                <td>{$row['course_name']}</td>
                <td>{$row['marks']}</td>
                <td>{$row['grade']}</td>
              </tr>";
    }
}
?>

</table>
</div>
