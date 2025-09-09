<?php 
include "config.php"; 
session_start();
if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit();
}

// Get course ID
if (!isset($_GET['id'])) {
    header("Location: courses.php");
    exit();
}

$id = intval($_GET['id']);

// Fetch course details
$stmt = $con->prepare("SELECT * FROM courses WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$course = $result->fetch_assoc();

if (!$course) {
    echo "<p class='text-red-600 p-4'>Course not found!</p>";
    exit();
}

// Handle update
if (isset($_POST['update'])) {
    $code = $_POST['course_code'];
    $name = $_POST['course_name'];
    $credits = $_POST['credits'];

    $update = $con->prepare("UPDATE courses SET course_code=?, course_name=?, credits=? WHERE id=?");
    $update->bind_param("ssii", $code, $name, $credits, $id);

    if ($update->execute()) {
        header("Location: courses.php?msg=updated");
        exit();
    } else {
        echo "<p class='text-red-600 p-4'>Error updating course. Course code might already exist.</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Course</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<?php include "includes/navbar.php"; ?>

<div class="p-6 max-w-lg mx-auto bg-white shadow rounded">
    <h2 class="text-2xl font-bold mb-4">Edit Course</h2>

    <form method="POST" class="grid gap-4">
        <input type="text" name="course_code" value="<?php echo htmlspecialchars($course['course_code']); ?>" required class="p-2 border rounded">
        <input type="text" name="course_name" value="<?php echo htmlspecialchars($course['course_name']); ?>" required class="p-2 border rounded">
        <input type="number" name="credits" value="<?php echo htmlspecialchars($course['credits']); ?>" min="1" required class="p-2 border rounded">
        
        <div class="flex justify-between">
            <a href="courses.php" class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</a>
            <button type="submit" name="update" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
        </div>
    </form>
</div>
</body>
</html>
