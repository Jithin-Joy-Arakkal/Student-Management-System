<?php
$page_title = 'Dashboard';
$active_page = 'dashboard';
$base_path = '';
include 'includes/header.php';
?>

<div class="page-header">
    <h2>Dashboard</h2>
    <p>Welcome to the Student Management System. Select a module below.</p>
</div>

<div class="dashboard-grid">
    <!-- Students -->
    <div class="dashboard-card">
        <div class="dashboard-card-title">Students</div>
        <div class="dashboard-card-desc">Manage student records and personal details</div>
        <div class="dashboard-card-links">
            <a href="students/view_students.php">→ View Students</a>
            <a href="students/add_student.php">→ Add Student</a>
        </div>
    </div>

    <!-- Courses -->
    <div class="dashboard-card">
        <div class="dashboard-card-title">Courses</div>
        <div class="dashboard-card-desc">Add, edit, and manage course offerings</div>
        <div class="dashboard-card-links">
            <a href="courses/view_courses.php">→ View Courses</a>
            <a href="courses/add_course.php">→ Add Course</a>
        </div>
    </div>

    <!-- Enrollment -->
    <div class="dashboard-card">
        <div class="dashboard-card-title">Enrollment</div>
        <div class="dashboard-card-desc">Enroll students into courses and manage registrations</div>
        <div class="dashboard-card-links">
            <a href="courses/view_enrollment.php">→ View Enrollments</a>
            <a href="courses/enroll_student.php">→ Enroll Student</a>
        </div>
    </div>

    <!-- Attendance -->
    <div class="dashboard-card">
        <div class="dashboard-card-title">Attendance</div>
        <div class="dashboard-card-desc">Track and record student attendance by course</div>
        <div class="dashboard-card-links">
            <a href="attendance/view_attendance.php">→ View Attendance</a>
            <a href="attendance/mark_attendance.php">→ Mark Attendance</a>
        </div>
    </div>

    <!-- Grades -->
    <div class="dashboard-card">
        <div class="dashboard-card-title">Grades</div>
        <div class="dashboard-card-desc">Enter marks and view auto-calculated grades</div>
        <div class="dashboard-card-links">
            <a href="grades/view_grades.php">→ View Grades</a>
            <a href="grades/add_grade.php">→ Add Marks</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>