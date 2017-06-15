<?  

    // require common code
    require_once("includes/common.php"); 

    // check if logged in
    if (!preg_match("{/(:?login|logout|register)\d*\.php$}", $_SERVER["PHP_SELF"]) && !isset($_SESSION["id"])) 
        redirect("index.php?amiawinner=no");
    
    $id = $_SESSION["id"];

    // check if id is valid 
    $sql = "SELECT * FROM users WHERE id=$id";
    $result = mysql_query($sql);
    
    if (mysql_num_rows($result) != 1)
        redirect("index.php?amiawinner=no");

    $postid = mysql_real_escape_string($_POST["postid"]);
    $text = mysql_real_escape_string($_POST["submissionBox"]);
    
    // check size of comment
    $length = strlen($text);
    if ($length == 0 || $length > 1000)
        apologize("Post must be between 1 and 1000 characters.");
    
    // Add comment to 'comments' in the database
    $sql = "INSERT INTO comments (id, postid, text, upvotes, downvotes) VALUES ('$id', '$postid', '$text', 0, 0)";
    mysql_query($sql);

    // Modify post data in 'posts'
    $sql = "UPDATE posts SET comments = comments + 1 WHERE postid = $postid";
    mysql_query($sql);


    // Redirect back to index
    redirect("index.php?amiawinner=yes&whatijustdid=commented");
    
?>
