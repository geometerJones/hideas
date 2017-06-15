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

    $text = mysql_real_escape_string($_POST["submissionBox"]);
    
    // check size of post
    $length = strlen($text);
    if ($length == 0 || $length > 1000)
        apologize("Post must be between 1 and 1000 characters.");
    
    // Add post to 'posts' in the database
    $sql = "INSERT INTO posts (id, text, upvotes, downvotes, comments) VALUES ('$id', '$text', 0, 0, 0)";
    mysql_query($sql);

    // Redirect back to index
    redirect("index.php?amiawinner=yes&whatijustdid=posted");
    
?>
