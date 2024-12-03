<?php  
session_start();  
if (!isset($_SESSION['user_id'])) {  
    header("Location: index.html"); // Redirect to login page if not logged in  
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

// Handle blog creation  
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_blog'])) {  
    $title = $_POST['title'];  
    $content = $_POST['content'];  
    $user_id = $_SESSION['user_id'];  

    $sql = "INSERT INTO blogs (user_id, title, content) VALUES ('$user_id', '$title', '$content')";  
    $conn->query($sql);  
}  

// Fetch user's blogs  
$sql = "SELECT * FROM blogs WHERE user_id=" . $_SESSION['user_id'];  
$blogs = $conn->query($sql);  
?>  

<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <link rel="stylesheet" href="styles.css">  
    <title>Dashboard</title>  
</head>  
<body>  
    <header>  
        <h1>Your Dashboard</h1>  
        <a href="logout.php">Logout</a>  
    </header>  
    <main>  
        <h2>Create a New Blog</h2>  
        <form method="POST">  
            <input type="text" name="title" placeholder="Blog Title" required>  
            <textarea name="content" placeholder="Blog Content" required></textarea>  
            <button type="submit" name="create_blog">Create Blog</button>  
        </form>  

        <h2>Your Blogs</h2>  
        <ul>  
            <?php  
            if ($blogs->num_rows > 0) {  
                while ($row = $blogs->fetch_assoc()) {  
                    echo "<li><strong>" . $row['title'] . "</strong><br>" . $row['content'] . "<br><small>Posted on " . $row['created_at'] . "</small></li>";  
                    
                    // Fetch comments for the blog  
                    $blog_id = $row['id'];  
                    $comment_sql = "SELECT * FROM comments WHERE blog_id='$blog_id' AND parent_id IS NULL";  
                    $comments = $conn->query($comment_sql);  
                    
                    // Comment form  
                    echo "<form method='POST' action='comment.php'>";  
                    echo "<input type='hidden' name='blog_id' value='$blog_id'>";  
                    echo "<textarea name='comment' placeholder='Add a comment...' required></textarea>";  
                    echo "<button type='submit'>Comment</button>";  
                    echo "</form>";  
                    
                    // Display comments  
                    if ($comments->num_rows > 0) {  
                        echo "<ul>";  
                        while ($comment = $comments->fetch_assoc()) {  
                            echo "<li>" . $comment['content'] . "<br><small>Commented on " . $comment['created_at'] . "</small>";  
                            // Display replies  
                            $parent_comment_id = $comment['id'];  
                            $reply_sql = "SELECT * FROM comments WHERE parent_id='$parent_comment_id'";  
                            $replies = $conn->query($reply_sql);  
                            
                            // Reply form  
                            echo "<form method='POST' action='reply.php'>";  
                            echo "<input type='hidden' name='comment_id' value='$parent_comment_id'>";  
                            echo "<textarea name='reply' placeholder='Add a reply...' required></textarea>";  
                            echo "<button type='submit'>Reply</button>";  
                            echo "</form>";  
                            
                            // Display replies  
                            if ($replies->num_rows > 0) {  
                                echo "<ul>";  
                                while ($reply = $replies->fetch_assoc()) {  
                                    echo "<li>" . $reply['content'] . "<br><small>Replied on " . $reply['created_at'] . "</small></li>";  
                                }  
                                echo "</ul>";  
                            }  
                            echo "</li>";  
                        }  
                        echo "</ul>";  
                    }  
                }  
            } else {  
                echo "<li>No blogs posted yet.</li>";  
            }  
            ?>  
        </ul>  
    </main>  
</body>  
</html>  

<?php  
$conn->close();  
?>