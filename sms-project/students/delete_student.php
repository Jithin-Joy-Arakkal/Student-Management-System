<?php
require_once '../config/db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: view_students.php");
    exit;
}

$student_id = $_GET['id'];

try {
    $sql = "DELETE FROM students WHERE student_id = :student_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':student_id' => $student_id]);

    header("Location: view_students.php?msg=deleted");
    exit;
} catch (PDOException $e) {
    // 23503 = foreign key violation (student is referenced in other tables)
    if ($e->getCode() == '23503') {
        header("Location: view_students.php?msg=cannot_delete");
        exit;
    } else {
        echo "Error deleting student: " . $e->getMessage();
    }
}
?>