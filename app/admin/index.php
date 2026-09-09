<?php

require_once(__DIR__ . '/../../config/config.php');
require_once(__DIR__ . '/../../config/functions.php');

requireRole('admin');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>

    <h1>Welcome Admin</h1>

    <a href="<?= BASE_URL ?>/app/auth/signout.php">Sign Out</a>

</body>
</html>