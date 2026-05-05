<?php
require_once '../config/db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: view_courses.php");
    exit;
}

$course_id = $_GET['id'];

try {
    $sql = "DELETE FROM courses WHERE course_id = :course_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':course_id' => $course_id]);

    header("Location: view_courses.php?msg=deleted");
    exit;
} catch (PDOException $e) {
    // 23503 = foreign key violation (course is referenced in other tables)
    if ($e->getCode() == '23503') {
        header("Location: view_courses.php?msg=cannot_delete");
        exit;
    } else {
        echo "Error deleting course: " . $e->getMessage();
    }
}
?>
