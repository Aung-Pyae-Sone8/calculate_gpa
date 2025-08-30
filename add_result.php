<?php include "config.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Result</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<?php include "includes/navbar.php"; ?>
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Add Result</h2>
    <?php
    if (isset($_POST['add'])) {
        $student = $_POST['student'];
        $course = $_POST['course'];
        $marks = $_POST['marks'];

        $stmt = $con->prepare("INSERT INTO results (student_id, course_id, marks) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $student, $course, $marks);
        $stmt->execute();

        echo "<p class='text-green-600'>Result Added! GPA auto-calculated by trigger.</p>";
    }
    ?>
    <form method="POST">
        <select name="student" required class="p-2 border rounded">
            <option value="">Select Student</option>
            <?php
            $res = $con->query("SELECT * FROM students");
            while ($row = $res->fetch_assoc()) echo "<option value='{$row['id']}'>{$row['name']}</option>";
            ?>
        </select>
        <select name="course" required class="p-2 border rounded">
            <option value="">Select Course</option>
            <?php
            $res = $con->query("SELECT * FROM courses");
            while ($row = $res->fetch_assoc()) echo "<option value='{$row['id']}'>{$row['course_name']}</option>";
            ?>
        </select>
        <input type="number" name="marks" placeholder="Marks (0-100)" required class="p-2 border rounded">
        <button name="add" class="bg-green-500 text-white px-3 py-2 rounded">Add</button>
    </form>
</div>
</body>
</html>
