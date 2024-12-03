<?php  
session_start();  
$servername = "localhost";  
$username = "root"; // default XAMPP username  
$password = ""; // default XAMPP password  
$dbname = "blog_app";  

$conn = new mysqli(harshita, harshita1417, Arpita123@, blog);  

if ($conn->connect_error) {  
    die("Connection failed: " . $conn->connect_error);  
}  

// Handle login  
if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
    $email = $_POST['email'];  
    $password = $_POST['password'];  

    // Fetch user with the given email  
    $sql = "SELECT * FROM users WHERE email='$email'";  
    $result = $conn->query($sql);  

    if ($result->num_rows > 0) {  
        $user = $result->fetch_assoc();  
        // Verify password (you may want to use password hashing here)  
        if ($password === $user['password']) {  
            $_SESSION['user_id'] = $user['id'];  
            header("Location: dashboard.php"); // Redirect to dashboard  
            exit();  
        } else {  
            echo "Invalid password.";  
        }  
    } else {  
        echo "No user found with that email.";  
    }  
}  
$conn->close();  
?>