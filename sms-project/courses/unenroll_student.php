<?php
require_once '../config/db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: view_enrollment.php");
    exit;
}

$enrollment_id = $_GET['id'];

try {
    $sql = "DELETE FROM enrollment WHERE enrollment_id = :enrollment_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':enrollment_id' => $enrollment_id]);

    header("Location: view_enrollment.php?msg=unenrolled");
    exit;
} catch (PDOException $e) {
    // 23503 = foreign key violation (enrollment is referenced in attendance or grades)
    if ($e->getCode() == '23503') {
        header("Location: view_enrollment.php?msg=cannot_unenroll");
        exit;
    } else {
        echo "Error unenrolling student: " . $e->getMessage();
    }
}
?>
