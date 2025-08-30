<?php include "config.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Courses</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<?php include "includes/navbar.php"; ?>

<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Courses</h2>

    <!-- Add Course Form -->
    <?php
    if (isset($_POST['add'])) {
        $code = $_POST['course_code'];
        $name = $_POST['course_name'];
        $credits = $_POST['credits'];

        $stmt = $con->prepare("INSERT INTO courses (course_code, course_name, credits) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $code, $name, $credits);

        if ($stmt->execute()) {
            echo "<p class='text-green-600 mb-4'>Course added successfully!</p>";
        } else {
            echo "<p class='text-red-600 mb-4'>Error: Course code already exists.</p>";
        }
    }
    ?>

    <form method="POST" class="mb-6 grid grid-cols-4 gap-4">
        <input type="text" name="course_code" placeholder="Course Code" required class="p-2 border rounded col-span-1">
        <input type="text" name="course_name" placeholder="Course Name" required class="p-2 border rounded col-span-2">
        <input type="number" name="credits" placeholder="Credits" min="1" required class="p-2 border rounded col-span-1">
        <button name="add" class="bg-blue-500 text-white px-4 py-2 rounded col-span-4">Add Course</button>
    </form>

    <!-- Course List -->
    <table class="table-auto w-full border bg-white rounded shadow">
        <tr class="bg-gray-200">
            <th class="p-2 border">Course Code</th>
            <th class="p-2 border">Course Name</th>
            <th class="p-2 border">Credits</th>
        </tr>
        <?php
        $res = $con->query("SELECT * FROM courses ORDER BY course_code ASC");
        while ($row = $res->fetch_assoc()) {
            echo "<tr>
                    <td class='p-2 border'>{$row['course_code']}</td>
                    <td class='p-2 border'>{$row['course_name']}</td>
                    <td class='p-2 border text-center'>{$row['credits']}</td>
                  </tr>";
        }
        ?>
    </table>
</div>

</body>
</html>
