<?php
require_once '../config/db.php';

try {
    $sql = "SELECT * FROM students ORDER BY student_id ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching students: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
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

        .edit-btn {
            background: #28a745;
        }

        .edit-btn:hover {
            background: #1e7e34;
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
    <h2>Student List</h2>

    <div class="top-links">
        <a href="add_student.php">Add Student</a>
        <a href="../index.php">Back to Home</a>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted') : ?>
        <p class="message success">Student deleted successfully.</p>
    <?php endif; ?>

    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'cannot_delete') : ?>
        <p class="message error">
            Cannot delete student because related records exist in enrollment, attendance, or grades.
        </p>
    <?php endif; ?>

    <?php if (count($students) > 0) : ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date of Birth</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>

            <?php foreach ($students as $row) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['student_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['date_of_birth'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['contact'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['address'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="action-links">
                        <a class="edit-btn" href="edit_student.php?id=<?php echo $row['student_id']; ?>">Edit</a>
                        <a class="delete-btn"
                           href="delete_student.php?id=<?php echo $row['student_id']; ?>"
                           onclick="return confirm('Are you sure you want to delete this student?')">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <p class="no-data">No students found.</p>
    <?php endif; ?>
</div>

</body>
</html>