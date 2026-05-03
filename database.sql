---------TABLE------------

create table students(
    student_id serial primary key,
    name text not null,
    date_of_birth date not null,
    contact text not null unique,
    address text not null
);

create table courses(
    course_id serial primary key,
    course_name text not null,
    credits int not null check (credits > 0 and credits <= 6)
);

create table enrollment(
    enrollment_id serial primary key,
    student_id int not null references students(student_id),
    course_id int not null references courses(course_id),
    unique(student_id, course_id)
);

create table attendance(
    attendance_id serial primary key,
    student_id int not null references students(student_id),
    course_id int not null references courses(course_id),
    date date not null,
    status text not null check (status in ('Present', 'Absent')),
    unique(student_id, course_id, date)
);

create table grades(
    grade_id serial primary key,
    student_id int not null references students(student_id),
    course_id int not null references courses(course_id),
    marks int not null check (marks >= 0 and marks <= 100),
    grade char(1) not null check (grade in ('S', 'A', 'B', 'C', 'D', 'F')),
    unique(student_id, course_id)
);

-----------TRIGGER FUNCTION------------

CREATE OR REPLACE FUNCTION set_grade()
RETURNS TRIGGER AS $$
BEGIN
    IF NEW.marks >= 90 THEN
        NEW.grade := 'S';
    ELSIF NEW.marks >= 80 THEN
        NEW.grade := 'A';
    ELSIF NEW.marks >= 70 THEN
        NEW.grade := 'B';
    ELSIF NEW.marks >= 60 THEN
        NEW.grade := 'C';
    ELSIF NEW.marks >= 50 THEN
        NEW.grade := 'D';
    ELSE
        NEW.grade := 'F';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-----------TRIGGER------------

CREATE TRIGGER grade_auto_update
BEFORE INSERT OR UPDATE ON grades
FOR EACH ROW
EXECUTE FUNCTION set_grade();

-----------SAMPLE DATA------------

insert into students (name, date_of_birth, contact, address)
values
('John', '2005-06-15', '9876543210', 'Thrissur'),
('Alice', '2006-01-01', '1234567890', 'Ernakulam');

insert into courses (course_name, credits)
values 
('DBMS', 4),
('OS', 3);

insert into enrollment (student_id, course_id)
values (1, 1), (2, 2);

insert into grades (student_id, course_id, marks)
values (1, 1, 85);