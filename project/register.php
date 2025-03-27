<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $conn = new mysqli('localhost', 'root', '', 'travellers');
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "New user registered successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();
}
?>

<form id="signupForm" method="POST" action="register.php">
    <input type="text" id="username" name="username" placeholder="Username" required><br>
    <input type="email" id="email" name="email" placeholder="Email" required><br>
    <input type="password" id="password" name="password" placeholder="Password" required><br>
    <input type="submit" value="Sign Up">
    <p id="error-message" style="color: red;"></p>
</form>

<script>
document.getElementById("signupForm").addEventListener("submit", function(event) {
    let username = document.getElementById("username").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();
    let errorMessage = document.getElementById("error-message");

    // Reset error message
    errorMessage.innerText = "";

    // Username validation (min 3 characters, no spaces)
    if (username.length < 3 || /\s/.test(username)) {
        errorMessage.innerText = "Username must be at least 3 characters and should not contain spaces.";
        event.preventDefault();
        return;
    }

    // Email validation (basic pattern check)
    let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(email)) {
        errorMessage.innerText = "Please enter a valid email address.";
        event.preventDefault();
        return;
    }

    // Password validation (min 6 characters, at least one number & one special character)
    let passwordPattern = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,}$/;
    if (!passwordPattern.test(password)) {
        errorMessage.innerText = "Password must be at least 6 characters long and contain at least one number and one special character.";
        event.preventDefault();
        return;
    }
});
</script>
