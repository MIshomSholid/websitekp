<?php
$password = 'ishom2602'; // Choose your desired password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
echo "Hashed Password: $hashedPassword\n";
?>