<?php include "config.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Transcript</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<?php include "includes/navbar.php"; ?>
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Transcript</h2>
    <form method="POST">
        <select name="student" required class="p-2 border rounded">
            <option value="">Select Student</option>
            <?php
            $res = $con->query("SELECT * FROM students");
            while ($row = $res->fetch_assoc()) echo "<option value='{$row['id']}'>{$row['name']}</option>";
            ?>
        </select>
        <button name="get" class="bg-blue-500 text-white px-3 py-2 rounded">Get Transcript</button>
    </form>
    <?php
    if (isset($_POST['get'])) {
        $id = $_POST['student'];
        $res = $con->query("CALL getTranscript($id)");
        echo "<table class='table-auto w-full border mt-4'>
              <tr class='bg-gray-200'><th class='p-2 border'>Course</th><th class='p-2 border'>Marks</th><th class='p-2 border'>Grade</th><th class='p-2 border'>GPA</th></tr>";
        while ($row = $res->fetch_assoc()) {
            echo "<tr><td class='p-2 border'>{$row['course_name']}</td><td class='p-2 border'>{$row['marks']}</td><td class='p-2 border'>{$row['grade']}</td><td class='p-2 border'>{$row['gpa']}</td></tr>";
        }
        echo "</table>";
    }
    ?>
</div>
</body>
</html>
