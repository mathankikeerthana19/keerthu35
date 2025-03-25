
<?php
include('db.php');

$booking_id = isset($_POST['booking_id']) ? (int)$_POST['booking_id'] : 0;

if ($booking_id > 0) {
    $query = "SELECT * FROM bookings WHERE id = $booking_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $booking = mysqli_fetch_assoc($result);
    } else {
        echo "<h3>No booking found.</h3>";
        exit;
    }
} else {
    echo "<h3>Invalid booking ID.</h3>";
    exit;
}

$transaction_id = "TXN" . rand(100000, 999999);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Success</title>
    <style>
        :root {
            --primary: #4a6fa5;
            --success: #4BB543;
            --dark: #2c3e50;
            --light: #f8f9fa;
            --text: #333333;
            --highlight: #f0f7ff;
        }
        
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            color: var(--text);
            line-height: 1.6;
        }

        .success-card {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            width: 800px;
            max-width: 90%;
            position: relative;
            overflow: hidden;
        }

        .success-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(90deg, var(--primary), var(--success));
        }

        .success-message {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 20px;
        }

        .success-message::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 25%;
            width: 50%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #ddd, transparent);
        }

        .success-icon {
            font-size: 60px;
            color: var(--success);
            margin-bottom: 15px;
            display: inline-block;
            animation: bounce 1s;
        }

        .success-title {
            color: var(--success);
            font-size: 28px;
            font-weight: 600;
            margin: 10px 0;
        }

        .thank-you {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .details-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .details-section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 50px;
            height: 2px;
            background-color: var(--primary);
        }

        .detail-item {
            margin-bottom: 12px;
            display: flex;
        }

        .detail-label {
            font-weight: 600;
            min-width: 120px;
            color: var(--dark);
        }

        .detail-value {
            flex: 1;
        }

        .print-btn {
            background: linear-gradient(135deg, var(--primary), #6c8fc7);
            color: white;
            padding: 14px 40px;
            border-radius: 30px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            display: block;
            margin: 40px auto 0;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(74, 111, 165, 0.3);
        }

        .print-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 111, 165, 0.4);
        }

        .transaction-id {
            background-color: var(--highlight);
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin: 25px 0;
            font-weight: 600;
            font-size: 18px;
            color: var(--primary);
            border: 1px dashed #c1d8ff;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
            40% {transform: translateY(-20px);}
            60% {transform: translateY(-10px);}
        }

        @media print {
            .print-btn {
                display: none;
            }
            body {
                background: none;
            }
            .success-card {
                box-shadow: none;
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .details-container {
                grid-template-columns: 1fr;
            }
            .success-card {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="success-card">
        <div class="success-message">
            <div class="success-icon">✔</div>
            <h1 class="success-title">Payment Successful!</h1>
            <p class="thank-you">Thank you, <b><?php echo htmlspecialchars($booking['name']); ?></b>, for booking your dance class.</p>
        </div>

        <div class="transaction-id">
            Transaction ID: <?php echo $transaction_id; ?>
        </div>

        <div class="details-container">
            <div>
                <div class="details-section">
                    <h3 class="section-title">Class Information</h3>
                    <div class="detail-item">
                        <span class="detail-label">Class Name:</span>
                        <span class="detail-value"><?php echo htmlspecialchars($booking['dance_class']); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Timing:</span>
                        <span class="detail-value"><?php echo htmlspecialchars($booking['timing']); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Fees Paid:</span>
                        <span class="detail-value">₹<?php echo htmlspecialchars($booking['fees']); ?></span>
                    </div>
                </div>
            </div>

            <div>
                <div class="details-section">
                    <h3 class="section-title">Student Details</h3>
                    <div class="detail-item">
                        <span class="detail-label">Name:</span>
                        <span class="detail-value"><?php echo htmlspecialchars($booking['name']); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Contact:</span>
                        <span class="detail-value"><?php echo htmlspecialchars($booking['phone']); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Email:</span>
                        <span class="detail-value"><?php echo htmlspecialchars($booking['email']); ?></span>
                    </div>
                </div>

                <div class="details-section">
                    <h3 class="section-title">Payment Details</h3>
                    <div class="detail-item">
                        <span class="detail-label">Booking ID:</span>
                        <span class="detail-value"><?php echo $booking['id']; ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Payment Method:</span>
                        <span class="detail-value">UPI</span>
                    </div>
                </div>
            </div>
        </div>

        <button class="print-btn" onclick="window.print()">Print Receipt</button>
    </div>
</body>
</html>