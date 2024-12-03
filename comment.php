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
    $comment_content = $_POST['comment'];  
    $blog_id = $_POST['blog_id'];  
    $user_id = $_SESSION['user_id'];  

    $sql = "INSERT INTO comments (blog_id, user_id, content) VALUES ('$blog_id', '$user_id', '$comment_content')";  
    $conn->query($sql);  
}  

header("Location: dashboard.php");  
$conn->close();  
?>