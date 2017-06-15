<?  

    // require common code
    require_once("includes/common.php"); 

    // check if logged in
    if (!isset($_SESSION["id"]))
        redirect("index.php?amiawinner=no");
    
    $id = $_SESSION["id"];

    // check if id is valid 
    $sql = "SELECT * FROM users WHERE id=$id";
    $result = mysql_query($sql);
    
    if (mysql_num_rows($result) != 1)
        redirect("index.php?amiawinner=no");

    // scrub input
    $followeeid = mysql_real_escape_string($_POST["followeeid"]);
    
    // check whether followee is already being followed
    $sql = "SELECT * FROM followees WHERE id=$id AND followeeid=$followeeid";
    $result = mysql_query($sql);
    
    // if not already following, start following; else, stop following
    if (mysql_num_rows($result) == 0)
    {
        $sql = "INSERT INTO followees (id, followeeid) VALUES ($id, $followeeid)";
        $change = "followed";
    }
    else
    {
        $sql = "DELETE FROM followees WHERE id=$id AND followeeid=$followeeid";
        $change = "unfollowed";
    }
    
    mysql_query($sql);

    // Redirect back to index
    redirect("index.php?amiawinner=yes&whatijustdid=$change");
    
?>
