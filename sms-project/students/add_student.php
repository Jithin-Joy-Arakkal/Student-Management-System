<?php
require_once '../config/db.php';

$page_title = 'Add Student';
$active_page = 'add_student';
$base_path = '../';

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name'] ?? '');
    $date_of_birth = $_POST['date_of_birth'] ?? '';
    $contact = trim($_POST['contact'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if (empty($name) || empty($date_of_birth) || empty($contact) || empty($address)) {
        $error = "All fields are required.";
    } else {
        try {
            $sql = "INSERT INTO students (name, date_of_birth, contact, address)
                    VALUES (:name, :date_of_birth, :contact, :address)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':date_of_birth' => $date_of_birth,
                ':contact' => $contact,
                ':address' => $address
            ]);

            $message = "Student added successfully.";

            $name = "";
            $date_of_birth = "";
            $contact = "";
            $address = "";
        } catch (PDOException $e) {
            if ($e->getCode() == '23505') {
                $error = "Contact already exists. Please use a unique contact number.";
            } else {
                $error = "Error adding student: " . $e->getMessage();
            }
        }
    }
}

include '../includes/header.php';
?>

<div class="page-header">
    <h2>Add Student</h2>
    <p>Create a new student record in the system.</p>
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
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" placeholder="Enter full name" required>
            </div>

            <div class="form-group">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($date_of_birth ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="contact">Contact Number</label>
                <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($contact ?? ''); ?>" placeholder="Enter contact number" required>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" rows="3" placeholder="Enter address" required><?php echo htmlspecialchars($address ?? ''); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Add Student</button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>