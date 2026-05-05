<?php
require_once '../config/db.php';

$page_title = 'View Enrollments';
$active_page = 'view_enrollment';
$base_path = '../';

// JOIN query to display enrollment details with student and course names
try {
    $sql = "SELECT e.enrollment_id, s.student_id, s.name AS student_name,
                   c.course_id, c.course_name
            FROM enrollment e
            JOIN students s ON e.student_id = s.student_id
            JOIN courses c ON e.course_id = c.course_id
            ORDER BY e.enrollment_id ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching enrollments: " . $e->getMessage());
}

include '../includes/header.php';
?>

<div class="page-header">
    <h2>Enrollments</h2>
    <p>View all student-course enrollment records.</p>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'unenrolled') : ?>
    <div class="alert alert-success">Student unenrolled successfully.</div>
<?php endif; ?>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'cannot_unenroll') : ?>
    <div class="alert alert-error">
        Cannot unenroll student because related attendance or grade records exist.
    </div>
<?php endif; ?>

<div class="card">
    <div class="content-top">
        <span class="text-muted"><?php echo count($enrollments); ?> enrollment(s) found</span>
        <div class="content-top-actions">
            <a href="enroll_student.php" class="btn btn-primary">+ Enroll Student</a>
        </div>
    </div>

    <?php if (count($enrollments) > 0) : ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Course Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enrollments as $row) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['enrollment_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['student_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['course_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <div class="actions">
                                    <a class="btn-action btn-action-delete"
                                       href="unenroll_student.php?id=<?php echo $row['enrollment_id']; ?>"
                                       onclick="event.preventDefault(); if(confirm('Are you sure you want to unenroll this student? Related attendance and grade records will also be removed.')) window.location.href=this.href;">Unenroll</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <div class="empty-state">No enrollments found. Enroll a student to get started.</div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
