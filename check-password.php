<?php

$hash = '$2y$10$HNfhClczEWBxcFuJwP53iu2Y75Tba7IEtmX8vX.1tp0dZ5EVt9CbO';

if (password_verify('123', $hash)) {
    echo "Password 123 is correct!";
} else {
    echo "Password 123 does NOT match the hash.";
}

?>