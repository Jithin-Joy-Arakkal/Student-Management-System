<?php include("../config/db.php"); ?>

<link rel="stylesheet" href="../style.css">

<div class="container">
<h2>Attendance Records</h2>

<a href="../index.php">← Back to Home</a>

<table>
<tr>
    <th>Student</th>
    <th>Course</th>
    <th>Date</th>
    <th>Status</th>
</tr>

<?php
try {
    $query = "
    SELECT s.name, c.course_name, a.date, a.status
    FROM attendance a
    JOIN students s ON a.student_id = s.student_id
    JOIN courses c ON a.course_id = c.course_id
    ORDER BY a.date DESC
    ";

    $stmt = $conn->query($query);

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo "<tr>
                <td>{$row['name']}</td>
                <td>{$row['course_name']}</td>
                <td>{$row['date']}</td>
                <td>{$row['status']}</td>
              </tr>";
    }

} catch (PDOException $e) {
    echo "<tr><td colspan='4'>Error: " . $e->getMessage() . "</td></tr>";
}
?>

</table>
</div>
