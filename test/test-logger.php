<?php

require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../includes/activity-logger.php');

$user_id = null;
$user_email = "test@example.com";

$success = logActivity(
    $pdo,
    $user_id,
    $user_email,
    'test_activity',
    'success'
);

if ($success) {
    echo "Activity log inserted successfully";
} else {
    echo "Failed to insert Activity log";
}

?>