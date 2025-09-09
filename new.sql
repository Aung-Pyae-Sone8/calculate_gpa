-- =====================
-- Database Schema
-- =====================

-- Students Table (Modified)
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    roll_number VARCHAR(20) UNIQUE NOT NULL, -- New Roll Number column
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL
);


-- Teachers
CREATE TABLE teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, -- store hashed password
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Courses
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_code VARCHAR(20) UNIQUE,
    course_name VARCHAR(100),
    credits INT
);

-- Results
CREATE TABLE results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    course_id INT,
    marks INT CHECK (marks BETWEEN 0 AND 100),
    grade CHAR(2),
    gpa DECIMAL(3,2),
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- =====================
-- Functions
-- =====================

DELIMITER //
CREATE FUNCTION getGrade(marks INT) RETURNS CHAR(2)
DETERMINISTIC
BEGIN
    DECLARE grade CHAR(2);
    IF marks >= 90 THEN
        SET grade = 'A';
    ELSEIF marks >= 80 THEN
        SET grade = 'B';
    ELSEIF marks >= 70 THEN
        SET grade = 'C';
    ELSEIF marks >= 60 THEN
        SET grade = 'D';
    ELSE
        SET grade = 'F';
    END IF;
    RETURN grade;
END;
//
DELIMITER ;

DELIMITER //
CREATE FUNCTION getGPA(grade CHAR(2)) RETURNS DECIMAL(3,2)
DETERMINISTIC
BEGIN
    DECLARE points DECIMAL(3,2);
    CASE grade
        WHEN 'A' THEN SET points = 4.0;
        WHEN 'B' THEN SET points = 3.0;
        WHEN 'C' THEN SET points = 2.0;
        WHEN 'D' THEN SET points = 1.0;
        ELSE SET points = 0.0;
    END CASE;
    RETURN points;
END;
//
DELIMITER ;

-- Classify Student
DELIMITER //
CREATE FUNCTION classifyStudent(avgGpa DECIMAL(3,2)) RETURNS VARCHAR(20)
DETERMINISTIC
BEGIN
    DECLARE result VARCHAR(20);
    IF avgGpa >= 3.5 THEN
        SET result = 'Honors';
    ELSEIF avgGpa >= 2.0 THEN
        SET result = 'Pass';
    ELSE
        SET result = 'Fail';
    END IF;
    RETURN result;
END;
//
DELIMITER ;

-- =====================
-- Triggers
-- =====================

DELIMITER //
CREATE TRIGGER before_result_insert
BEFORE INSERT ON results
FOR EACH ROW
BEGIN
    SET NEW.grade = getGrade(NEW.marks);
    SET NEW.gpa = getGPA(getGrade(NEW.marks));
END;
//
DELIMITER ;

DELIMITER //
CREATE TRIGGER before_result_update
BEFORE UPDATE ON results
FOR EACH ROW
BEGIN
    SET NEW.grade = getGrade(NEW.marks);
    SET NEW.gpa = getGPA(getGrade(NEW.marks));
END;
//
DELIMITER ;

DELIMITER //
CREATE TRIGGER before_teacher_insert
BEFORE INSERT ON teachers
FOR EACH ROW
BEGIN
    SET NEW.email = LOWER(NEW.email);
END;
//
DELIMITER ;

-- =====================
-- Procedures
-- =====================

DELIMITER //
CREATE PROCEDURE getTranscript(IN studentId INT)
BEGIN
    SELECT s.name, c.course_name, r.marks, r.grade, r.gpa
    FROM results r
    JOIN students s ON r.student_id = s.id
    JOIN courses c ON r.course_id = c.id
    WHERE s.id = studentId;
END;
//
DELIMITER ;

DELIMITER //
CREATE PROCEDURE getGpaSummary()
BEGIN
    SELECT s.id, s.name, ROUND(AVG(r.gpa),1) AS avg_gpa, classifyStudent(AVG(r.gpa)) AS status
    FROM students s
    JOIN results r ON s.id = r.student_id
    GROUP BY s.id
    ORDER BY avg_gpa DESC;
END;
//
DELIMITER ;

-- =====================
-- Views
-- =====================

CREATE OR REPLACE VIEW student_gpa_summary AS
SELECT 
    s.id, 
    s.name, 
    ROUND(AVG(r.gpa),1) AS average_gpa,
    classifyStudent(AVG(r.gpa)) AS status
FROM students s
JOIN results r ON s.id = r.student_id
GROUP BY s.id;
