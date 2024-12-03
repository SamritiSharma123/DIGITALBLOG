<?php  
session_start();  
$servername = "localhost";  
$username = "root"; // Usually 'root' for XAMPP  
$password = ""; // Usually no password for XAMPP  
$dbname = "blog"; // Ensure this name matches the database you created

$conn = new mysqli($servername, $username, $password, $dbname);  

if ($conn->connect_error) {  
    die("Connection failed: " . $conn->connect_error);  
}  

// Handle signup  
if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
    $email = $_POST['email'];  
    $password = $_POST['password'];  

    // Insert new user  
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";  
    if ($conn->query($sql) === TRUE) {  
        // Get the new user's ID  
        $user_id = $conn->insert_id;   
        $_SESSION['user_id'] = $user_id; // Set session variable  
        header("Location: dashboard.php"); // Redirect to dashboard  
        exit();  
    } else {  
        echo "Error: " . $conn->error;  
    }  
}  
$conn->close();  
?>