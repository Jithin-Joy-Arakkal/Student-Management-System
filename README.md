# Student Management System

A robust PHP and PLpgSQL based web application for educational institutes to manage students, courses, enrollment, attendance, and grades.

## Features
- Student registration, editing, and deletion
- Course management
- Enroll/unenroll students
- Attendance recording/tracking module
- Grade entry and reporting
- Safe cascading delete logic (removes all related data)
- Responsive UI using CSS

## How It Works
- Central dashboard lets administrators access all functional modules:
    - Students, Courses, Enrollment, Attendance, Grades
- Add, edit, or delete records with real-time database integrity
- Smart deletion routines clean up all associated data (grades, attendance, etc.)
- Data persistence is handled through PHP and PL/pgSQL (PostgreSQL) operations

## Setup
1. Clone the repository:
   ```sh
   git clone https://github.com/jithin-joy-arakkal/Student-Management-System.git
   ```
2. Import database schema and sample data as provided in the SQL files.
3. Update database credentials in `config/db.php`.
4. Deploy on a PHP-enabled server with PostgreSQL access.

## File Structure
- `sms-project/` – Main application directory
- `students/`, `courses/`, `attendance/`, `grades/` – Modules
- `config/` – Database config
- `includes/` – Page templates/partials

## License
MIT. See [LICENSE](LICENSE).
