
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Secure password hash

    $conn = new mysqli('localhost', 'root', '', 'travellers');

    // Admin registration: specify 'admin' role here
    $role = 'admin';
    
    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Admin user registered successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();
}
?>

<form method="POST" action="admin_registration.php">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="submit" value="Register Admin">
</form>
