<?php
include("../config/db.php");

$page_title = 'View Grades';
$active_page = 'view_grades';
$base_path = '../';

try {
    $query = "
    SELECT s.name, c.course_name, g.marks, g.grade
    FROM grades g
    JOIN students s ON g.student_id = s.student_id
    JOIN courses c ON g.course_id = c.course_id
    ORDER BY s.name
    ";
    $stmt = $conn->query($query);
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching grades: " . $e->getMessage());
}

include '../includes/header.php';
?>

<div class="page-header">
    <h2>Student Grades</h2>
    <p>View all marks and auto-calculated grades.</p>
</div>

<div class="card">
    <div class="content-top">
        <span class="text-muted"><?php echo count($records); ?> record(s) found</span>
        <div class="content-top-actions">
            <a href="add_grade.php" class="btn btn-primary">+ Add Marks</a>
        </div>
    </div>

    <?php if (count($records) > 0) : ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Marks</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $row) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['course_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['marks'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <span class="badge badge-grade">
                                    <?php echo htmlspecialchars($row['grade'], ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <div class="empty-state">No grade records found.</div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
