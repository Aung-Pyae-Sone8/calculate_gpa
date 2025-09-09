<?php
session_start();
include "config.php";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT * FROM teachers WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows == 1) {
        $row = $res->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['teacher_id'] = $row['id'];
            $_SESSION['teacher_name'] = $row['name'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "Teacher not found!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Teacher Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded shadow w-96">
        <h2 class="text-2xl font-bold mb-4">Teacher Login</h2>
        <?php if (isset($error)) echo "<p class='text-red-600 mb-3'>$error</p>"; ?>
        
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required class="p-2 border rounded w-full mb-3">
            <input type="password" name="password" placeholder="Password" required class="p-2 border rounded w-full mb-3">
            <button name="login" class="bg-blue-500 text-white px-4 py-2 rounded w-full">Login</button>
        </form>

        <!-- 🔹 Register Link -->
        <p class="mt-4 text-center text-sm">
            Don’t have an account? 
            <a href="register.php" class="text-blue-600 hover:underline">Register here</a>
        </p>
    </div>
</body>
</html>
