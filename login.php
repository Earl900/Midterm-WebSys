<?php
session_start();
$serverName = "DESKTOP-29HQ1F0\SQLEXPRESS";
$database = "MidtermProj";
$username = "";
$password = "";

$connection = [
    "Database" => $database,
    "Uid" => $username,
    "PWD" => $password
];

$conn = sqlsrv_connect($serverName, $connection);
if (!$conn) {
    die(print_r(sqlsrv_errors(), true));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];
    $hashedPassword = md5($inputPassword);

    $sql = "SELECT * FROM Login WHERE Username = ? AND Password = ?";
    $params = array($inputUsername, $hashedPassword);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $_SESSION['username'] = $inputUsername;
        $_SESSION['password'] = $inputPassword;
        header('Location: Home.html', response_code: 301);
    } else {
        echo "Invalid username or password.";
    }
}

sqlsrv_close($conn);
?>