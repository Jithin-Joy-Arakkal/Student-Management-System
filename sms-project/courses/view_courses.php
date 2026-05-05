<?php
require_once '../config/db.php';

$page_title = 'View Courses';
$active_page = 'view_courses';
$base_path = '../';

try {
    $sql = "SELECT * FROM courses ORDER BY course_id ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching courses: " . $e->getMessage());
}

include '../includes/header.php';
?>

<div class="page-header">
    <h2>Courses</h2>
    <p>View and manage all available courses.</p>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted') : ?>
    <div class="alert alert-success">Course deleted successfully.</div>
<?php endif; ?>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'cannot_delete') : ?>
    <div class="alert alert-error">
        Cannot delete course because related records exist in enrollment, attendance, or grades.
    </div>
<?php endif; ?>

<div class="card">
    <div class="content-top">
        <span class="text-muted"><?php echo count($courses); ?> course(s) found</span>
        <div class="content-top-actions">
            <a href="add_course.php" class="btn btn-primary">+ Add Course</a>
        </div>
    </div>

    <?php if (count($courses) > 0) : ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Course Name</th>
                        <th>Credits</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($courses as $row) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['course_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['course_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['credits'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <div class="actions">
                                    <a class="btn-action btn-action-edit" href="edit_course.php?id=<?php echo $row['course_id']; ?>">Edit</a>
                                    <a class="btn-action btn-action-delete"
                                       href="delete_course.php?id=<?php echo $row['course_id']; ?>"
                                       onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this course? All related enrollment, attendance, and grade records will also be removed.')) window.location.href=this.href;">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <div class="empty-state">No courses found. Add one to get started.</div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
