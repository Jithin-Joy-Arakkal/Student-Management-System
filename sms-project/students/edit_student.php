<?php
require_once '../config/db.php';

$page_title = 'Edit Student';
$active_page = 'view_students';
$base_path = '../';

$message = "";
$error = "";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: view_students.php");
    exit;
}

$student_id = $_GET['id'];

try {
    $sql = "SELECT * FROM students WHERE student_id = :student_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':student_id' => $student_id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        die("Student not found.");
    }
} catch (PDOException $e) {
    die("Error fetching student: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name'] ?? '');
    $date_of_birth = $_POST['date_of_birth'] ?? '';
    $contact = trim($_POST['contact'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if (empty($name) || empty($date_of_birth) || empty($contact) || empty($address)) {
        $error = "All fields are required.";
    } else {
        try {
            $sql = "UPDATE students
                    SET name = :name,
                        date_of_birth = :date_of_birth,
                        contact = :contact,
                        address = :address
                    WHERE student_id = :student_id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':date_of_birth' => $date_of_birth,
                ':contact' => $contact,
                ':address' => $address,
                ':student_id' => $student_id
            ]);

            $message = "Student updated successfully.";

            $student['name'] = $name;
            $student['date_of_birth'] = $date_of_birth;
            $student['contact'] = $contact;
            $student['address'] = $address;

        } catch (PDOException $e) {
            if ($e->getCode() == '23505') {
                $error = "Contact already exists. Please use a unique contact number.";
            } else {
                $error = "Error updating student: " . $e->getMessage();
            }
        }
    }
}

include '../includes/header.php';
?>

<div class="page-header">
    <h2>Edit Student</h2>
    <p>Update the details for this student record.</p>
</div>

<div class="card">
    <div class="form-container">

        <?php if (!empty($message)) : ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if (!empty($error)) : ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Student Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($student['date_of_birth']); ?>" required>
            </div>

            <div class="form-group">
                <label for="contact">Contact Number</label>
                <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($student['contact']); ?>" required>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" rows="3" required><?php echo htmlspecialchars($student['address']); ?></textarea>
            </div>

            <button type="submit" class="btn btn-success">Update Student</button>
            <a href="view_students.php" class="btn btn-outline">Cancel</a>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>