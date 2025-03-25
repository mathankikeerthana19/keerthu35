<?php
session_start();
include('db.php');

// Optional: Admin Login Check (Uncomment if using login)
// if (!isset($_SESSION['admin_logged_in'])) {
//     header('Location: admin_login.php');
//     exit;
// }

// Delete Class
if (isset($_GET['delete_class'])) {
    $class_id = (int)$_GET['delete_class'];
    if (mysqli_query($conn, "DELETE FROM dance_booking WHERE id = $class_id")) {
        header("Location: admin.php?page=manage_classes");
    }
    exit;
}

// Add Class
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_class'])) {
    $class_name = mysqli_real_escape_string($conn, $_POST['class_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);
    $fees = mysqli_real_escape_string($conn, $_POST['fees']);
    $timing = mysqli_real_escape_string($conn, $_POST['timing']);
    $query = "INSERT INTO dance_booking (class_name, description, duration, fees, timing) 
              VALUES ('$class_name', '$description', '$duration', '$fees', '$timing')";
    if (mysqli_query($conn, $query)) {
        header("Location: admin.php?page=manage_classes");
    }
    exit;
}

// Delete Feedback
if (isset($_GET['delete_feedback'])) {
    $feedback_id = (int)$_GET['delete_feedback'];
    if (mysqli_query($conn, "DELETE FROM feedback WHERE id = $feedback_id")) {
        header("Location: admin.php?page=user_feedback");
    }
    exit;
}

// Approve Certificate
if (isset($_GET['approve_certificate'])) {
    $booking_id = (int)$_GET['approve_certificate'];
    if (mysqli_query($conn, "UPDATE bookings SET certificate_status='Approved' WHERE id=$booking_id")) {
        header("Location: admin.php?page=user_booking");
    }
    exit;
}

// Dashboard Stats
function getCount($conn, $table, $where = "") {
    $sql = "SELECT COUNT(*) as total FROM $table $where";
    $result = mysqli_query($conn, $sql);
    return $result ? mysqli_fetch_assoc($result)['total'] : 0;
}

$booking_count = getCount($conn, 'bookings');
$feedback_count = getCount($conn, 'feedback');
$class_count = getCount($conn, 'dance_booking');
$approved_count = getCount($conn, 'bookings', "WHERE certificate_status='Approved'");

// Fetch Data
$result_bookings = mysqli_query($conn, "SELECT * FROM bookings ORDER BY id DESC");
$result_feedbacks = mysqli_query($conn, "SELECT * FROM feedback ORDER BY created_at DESC");
$result_classes = mysqli_query($conn, "SELECT * FROM dance_booking");
$class_report = mysqli_query($conn, "SELECT * FROM dance_booking");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <style>
        body { display: flex; font-family: Arial, sans-serif; margin: 0; }
        .sidebar { width: 220px; background: rgb(167, 77, 216); color: white; padding: 20px; height: 100vh; position: fixed; }
        .sidebar a { color: white; display: block; padding: 10px; text-decoration: none; }
        .sidebar a:hover { background: rgb(145, 60, 190); }
        .main-content { margin-left: 240px; padding: 20px; width: calc(100% - 240px); }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table, th, td { border: 1px solid #333; padding: 10px; text-align: left; }
        .form-container { background: #f9f9f9; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .dashboard-container { display: flex; gap: 20px; margin-bottom: 20px; }
        .dashboard-box { background: #f4f4f4; padding: 30px; border-radius: 8px; text-align: center; width: 250px; }
        .btn { padding: 8px 15px; background: #5cb85c; color: #fff; border: none; border-radius: 5px; text-decoration: none; cursor: pointer; }
        .btn-danger { background-color: #d9534f; }
        .btn-approve { background-color: #5cb85c; }
        .btn-approved { background-color: #007bff; color: #fff; }
        .btn:hover { opacity: 0.85; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="admin.php?page=dashboard">Dashboard</a>
    <a href="admin.php?page=user_booking">User Bookings</a>
    <a href="admin.php?page=user_feedback">User Feedback</a>
    <a href="admin.php?page=manage_classes">Class Management</a>
    <a href="admin.php?page=class_report">Class Report</a>
</div>

<div class="main-content">
<?php
$page = $_GET['page'] ?? 'dashboard';

if ($page == "dashboard") { ?>
    <h2>Dashboard</h2>
    <div class="dashboard-container">
        <div class="dashboard-box"><h3>Total Bookings</h3><p><?= $booking_count; ?></p></div>
        <div class="dashboard-box"><h3>Total Feedback</h3><p><?= $feedback_count; ?></p></div>
        <div class="dashboard-box"><h3>Total Classes</h3><p><?= $class_count; ?></p></div>
        <div class="dashboard-box"><h3>Total Approved</h3><p><?= $approved_count; ?></p></div>
    </div>

<?php } elseif ($page == "user_booking") { ?>
    <h2>User Bookings</h2>
    <?php if ($result_bookings && mysqli_num_rows($result_bookings) > 0): ?>
        <table>
            <tr><th>Name</th><th>Email</th><th>Phone</th><th>Age</th><th>Class</th><th>Experience</th><th>Fees</th><th>Timing</th><th>Certificate</th><th>Action</th></tr>
            <?php while ($row = mysqli_fetch_assoc($result_bookings)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td><?= htmlspecialchars($row['phone']); ?></td>
                    <td><?= htmlspecialchars($row['age']); ?></td>
                    <td><?= htmlspecialchars($row['dance_class']); ?></td>
                    <td><?= htmlspecialchars($row['experience']); ?></td>
                    <td><?= htmlspecialchars($row['fees']); ?></td>
                    <td><?= htmlspecialchars($row['timing']); ?></td>
                    <td><?= htmlspecialchars($row['certificate_status']); ?></td>
                    <td>
                        <?php if (strtolower($row['certificate_status']) != 'approved'): ?>
                            <a class="btn btn-approve" href="?page=user_booking&approve_certificate=<?= $row['id']; ?>" onclick="return confirm('Approve Certificate?');">Approve</a>
                        <?php else: ?>
                            <span class="btn btn-approved">Approved</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: echo "<p>No bookings found.</p>"; endif; ?>

<?php } elseif ($page == "user_feedback") { ?>
    <h2>User Feedback</h2>
    <?php if ($result_feedbacks && mysqli_num_rows($result_feedbacks) > 0): ?>
        <table>
            <tr><th>Name</th><th>Email</th><th>Rating</th><th>Feedback</th><th>Date</th><th>Action</th></tr>
            <?php while ($row = mysqli_fetch_assoc($result_feedbacks)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['student_name']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td><?= str_repeat("⭐", $row['rating']); ?></td>
                    <td><?= nl2br(htmlspecialchars($row['feedback'])); ?></td>
                    <td><?= $row['created_at']; ?></td>
                    <td><a class="btn btn-danger" href="?page=user_feedback&delete_feedback=<?= $row['id']; ?>" onclick="return confirm('Delete this feedback?');">Delete</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: echo "<p>No feedback found.</p>"; endif; ?>

<?php } elseif ($page == "manage_classes") { ?>
    <div class="form-container">
        <h2>Add a New Class</h2>
        <form method="POST">
            <label>Class Name:</label><input type="text" name="class_name" required><br><br>
            <label>Description:</label><textarea name="description" required></textarea><br><br>
            <label>Duration (minutes):</label><input type="number" name="duration" required><br><br>
            <label>Fees:</label><input type="number" name="fees" required><br><br>
            <label>Timing:</label><input type="text" name="timing" required><br><br>
            <button type="submit" name="add_class" class="btn">Add Class</button>
        </form>
    </div>

    <h2>Manage Classes</h2>
    <?php if ($result_classes && mysqli_num_rows($result_classes) > 0): ?>
        <table>
            <tr><th>Class Name</th><th>Description</th><th>Duration</th><th>Fees</th><th>Timing</th><th>Action</th></tr>
            <?php while ($row = mysqli_fetch_assoc($result_classes)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['class_name']); ?></td>
                    <td><?= htmlspecialchars($row['description']); ?></td>
                    <td><?= htmlspecialchars($row['duration']); ?> min</td>
                    <td><?= htmlspecialchars($row['fees']); ?></td>
                    <td><?= htmlspecialchars($row['timing']); ?></td>
                    <td><a class="btn btn-danger" href="?page=manage_classes&delete_class=<?= $row['id']; ?>" onclick="return confirm('Delete this class?');">Delete</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: echo "<p>No classes found.</p>"; endif; ?>

<?php } elseif ($page == "class_report") { ?>
    <h2>Class Wise Student Report</h2>
    <?php if ($class_report && mysqli_num_rows($class_report) > 0):
        while ($class = mysqli_fetch_assoc($class_report)):
            $class_name = $class['class_name'];
            $students = mysqli_query($conn, "SELECT * FROM bookings WHERE dance_class='" . mysqli_real_escape_string($conn, $class_name) . "'");
    ?>
        <h3><?= htmlspecialchars($class_name); ?></h3>
        <?php if ($students && mysqli_num_rows($students) > 0): ?>
            <table>
                <tr><th>Name</th><th>Email</th><th>Phone</th><th>Age</th><th>Experience</th><th>Fees</th><th>Timing</th><th>Certificate</th></tr>
                <?php while ($student = mysqli_fetch_assoc($students)): ?>
                    <tr>
                        <td><?= htmlspecialchars($student['name']); ?></td>
                        <td><?= htmlspecialchars($student['email']); ?></td>
                        <td><?= htmlspecialchars($student['phone']); ?></td>
                        <td><?= htmlspecialchars($student['age']); ?></td>
                        <td><?= htmlspecialchars($student['experience']); ?></td>
                        <td><?= htmlspecialchars($student['fees']); ?></td>
                        <td><?= htmlspecialchars($student['timing']); ?></td>
                        <td><?= htmlspecialchars($student['certificate_status']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: echo "<p>No students found for this class.</p>"; endif; ?>
    <?php endwhile;
    else: echo "<p>No classes found.</p>"; endif; 
} ?>
</div>

</body>
</html>

<?php mysqli_close($conn); ?>
 