<?php
session_start();

// Check if the user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./unauthorized.php");
    exit();
}

// Database configuration
include ("../db.php");

// Fetch all reservations
$reservations_sql = "SELECT * FROM reservations";
$reservations_result = mysqli_query($conn, $reservations_sql);

if (!$reservations_result) {
    die("Error fetching reservations: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Styles/header.css" />
    <link rel="stylesheet" href="../Styles/admin.css">
    <link rel="stylesheet" href="../Styles/footer.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <!-- header section -->
    <?php include ("../Components/header.php"); ?>

    <!-- admin-dashboard -->
    <div class="admin-main-content">
        <div class="admin-container">
            
        <?php include ("../Components/admin_header.php"); ?>

            <!-- Reservation- section -->
            <section id="view-reservations">
                <h2>View Reservations</h2>
                <table class="admin-table">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>People</th>
                        <th>Requests</th>
                    </tr>
                    <?php while ($reservation = $reservations_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $reservation['name']; ?></td>
                            <td><?php echo $reservation['email']; ?></td>
                            <td><?php echo $reservation['phone']; ?></td>
                            <td><?php echo $reservation['date']; ?></td>
                            <td><?php echo $reservation['time']; ?></td>
                            <td><?php echo $reservation['people']; ?></td>
                            <td><?php echo $reservation['requests']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </section>
        </div>
    </div>

</body>

</html>