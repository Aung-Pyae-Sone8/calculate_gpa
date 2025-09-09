<?php include "config.php"; ?>
<?php
session_start();
if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Result Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<?php include "includes/navbar.php"; ?>
<div class="p-6">
    <h2 class="text-3xl font-bold mb-6">Dashboard</h2>

    <div class="grid grid-cols-3 gap-6">
        <!-- Total Students -->
        <div class="bg-white p-6 rounded shadow text-center">
            <h3 class="text-lg font-semibold mb-2">Total Students</h3>
            <p class="text-2xl font-bold text-blue-600">
                <?php
                $res = $con->query("SELECT COUNT(*) AS total FROM students");
                $row = $res->fetch_assoc();
                echo $row['total'];
                ?>
            </p>
        </div>

        <!-- Total Courses -->
        <div class="bg-white p-6 rounded shadow text-center">
            <h3 class="text-lg font-semibold mb-2">Total Courses</h3>
            <p class="text-2xl font-bold text-green-600">
                <?php
                $res = $con->query("SELECT COUNT(*) AS total FROM courses");
                $row = $res->fetch_assoc();
                echo $row['total'];
                ?>
            </p>
        </div>

        <!-- Average GPA -->
        <div class="bg-white p-6 rounded shadow text-center">
            <h3 class="text-lg font-semibold mb-2">Overall Avg GPA</h3>
            <p class="text-2xl font-bold text-purple-600">
                <?php
                $res = $con->query("SELECT ROUND(AVG(average_gpa),2) AS avg_gpa FROM student_gpa_summary");
                $row = $res->fetch_assoc();
                echo $row['avg_gpa'] ? $row['avg_gpa'] : "N/A";
                ?>
            </p>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="mt-8">
        <h3 class="text-xl font-semibold mb-3">Quick Actions</h3>
        <div class="flex gap-4">
            <a href="students.php" class="bg-blue-500 text-white px-4 py-2 rounded">Manage Students</a>
            <a href="courses.php" class="bg-green-500 text-white px-4 py-2 rounded">Manage Courses</a>
            <a href="add_result.php" class="bg-yellow-500 text-white px-4 py-2 rounded">Add Result</a>
            <a href="transcript.php" class="bg-purple-500 text-white px-4 py-2 rounded">Get Transcript</a>
            <a href="gpa_summary.php" class="bg-indigo-500 text-white px-4 py-2 rounded">GPA Summary</a>
        </div>
    </div>
</div>
</body>
</html>
