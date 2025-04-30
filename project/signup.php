<?php include 'includes/header.php'; ?>
<?php
session_start();

// Check if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = 'Invalid CSRF token!';
    } else {
        $username = $_POST['username'];
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'];

        // Server-side validation
        if (strlen($username) < 3 || preg_match('/\s/', $username)) {
            $error = 'Username must be at least 3 characters and should not contain spaces.';
        } elseif (!$email) {
            $error = 'Please enter a valid email address.';
        } elseif (!preg_match('/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,}$/', $password)) {
            $error = 'Password must be at least 6 characters long and contain at least one number and one special character.';
        } else {
            // Hash the password
            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            // Database connection
            $conn = new mysqli('localhost', 'root', '', 'travellers');
            if ($conn->connect_error) {
                $error = 'Database connection failed!';
            } else {
                // Check if email already exists
                $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $error = 'Email is already registered!';
                    $stmt->close();
                } else {
                    $stmt->close();

                    // Insert new user
                    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $username, $email, $password_hash);
                    if ($stmt->execute()) {
                        $success = 'New user registered successfully! <a href="login.php">Log in here</a>.';
                    } else {
                        $error = 'Error: ' . $stmt->error;
                    }
                    $stmt->close();
                }
                $conn->close();
            }
        }
    }
}
?>

<style>
    .content {
        max-width: 400px;
        margin: 40px auto;
        padding: 20px;
        background-color: #FFFFFF; /* White background */
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
        min-height: 200px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    form {
        display: flex;
        flex-direction: column;
    }

    input[type="text"], input[type="email"], input[type="password"] {
        padding: 10px;
        margin: 10px 0;
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
        border-color: #228B22; /* Accent color: Green */
        outline: none;
        box-shadow: 0 0 5px rgba(34, 139, 34, 0.3);
    }

    input[type="submit"] {
        padding: 10px;
        background-color: #DC143C; /* Primary color: Red */
        color: #FFFFFF; /* White text */
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    input[type="submit"]:hover {
        background-color: #B22222; /* Darker red on hover */
    }

    .error {
        color: #DC143C; /* Primary color: Red */
        margin-bottom: 15px;
        font-size: 14px;
        text-align: center;
    }

    .success {
        color: #228B22; /* Accent color: Green */
        margin-bottom: 15px;
        font-size: 14px;
        text-align: center;
    }

    .success a {
        color: #DC143C; /* Primary color: Red for links */
        text-decoration: none;
    }

    .success a:hover {
        text-decoration: underline;
    }

    @media (max-height: 600px) {
        body {
            padding-top: 60px;
            padding-bottom: 60px;
        }
        .content {
            margin: 20px auto;
            padding: 15px;
        }
    }
</style>

<div class="content">
    <?php if ($error): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <form id="signupForm" method="POST" action="register.php">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <input type="text" id="username" name="username" placeholder="Username" required>
        <input type="email" id="email" name="email" placeholder="Email" required>
        <input type="password" id="password" name="password" placeholder="Password" required>
        <input type="submit" value="Sign Up">
        <p id="error-message" class="error"></p>
    </form>
</div>

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

<?php include 'includes/footer.php'; ?>