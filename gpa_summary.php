<?php include "config.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>GPA Summary</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<?php include "includes/navbar.php"; ?>
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">GPA Summary (from View)</h2>
    <table class="table-auto w-full border">
        <tr class="bg-gray-200"><th class="p-2 border">Student</th><th class="p-2 border">Average GPA</th></tr>
        <?php
        $res = $con->query("SELECT * FROM student_gpa_summary");
        while ($row = $res->fetch_assoc()) {
            echo "<tr><td class='p-2 border'>{$row['name']}</td><td class='p-2 border'>{$row['average_gpa']}</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
