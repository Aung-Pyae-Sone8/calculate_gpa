<?php 
include "config.php"; 
session_start();
if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit();
}

// Get student ID
if (!isset($_GET['id'])) {
    header("Location: students.php");
    exit();
}

$id = intval($_GET['id']);

// Fetch student details
$stmt = $con->prepare("SELECT * FROM students WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    echo "<p class='text-red-600 p-4'>Student not found!</p>";
    exit();
}

// Handle form submission
if (isset($_POST['update'])) {
    $roll = $_POST['roll_number'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    $update = $con->prepare("UPDATE students SET roll_number=?, name=?, email=? WHERE id=?");
    $update->bind_param("sssi", $roll, $name, $email, $id);

    if ($update->execute()) {
        header("Location: students.php?msg=updated");
        exit();
    } else {
        echo "<p class='text-red-600 p-4'>Error updating student. Roll number or email might already exist.</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<?php include "includes/navbar.php"; ?>

<div class="p-6 max-w-lg mx-auto bg-white shadow rounded">
    <h2 class="text-2xl font-bold mb-4">Edit Student</h2>

    <form method="POST" class="grid gap-4">
        <input type="text" name="roll_number" value="<?php echo htmlspecialchars($student['roll_number']); ?>" required class="p-2 border rounded">
        <input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required class="p-2 border rounded">
        <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required class="p-2 border rounded">
        <div class="flex justify-between">
            <a href="students.php" class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</a>
            <button type="submit" name="update" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
        </div>
    </form>
</div>
</body>
</html>
