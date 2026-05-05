<?php
require_once '../config/db.php';

$message = "";
$error = "";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: view_courses.php");
    exit;
}

$course_id = $_GET['id'];

try {
    $sql = "SELECT * FROM courses WHERE course_id = :course_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':course_id' => $course_id]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$course) {
        die("Course not found.");
    }
} catch (PDOException $e) {
    die("Error fetching course: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = trim($_POST['course_name'] ?? '');
    $credits = $_POST['credits'] ?? '';

    if (empty($course_name) || empty($credits)) {
        $error = "All fields are required.";
    } elseif ($credits < 1 || $credits > 6) {
        $error = "Credits must be between 1 and 6.";
    } else {
        try {
            $sql = "UPDATE courses
                    SET course_name = :course_name,
                        credits = :credits
                    WHERE course_id = :course_id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':course_name' => $course_name,
                ':credits' => $credits,
                ':course_id' => $course_id
            ]);

            $message = "Course updated successfully.";

            $course['course_name'] = $course_name;
            $course['credits'] = $credits;

        } catch (PDOException $e) {
            $error = "Error updating course: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
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

        input {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            margin-top: 18px;
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #1e7e34;
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
    <h2>Edit Course</h2>

    <?php if (!empty($message)) : ?>
        <p class="success"><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if (!empty($error)) : ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="course_name">Course Name</label>
        <input type="text" id="course_name" name="course_name" value="<?php echo htmlspecialchars($course['course_name']); ?>" required>

        <label for="credits">Credits (1–6)</label>
        <input type="number" id="credits" name="credits" min="1" max="6" value="<?php echo htmlspecialchars($course['credits']); ?>" required>

        <button type="submit">Update Course</button>
    </form>

    <div class="links">
        <a href="view_courses.php">View Courses</a>
        <a href="../index.php">Back to Home</a>
    </div>
</div>

</body>
</html>
