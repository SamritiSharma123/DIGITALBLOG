<?php  
session_start();  
if (!isset($_SESSION['user_id'])) {  
    header("Location: index.html");  
    exit();  
}  

$servername = "localhost";  
$username = "root"; // default XAMPP username  
$password = ""; // default XAMPP password  
$dbname = "blog_app";  

$conn = new mysqli($servername, $username, $password, $dbname);  

if ($conn->connect_error) {  
    die("Connection failed: " . $conn->connect_error);  
}  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
    $reply_content = $_POST['reply'];  
    $comment_id = $_POST['comment_id'];  
    $user_id = $_SESSION['user_id'];  

    $sql = "INSERT INTO comments (blog_id, user_id, content, parent_id) VALUES (NULL, '$user_id', '$reply_content', '$comment_id')";  
    $conn->query($sql);  
}  

header("Location: dashboard.php");  
$conn->close();  
?>