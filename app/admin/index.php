<?php
require '../../config/config.php';

requireRole('admin');

$section = $_GET['section'] ?? '';

$action = $_GET['action'] ?? '';

if ($section === 'activity-logs'){
        // Activity Logs Query
        $stmt = $pdo->query("
        SELECT * 
        FROM activity_logs
        ORDER BY activity_log_created_at DESC
    ");

    $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

} elseif ($section === 'user-sessions') {

    // User Sessions Query
    $stmt = $pdo->query("
        SELECT
            us.session_id,
            us.user_id,
            u.user_username,
            u.user_email,
            u.user_role,
            us.session_start,
            us.session_end,
            us.session_duration
        FROM user_sessions us
        INNER JOIN users u
            ON us.user_id = u.user_id
        ORDER BY us.session_start DESC
    ");

    $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if($action=== 'export'){
    if($section=== 'activity-logs'){

    $stmt = $pdo->query("
        SELECT *
        FROM activity_logs
        ORDER BY activity_log_created_at DESC  
    ");

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    logActivity(
        $pdo,
        $_SESSION['user_id'],
        $_SESSION['user_email'],
        'export_activity_logs',
        'success'
    );

    exportCsv(
        'activity_logs',
        [
            'Record ID','User ID','User Email','Action',
            'Status','IP Address','User Agent','Date & Time',
        ],
        $rows
    );
 }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/3.0.4/css/dataTables.bootstap5.min.css"/>
    
<style>
body {
    background-color: #f4f1e8;
    font-family: Arial, sans-serif;
    color: #2d3b30;
    margin: 0;
    padding: 25px;
}

/* Main heading */
h1 {
    color: #244b32;
    font-weight: 700;
    font-size: 30px;
    margin-bottom: 20px;
}

h4 {
    color: #244b32;
    font-size: 22px;
    font-weight: 700;
    margin: 25px 0 18px;
}

/* Main container */
.container {
    background-color: #ffffff;
    padding: 30px;
    margin: 30px auto;
    max-width: 1400px;
    border-radius: 14px;
    border: 1px solid #e5e5da;
    box-shadow: 0 6px 20px rgba(36, 75, 50, 0.07);
}

/* Navigation buttons */
nav {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin: 20px 0 25px;
}

.btn-primary,
.btn-pink {
    background-color: #2f6844;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 10px 20px;
    text-decoration: none;
    font-weight: 600;
    transition: 0.2s;
}

.btn-primary:hover,
.btn-pink:hover {
    background-color: #1e4b30;
    color: white;
}

/* Sign out button */
.btn-danger {
    border-radius: 8px;
    padding: 9px 18px;
}

/* Horizontal line */
hr {
    border: 0;
    border-top: 1px solid #dedfd4;
    margin: 25px 0;
}

/* Tables */
table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
    margin-top: 15px;
    border-radius: 10px;
    overflow: hidden;
}

thead th {
    background-color: #2f6844;
    color: white;
    padding: 15px 12px;
    text-align: left;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    white-space: nowrap;
}

tbody td {
    padding: 14px 12px;
    border-bottom: 1px solid #e9ece5;
    color: #465349;
    font-size: 13px;
}

tbody tr:nth-child(even) {
    background-color: #f8f9f5;
}

tbody tr:hover {
    background-color: #eaf2e8;
}

/* Responsive tables */
body {
    overflow-x: auto;
}

@media (max-width: 768px) {
    body {
        padding: 15px;
    }

    h1 {
        font-size: 25px;
    }

    .container {
        padding: 18px;
    }

    table {
        min-width: 850px;
    }
}
</style>

</head>
<body>
        <h1>Welcome, Admin!</h1>

        <a href="../auth/signout.php" class="btn btn-danger">
            Sign Out
        </a>
        <hr>

    <nav>
        <a href="index.php?section=activity-logs" class="btn btn-primary">Activity Logs </a>
        <a href="index.php?section=user-sessions" class="btn btn-primary">User Sessions </a>
    </nav>

    <?php if ($section === 'activity-logs'): ?>

        <h4>Activity Logs
            <a href="index.php?section=activity-logs&amp;action=export">Export CSV</a>
        </h4>

        <table>

            <thead>
                <tr>
                    <th>Record ID</th>
                    <th>User ID</th>
                    <th>User Email</th>
                    <th>Action</th>
                    <th>Status</th>
                    <th>IP Address</th>
                    <th>User Agent</th>
                    <th>Date & Time</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($activities as $activity): ?>

                    <tr>
                        <td>
                            <?= htmlspecialchars($activity['activity_log_id']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($activity['user_id']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($activity['user_email']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($activity['activity_log_action']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($activity['action_log_status']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($activity['activity_log_ip_address']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($activity['activity_log_user_agent']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($activity['activity_log_created_at']) ?>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    <?php endif; ?>

    <?php if ($section === 'user-sessions'): ?>

        <h4>User Sessions</h4>

        <table>

            <thead>
                <tr>
                    <th>Session ID</th>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Session Start</th>
                    <th>Session End</th>
                    <th>Duration</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($sessions as $session): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars($session['session_id']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($session['user_id']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($session['user_username']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($session['user_email']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($session['user_role']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($session['session_start']) ?>
                        </td>

                        <td>
                            <?= $session['session_end']
                                ? htmlspecialchars($session['session_end'])
                                : 'Active'
                            ?>
                        </td>

                        <td>

                            <?php

                            if ($session['session_duration'] !== null) {

                                $seconds = (int) $session['session_duration'];

                                $hours = floor($seconds / 3600);
                                $minutes = floor(($seconds % 3600) / 60);
                                $seconds = $seconds % 60;

                                echo sprintf(
                                    '%02d hr %02d min %02d sec',
                                    $hours,
                                    $minutes,
                                    $seconds
                                );

                            } else {

                                echo 'Active';

                            }

                            ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    <?php endif; ?>
</body>
</html>