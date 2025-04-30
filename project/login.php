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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = 'Invalid CSRF token!';
    } else {
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'];

        if (!$email) {
            $error = 'Invalid email format!';
        } elseif (empty($password)) {
            $error = 'Password is required!';
        } else {
            $conn = new mysqli('localhost', 'root', '', 'travellers');
            if ($conn->connect_error) {
                $error = 'Database connection failed!';
            } else {
                $stmt = $conn->prepare("SELECT id, role, password FROM users WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    if (password_verify($password, $user['password'])) {
                        session_regenerate_id(true);
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['role'] = $user['role'];
                        header('Location: index.php');
                        exit;
                    } else {
                        $error = 'Invalid email or password!';
                    }
                } else {
                    $error = 'Invalid email or password!';
                }
                $stmt->close();
                $conn->close();
            }
        }
    }
}
?>

<style>
    .content {
        max-width: 400px;
        margin: 0 auto; /* Center horizontally */
        padding: 20px;
        background-color: #FFFFFF; /* White background for the form */
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
        min-height: 200px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: absolute;
        top: 50%; /* Center vertically */
        left: 50%; /* Center horizontally */
        transform: translate(-50%, -50%); /* Adjust for centering */
    }

    form {
        display: flex;
        flex-direction: column;
    }

    input[type="email"], input[type="password"] {
        padding: 10px;
        margin: 10px 0;
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    input[type="email"]:focus, input[type="password"]:focus {
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
        color: #DC143C; /* Primary color: Red for errors */
        margin-bottom: 15px;
        font-size: 14px;
        text-align: center;
    }
</style>

<div class="content">
    <?php if ($error): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>
</div>

<?php include 'includes/footer.php'; ?>