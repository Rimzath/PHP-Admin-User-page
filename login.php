<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "user";

session_start();

$data = mysqli_connect($host, $user, $password, $db);
if ($data === false) {
    die("Connection error");
}

$error = ""; // Initialize error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM login WHERE username='$username' AND password='$password'";
    $result = mysqli_query($data, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            if ($row["usertype"] == "user") {
                $_SESSION["username"] = $username;
                header("location: userhome.php");
                exit(); // Redirect and exit to prevent further output
            } elseif ($row["usertype"] == "admin") {
                $_SESSION["username"] = $username;
                header("location: adminhome.php");
                exit(); // Redirect and exit to prevent further output
            }
        }
    }

    // If no redirect occurred, display error message
    $error = "Username or password incorrect";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="#" method="POST">
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter your Name" required>
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your Password" required>
            </div>
            <button type="submit" class="btn">Login</button>
            <?php if ($error) : ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
