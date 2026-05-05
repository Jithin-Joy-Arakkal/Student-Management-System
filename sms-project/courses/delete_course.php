<?php
require_once '../config/db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: view_courses.php");
    exit;
}

$course_id = $_GET['id'];

try {
    // Delete all related records first (cascade), then delete the course
    $conn->beginTransaction();

    // 1. Delete grades for this course
    $stmt = $conn->prepare("DELETE FROM grades WHERE course_id = :id");
    $stmt->execute([':id' => $course_id]);

    // 2. Delete attendance for this course
    $stmt = $conn->prepare("DELETE FROM attendance WHERE course_id = :id");
    $stmt->execute([':id' => $course_id]);

    // 3. Delete enrollments for this course
    $stmt = $conn->prepare("DELETE FROM enrollment WHERE course_id = :id");
    $stmt->execute([':id' => $course_id]);

    // 4. Delete the course
    $stmt = $conn->prepare("DELETE FROM courses WHERE course_id = :id");
    $stmt->execute([':id' => $course_id]);

    $conn->commit();

    header("Location: view_courses.php?msg=deleted");
    exit;
} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error deleting course: " . $e->getMessage();
}
?>
