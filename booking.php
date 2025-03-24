<?php
session_start();
include('db.php');

$success_message = "";
$error_message = "";

// Fetch dance classes for the dropdown
$query = "SELECT class_name, fees, timing FROM dance_booking";
$result = mysqli_query($conn, $query);
$dance_classes = [];
while ($row = mysqli_fetch_assoc($result)) {
    $dance_classes[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if required fields are set
    if (
        isset($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['age'], $_POST['dance_class'], $_POST['experience'])
    ) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $age = (int) $_POST['age'];
        $dance_class = mysqli_real_escape_string($conn, $_POST['dance_class']);
        $experience = mysqli_real_escape_string($conn, $_POST['experience']);

        // Fetch fees and timing based on selected class
        $class_query = "SELECT fees, timing FROM dance_booking WHERE class_name = '$dance_class'";
        $class_result = mysqli_query($conn, $class_query);

        if ($class_result && mysqli_num_rows($class_result) > 0) {
            $row = mysqli_fetch_assoc($class_result);
            $fees = $row['fees'];
            $timing = $row['timing'];

            // Insert booking
            $insert_query = "INSERT INTO bookings (name, email, phone, age, dance_class, experience, fees, timing)
                             VALUES ('$name', '$email', '$phone', $age, '$dance_class', '$experience', $fees, '$timing')";

            if (mysqli_query($conn, $insert_query)) {
                $_SESSION['booking_id'] = mysqli_insert_id($conn);
                header("Location: payment.php");
                exit();
            } else {
                $error_message = "Error: " . mysqli_error($conn);
            }
        } else {
            $error_message = "Invalid dance class selection.";
        }
    } else {
        $error_message = "Please fill all required fields.";
    }
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Dance Class Registration</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('dance.jpeg');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            font-size: 14px;
            color: #555;
        }
        input, select, button, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #28a745;
            color: white;
            cursor: pointer;
            border: none;
        }
        button:hover {
            background-color: #218838;
        }
        .message {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Register for Dance Class</h2>
    <form method="POST" action="booking.php">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" required placeholder="Enter your full name">

        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" required placeholder="Enter your email address">

        <label for="phone">Phone Number</label>
        <input type="text" id="phone" name="phone" required placeholder="Enter your phone number">

        <label for="age">Age</label>
        <input type="number" id="age" name="age" required placeholder="Enter your age">

        <label for="dance_class">Preferred Dance Class</label>
        <select id="dance_class" name="dance_class" required>
            <option value="" disabled selected>Select your preferred class</option>
            <?php foreach ($dance_classes as $class): ?>
                <option value="<?php echo $class['class_name']; ?>" 
                        data-fees="<?php echo $class['fees']; ?>" 
                        data-timing="<?php echo $class['timing']; ?>">
                    <?php echo $class['class_name']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="experience">Dance Experience</label>
        <textarea id="experience" name="experience" rows="4" placeholder="Describe your dance experience (if any)"></textarea>

        <label for="fees">Class Fees</label>
        <input type="text" id="fees" name="fees" readonly>

        <label for="timing">Class Timing</label>
        <input type="text" id="timing" name="timing" readonly>

        <button type="submit">Register & Pay</button>
    </form>

    <?php if ($success_message): ?>
        <div class="message" style="color: green;">
            <p><?php echo $success_message; ?></p>
        </div>
    <?php elseif ($error_message): ?>
        <div class="message" style="color: red;">
            <p><?php echo $error_message; ?></p>
        </div>
    <?php endif; ?>
</div>

<script>
$(document).ready(function() {
    $('#dance_class').change(function() {
        var selectedOption = $(this).find(':selected');
        var fees = selectedOption.data('fees');
        var timing = selectedOption.data('timing');
        $('#fees').val(fees);
        $('#timing').val(timing);
    });
});
</script>

</body>
</html>
