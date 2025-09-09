<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="bg-gray-800 p-4 text-white flex justify-between">
    <a href="index.php" class="font-bold">Result Manager</a>
    <div>
        <a href="students.php" class="px-2">Students</a>
        <a href="courses.php" class="px-2">Courses</a>
        <a href="add_result.php" class="px-2">Add Result</a>
        <a href="transcript.php" class="px-2">Transcript</a>
        <a href="gpa_summary.php" class="px-2">GPA Summary</a>

        <?php if (isset($_SESSION['teacher_id'])): ?>
            <!-- Show when logged in -->
            <a href="profile.php" class="px-2">Profile</a>
            <!-- <a href="logout.php" class="px-2">Logout</a> -->
        <?php else: ?>
            <!-- Show when not logged in -->
            <a href="login.php" class="px-2">Login</a>
            <!-- <a href="register.php" class="px-2">Register</a> -->
        <?php endif; ?>
    </div>
</div>
