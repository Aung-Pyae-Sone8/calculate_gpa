<?php
session_start();
require_once "config.php";

// ✅ Check if teacher is logged in
if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit();
}

// ✅ Handle logout request
if (isset($_POST['logout'])) {
    session_unset();   // remove all session variables
    session_destroy(); // destroy the session
    header("Location: login.php");
    exit();
}

// ✅ Fetch teacher data
$id = $_SESSION['teacher_id'];
$stmt = $con->prepare("SELECT * FROM teachers WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$teacher = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <div class="max-w-lg mx-auto mt-10 bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">My Profile</h2>

        <form method="post" action="">
            <label class="block mb-2">Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($teacher['name']); ?>" class="w-full border p-2 mb-4">

            <label class="block mb-2">Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($teacher['email']); ?>" class="w-full border p-2 mb-4" readonly>

            <button type="submit" name="update" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
        </form>

        <!-- ✅ Logout button -->
        <form method="post" class="mt-4">
            <button type="submit" name="logout" class="bg-red-500 text-white px-4 py-2 rounded">Logout</button>
        </form>
    </div>
</body>
</html>
