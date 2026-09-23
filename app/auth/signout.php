<?php

require_once(__DIR__ . '/../../config/config.php');
require_once(__DIR__ . '/../../config/functions.php');

logActivity(
    $pdo,
    $_SESSION['user_id'],
    $_SESSION['user_email'],
    'signout',
    'success'
);

$_SESSION = [];

session_destroy();

header('Location: ' . BASE_URL . '/index.php');
exit;
?>