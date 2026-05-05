<?php
require_once '../config/db.php';

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 40px auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 12px;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        textarea {
            resize: vertical;
        }

        button {
            margin-top: 18px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        .success {
            color: green;
            margin-top: 15px;
            text-align: center;
        }

        .error {
            color: red;
            margin-top: 15px;
            text-align: center;
        }

        .links {
            margin-top: 20px;
            text-align: center;
        }

        .links a {
            text-decoration: none;
            color: #007bff;
            margin: 0 10px;
        }

        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Add Student</h2>

    <?php if (!empty($message)) : ?>
        <p class="success"><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if (!empty($error)) : ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="name">Student Name</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>

        <label for="date_of_birth">Date of Birth</label>
        <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($date_of_birth ?? ''); ?>" required>

        <label for="contact">Contact</label>
        <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($contact ?? ''); ?>" required>

        <label for="address">Address</label>
        <textarea id="address" name="address" rows="4" required><?php echo htmlspecialchars($address ?? ''); ?></textarea>

        <button type="submit">Add Student</button>
    </form>

    <div class="links">
        <a href="view_students.php">View Students</a>
        <a href="../index.php">Back to Home</a>
    </div>
</div>

</body>
</html>