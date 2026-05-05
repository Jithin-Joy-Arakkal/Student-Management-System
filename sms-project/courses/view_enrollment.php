<?php
require_once '../config/db.php';

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Enrollments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 90%;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .top-links {
            margin-bottom: 15px;
            text-align: center;
        }

        .top-links a {
            text-decoration: none;
            color: white;
            background: #007bff;
            padding: 10px 15px;
            border-radius: 6px;
            margin: 0 5px;
            display: inline-block;
        }

        .top-links a:hover {
            background: #0056b3;
        }

        .message {
            text-align: center;
            margin-bottom: 15px;
        }

        .message.success {
            color: green;
        }

        .message.error {
            color: red;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        .action-links a {
            text-decoration: none;
            padding: 6px 10px;
            border-radius: 5px;
            color: white;
            margin: 0 4px;
        }

        .delete-btn {
            background: #dc3545;
        }

        .delete-btn:hover {
            background: #b52a37;
        }

        .no-data {
            text-align: center;
            color: #555;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Enrollment List</h2>

    <div class="top-links">
        <a href="enroll_student.php">Enroll Student</a>
        <a href="view_courses.php">View Courses</a>
        <a href="../index.php">Back to Home</a>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'unenrolled') : ?>
        <p class="message success">Student unenrolled successfully.</p>
    <?php endif; ?>

    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'cannot_unenroll') : ?>
        <p class="message error">
            Cannot unenroll student because related attendance or grade records exist.
        </p>
    <?php endif; ?>

    <?php if (count($enrollments) > 0) : ?>
        <table>
            <tr>
                <th>Enrollment ID</th>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Course ID</th>
                <th>Course Name</th>
                <th>Actions</th>
            </tr>

            <?php foreach ($enrollments as $row) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['enrollment_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['student_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['student_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['course_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['course_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="action-links">
                        <a class="delete-btn"
                           href="unenroll_student.php?id=<?php echo $row['enrollment_id']; ?>"
                           onclick="return confirm('Are you sure you want to unenroll this student?')">
                            Unenroll
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <p class="no-data">No enrollments found.</p>
    <?php endif; ?>
</div>

</body>
</html>
