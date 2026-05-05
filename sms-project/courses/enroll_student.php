<?php
require_once '../config/db.php';

$message = "";
$error = "";

// Fetch all students for the dropdown
try {
    $stmt = $conn->prepare("SELECT student_id, name FROM students ORDER BY name ASC");
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching students: " . $e->getMessage());
}

// Fetch all courses for the dropdown
try {
    $stmt = $conn->prepare("SELECT course_id, course_name FROM courses ORDER BY course_name ASC");
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching courses: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'] ?? '';
    $course_id = $_POST['course_id'] ?? '';

    if (empty($student_id) || empty($course_id)) {
        $error = "Please select both a student and a course.";
    } else {
        try {
            $sql = "INSERT INTO enrollment (student_id, course_id)
                    VALUES (:student_id, :course_id)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':student_id' => $student_id,
                ':course_id' => $course_id
            ]);

            $message = "Student enrolled successfully.";
        } catch (PDOException $e) {
            if ($e->getCode() == '23505') {
                $error = "This student is already enrolled in the selected course.";
            } else {
                $error = "Error enrolling student: " . $e->getMessage();
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
    <title>Enroll Student</title>
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

        select {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 6px;
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
    <h2>Enroll Student in Course</h2>

    <?php if (!empty($message)) : ?>
        <p class="success"><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if (!empty($error)) : ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="student_id">Select Student</label>
        <select id="student_id" name="student_id" required>
            <option value="">-- Choose a Student --</option>
            <?php foreach ($students as $s) : ?>
                <option value="<?php echo $s['student_id']; ?>"
                    <?php echo (isset($student_id) && $student_id == $s['student_id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($s['name'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="course_id">Select Course</label>
        <select id="course_id" name="course_id" required>
            <option value="">-- Choose a Course --</option>
            <?php foreach ($courses as $c) : ?>
                <option value="<?php echo $c['course_id']; ?>"
                    <?php echo (isset($course_id) && $course_id == $c['course_id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($c['course_name'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Enroll Student</button>
    </form>

    <div class="links">
        <a href="view_enrollment.php">View Enrollments</a>
        <a href="view_courses.php">View Courses</a>
        <a href="../index.php">Back to Home</a>
    </div>
</div>

</body>
</html>
