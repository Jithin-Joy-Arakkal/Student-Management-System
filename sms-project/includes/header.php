<?php
// Shared header with sidebar navigation
// Usage: Set $page_title before including this file
if (!isset($page_title)) $page_title = 'Student Management System';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?> — SMS</title>
    <link rel="stylesheet" href="<?php echo $base_path ?? ''; ?>style.css">
</head>
<body>
<div class="layout">

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h1>Student Management</h1>
            <span>Administration Panel</span>
        </div>

        <nav class="sidebar-nav">
            <!-- Dashboard -->
            <div class="nav-section">
                <a href="<?php echo $base_path ?? ''; ?>index.php"
                   class="nav-link <?php echo ($active_page ?? '') === 'dashboard' ? 'active' : ''; ?>">
                    <span class="nav-icon">■</span> Dashboard
                </a>
            </div>

            <!-- Students -->
            <div class="nav-section">
                <div class="nav-section-title">Students</div>
                <a href="<?php echo $base_path ?? ''; ?>students/view_students.php"
                   class="nav-link <?php echo ($active_page ?? '') === 'view_students' ? 'active' : ''; ?>">
                    <span class="nav-icon">○</span> View Students
                </a>
                <a href="<?php echo $base_path ?? ''; ?>students/add_student.php"
                   class="nav-link <?php echo ($active_page ?? '') === 'add_student' ? 'active' : ''; ?>">
                    <span class="nav-icon">+</span> Add Student
                </a>
            </div>

            <!-- Courses -->
            <div class="nav-section">
                <div class="nav-section-title">Courses</div>
                <a href="<?php echo $base_path ?? ''; ?>courses/view_courses.php"
                   class="nav-link <?php echo ($active_page ?? '') === 'view_courses' ? 'active' : ''; ?>">
                    <span class="nav-icon">○</span> View Courses
                </a>
                <a href="<?php echo $base_path ?? ''; ?>courses/add_course.php"
                   class="nav-link <?php echo ($active_page ?? '') === 'add_course' ? 'active' : ''; ?>">
                    <span class="nav-icon">+</span> Add Course
                </a>
            </div>

            <!-- Enrollment -->
            <div class="nav-section">
                <div class="nav-section-title">Enrollment</div>
                <a href="<?php echo $base_path ?? ''; ?>courses/view_enrollment.php"
                   class="nav-link <?php echo ($active_page ?? '') === 'view_enrollment' ? 'active' : ''; ?>">
                    <span class="nav-icon">○</span> View Enrollments
                </a>
                <a href="<?php echo $base_path ?? ''; ?>courses/enroll_student.php"
                   class="nav-link <?php echo ($active_page ?? '') === 'enroll_student' ? 'active' : ''; ?>">
                    <span class="nav-icon">+</span> Enroll Student
                </a>
            </div>

            <!-- Attendance -->
            <div class="nav-section">
                <div class="nav-section-title">Attendance</div>
                <a href="<?php echo $base_path ?? ''; ?>attendance/view_attendance.php"
                   class="nav-link <?php echo ($active_page ?? '') === 'view_attendance' ? 'active' : ''; ?>">
                    <span class="nav-icon">○</span> View Attendance
                </a>
                <a href="<?php echo $base_path ?? ''; ?>attendance/mark_attendance.php"
                   class="nav-link <?php echo ($active_page ?? '') === 'mark_attendance' ? 'active' : ''; ?>">
                    <span class="nav-icon">+</span> Mark Attendance
                </a>
            </div>

            <!-- Grades -->
            <div class="nav-section">
                <div class="nav-section-title">Grades</div>
                <a href="<?php echo $base_path ?? ''; ?>grades/view_grades.php"
                   class="nav-link <?php echo ($active_page ?? '') === 'view_grades' ? 'active' : ''; ?>">
                    <span class="nav-icon">○</span> View Grades
                </a>
                <a href="<?php echo $base_path ?? ''; ?>grades/add_grade.php"
                   class="nav-link <?php echo ($active_page ?? '') === 'add_grade' ? 'active' : ''; ?>">
                    <span class="nav-icon">+</span> Add Marks
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
