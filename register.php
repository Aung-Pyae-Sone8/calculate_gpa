<?php include "config.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Teacher Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
<div class="bg-white p-6 rounded shadow w-96">
    <h2 class="text-2xl font-bold mb-4">Teacher Register</h2>
    <?php
    if (isset($_POST['register'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $stmt = $con->prepare("INSERT INTO teachers (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            echo "<p class='text-green-600'>Registered successfully! <a href='login.php' class='text-blue-500'>Login</a></p>";
        } else {
            echo "<p class='text-red-600'>Error: Email already exists.</p>";
        }
    }
    ?>
    <form method="POST" class="space-y-3">
        <input type="text" name="name" placeholder="Name" required class="p-2 border rounded w-full">
        <input type="email" name="email" placeholder="Email" required class="p-2 border rounded w-full">
        <input type="password" name="password" placeholder="Password" required class="p-2 border rounded w-full">
        <button name="register" class="bg-green-500 text-white px-4 py-2 rounded w-full">Register</button>
    </form>
</div>
</body>
</html>
