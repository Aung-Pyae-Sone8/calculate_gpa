<?php include "config.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Students</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<?php include "includes/navbar.php"; ?>
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Students</h2>
    <?php
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $stmt = $con->prepare("INSERT INTO students (name, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $email);
        $stmt->execute();
        echo "<p class='text-green-600'>Student added!</p>";
    }
    ?>
    <form method="POST" class="mb-4">
        <input type="text" name="name" placeholder="Student Name" required class="p-2 border rounded">
        <input type="email" name="email" placeholder="Email" required class="p-2 border rounded">
        <button name="add" class="bg-blue-500 text-white px-3 py-2 rounded">Add</button>
    </form>
    <table class="table-auto w-full border">
        <tr class="bg-gray-200"><th class="p-2 border">Name</th><th class="p-2 border">Email</th></tr>
        <?php
        $res = $con->query("SELECT * FROM students");
        while ($row = $res->fetch_assoc()) {
            echo "<tr><td class='p-2 border'>{$row['name']}</td><td class='p-2 border'>{$row['email']}</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
