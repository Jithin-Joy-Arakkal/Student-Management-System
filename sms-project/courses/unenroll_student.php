<?php
require_once '../config/db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: view_enrollment.php");
    exit;
}

$enrollment_id = $_GET['id'];

try {
    // Get student_id and course_id for this enrollment to delete related records
    $stmt = $conn->prepare("SELECT student_id, course_id FROM enrollment WHERE enrollment_id = :id");
    $stmt->execute([':id' => $enrollment_id]);
    $enrollment = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$enrollment) {
        header("Location: view_enrollment.php");
        exit;
    }

    $conn->beginTransaction();

    // 1. Delete grades for this student-course pair
    $stmt = $conn->prepare("DELETE FROM grades WHERE student_id = :sid AND course_id = :cid");
    $stmt->execute([':sid' => $enrollment['student_id'], ':cid' => $enrollment['course_id']]);

    // 2. Delete attendance for this student-course pair
    $stmt = $conn->prepare("DELETE FROM attendance WHERE student_id = :sid AND course_id = :cid");
    $stmt->execute([':sid' => $enrollment['student_id'], ':cid' => $enrollment['course_id']]);

    // 3. Delete the enrollment
    $stmt = $conn->prepare("DELETE FROM enrollment WHERE enrollment_id = :id");
    $stmt->execute([':id' => $enrollment_id]);

    $conn->commit();

    header("Location: view_enrollment.php?msg=unenrolled");
    exit;
} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error unenrolling student: " . $e->getMessage();
}
?>
