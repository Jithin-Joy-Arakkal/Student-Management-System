<?php
require_once '../config/db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: view_students.php");
    exit;
}

$student_id = $_GET['id'];

try {
    // Delete all related records first (cascade), then delete the student
    $conn->beginTransaction();

    // 1. Delete grades for this student
    $stmt = $conn->prepare("DELETE FROM grades WHERE student_id = :id");
    $stmt->execute([':id' => $student_id]);

    // 2. Delete attendance for this student
    $stmt = $conn->prepare("DELETE FROM attendance WHERE student_id = :id");
    $stmt->execute([':id' => $student_id]);

    // 3. Delete enrollments for this student
    $stmt = $conn->prepare("DELETE FROM enrollment WHERE student_id = :id");
    $stmt->execute([':id' => $student_id]);

    // 4. Delete the student
    $stmt = $conn->prepare("DELETE FROM students WHERE student_id = :id");
    $stmt->execute([':id' => $student_id]);

    $conn->commit();

    header("Location: view_students.php?msg=deleted");
    exit;
} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error deleting student: " . $e->getMessage();
}
?>