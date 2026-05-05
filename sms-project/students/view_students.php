<?php
require_once '../config/db.php';

$page_title = 'View Students';
$active_page = 'view_students';
$base_path = '../';

try {
    $sql = "SELECT * FROM students ORDER BY student_id ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching students: " . $e->getMessage());
}

include '../includes/header.php';
?>

<div class="page-header">
    <h2>Students</h2>
    <p>View and manage all registered students.</p>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted') : ?>
    <div class="alert alert-success">Student deleted successfully.</div>
<?php endif; ?>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'cannot_delete') : ?>
    <div class="alert alert-error">
        Cannot delete student because related records exist in enrollment, attendance, or grades.
    </div>
<?php endif; ?>

<div class="card">
    <div class="content-top">
        <span class="text-muted"><?php echo count($students); ?> student(s) found</span>
        <div class="content-top-actions">
            <a href="add_student.php" class="btn btn-primary">+ Add Student</a>
        </div>
    </div>

    <?php if (count($students) > 0) : ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $row) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['student_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['date_of_birth'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['contact'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['address'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <div class="actions">
                                    <a class="btn-action btn-action-edit" href="edit_student.php?id=<?php echo $row['student_id']; ?>">Edit</a>
                                    <a class="btn-action btn-action-delete"
                                       href="delete_student.php?id=<?php echo $row['student_id']; ?>"
                                       onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this student? All related enrollment, attendance, and grade records will also be removed.')) window.location.href=this.href;">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <div class="empty-state">No students found. Add one to get started.</div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>