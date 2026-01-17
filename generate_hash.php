<?php
// File untuk menghasilkan hash bcrypt untuk password '12345678'

$password = '12345678';
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

echo "Password: $password\n";
echo "Hash: $hashedPassword\n";
?>