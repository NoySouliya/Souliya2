<?php
$db = new mysqli("localhost", "root", "", "cs5b2");

// Check connection
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: " . $db->connect_error;
    exit();
}
