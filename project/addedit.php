<?php include 'header.php'; ?>
<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    $conn = new mysqli('localhost', 'root', '', 'travellers_diary');
    $sql = "INSERT INTO posts (title, content, user_id) VALUES ('$title', '$content', '$user_id')";
    if ($conn->query($sql) === TRUE) {
        echo "Post added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();
}
?>

<form method="POST" action="add_post.php">
    <input type="text" name="title" placeholder="Title" required><br>
    <textarea name="content" placeholder="Content" required></textarea><br>
    <input type="submit" value="Add Post">
</form>

<?php include 'footer.php'; ?>