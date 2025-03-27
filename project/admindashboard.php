<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header('Location: index.php');
    exit;
}
?>

<h1>Admin Dashboard</h1>
<a href="add_post.php">Add Post</a>
<?php
$conn = new mysqli('localhost', 'root', '', 'travellers_diary');
$sql = "SELECT * FROM posts";
$result = $conn->query($sql);
while ($post = $result->fetch_assoc()) {
    echo "<div>
        <h3>{$post['title']}</h3>
        <p>{$post['content']}</p>
        <a href='edit_post.php?id={$post['id']}'>Edit</a>
        <a href='delete_post.php?id={$post['id']}'>Delete</a>
    </div>";
}
$conn->close();
?>
