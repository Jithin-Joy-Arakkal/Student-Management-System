<?php
include("../config/db.php");

$page_title = 'View Attendance';
$active_page = 'view_attendance';
$base_path = '../';

try {
    $query = "
    SELECT s.name, c.course_name, a.date, a.status
    FROM attendance a
    JOIN students s ON a.student_id = s.student_id
    JOIN courses c ON a.course_id = c.course_id
    ORDER BY a.date DESC
    ";
    $stmt = $conn->query($query);
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching attendance: " . $e->getMessage());
}

include '../includes/header.php';
?>

<div class="page-header">
    <h2>Attendance Records</h2>
    <p>View all recorded attendance entries.</p>
</div>

<div class="card">
    <div class="content-top">
        <span class="text-muted"><?php echo count($records); ?> record(s) found</span>
        <div class="content-top-actions">
            <a href="mark_attendance.php" class="btn btn-primary">+ Mark Attendance</a>
        </div>
    </div>

    <?php if (count($records) > 0) : ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $row) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['course_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['date'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <span class="badge <?php echo $row['status'] === 'Present' ? 'badge-present' : 'badge-absent'; ?>">
                                    <?php echo htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <div class="empty-state">No attendance records found.</div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
