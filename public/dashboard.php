<?php
session_start();
require_once '../config/database.php';
require_once '../models/User.php';
require_once '../models/Appointment.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

$database = new Database();
$db = $database->getDb();
$userModel = new User($db);
$appointmentModel = new Appointment($db);

$totalUsers = $userModel->getTotalUsers();

$totalAppointments = $appointmentModel->getTotalAppointments();

$todaysAppointments = $appointmentModel->getAppointmentsByDate(date('Y-m-d'));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Admin Dashboard</h1>
    
    <div class="dashboard-statistics">
        <div class="stat">
            <h2>Total Users</h2>
            <p><?php echo $totalUsers; ?></p>
        </div>
        <div class="stat">
            <h2>Total Appointments</h2>
            <p><?php echo $totalAppointments; ?></p>
        </div>
        <div class="stat">
            <h2>Today's Appointments</h2>
            <p><?php echo count($todaysAppointments); ?></p>
        </div>
    </div>

    <div class="appointments">
        <h2>Today's Appointments</h2>
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($todaysAppointments as $appointment): ?>
                    <tr>
                        <td><?php echo $appointment['userId']; ?></td>
                        <td><?php echo $appointment['date']->toDateTime()->format('Y-m-d H:i:s'); ?></td>
                        <td><?php echo $appointment['status']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
