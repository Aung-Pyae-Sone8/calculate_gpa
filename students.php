<?php 
include "config.php"; 
session_start();
if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Students</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<?php include "includes/navbar.php"; ?>

<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Students</h2>

    <?php
    // Handle Add Student
    if (isset($_POST['add'])) {
        $roll = $_POST['roll_number'];
        $name = $_POST['name'];
        $email = $_POST['email'];

        $stmt = $con->prepare("INSERT INTO students (roll_number, name, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $roll, $name, $email);

        if ($stmt->execute()) {
            echo "<p class='text-green-600 mb-3'>Student added!</p>";
        } else {
            echo "<p class='text-red-600 mb-3'>Error: Roll number or email already exists.</p>";
        }
    }

    // Handle Delete Student
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $con->query("DELETE FROM students WHERE id=$id");
        echo "<p class='text-green-600 mb-3'>Student deleted!</p>";
    }
    ?>

    <!-- Add Student Form -->
    <form method="POST" class="mb-4 grid grid-cols-3 gap-4">
        <input type="text" name="roll_number" placeholder="Roll Number" required class="p-2 border rounded">
        <input type="text" name="name" placeholder="Student Name" required class="p-2 border rounded">
        <input type="email" name="email" placeholder="Email" required class="p-2 border rounded">
        <button name="add" class="bg-blue-500 text-white px-3 py-2 rounded col-span-3">Add</button>
    </form>

    <!-- Student Table -->
    <table class="table-auto w-full border bg-white shadow rounded">
        <tr class="bg-gray-200">
            <th class="p-2 border">Roll Number</th>
            <th class="p-2 border">Name</th>
            <th class="p-2 border">Email</th>
            <th class="p-2 border">Actions</th>
        </tr>
        <?php
        $res = $con->query("SELECT * FROM students ORDER BY roll_number ASC");
        while ($row = $res->fetch_assoc()) {
            echo "<tr>
                    <td class='p-2 border'>{$row['roll_number']}</td>
                    <td class='p-2 border'>{$row['name']}</td>
                    <td class='p-2 border'>{$row['email']}</td>
                    <td class='p-2 border text-center'>
                        <a href='edit_student.php?id={$row['id']}' class='text-blue-500 hover:text-blue-700 mr-2'>✏️</a>
                        <a href='students.php?delete={$row['id']}' onclick=\"return confirm('Are you sure?');\" class='text-red-500 hover:text-red-700'>🗑️</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
