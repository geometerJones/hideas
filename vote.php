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

    // check for valid input
    if (!empty($_POST["upvote"]))
    {
        $vote = 1;
        $votetype = "upvotes";   
    }
    else if (!empty($_POST["downvote"]))
    { 
        $vote = -1;
        $votetype = "downvotes";
    }
    else
        apologize("You broke the voting system");
    
    $type = mysql_real_escape_string($_POST["type"]);
    $objectid = mysql_real_escape_string($_POST["objectid"]);
    
    // check for past vote
    $sql = "SELECT vote FROM votes WHERE id='$id' AND type='$type' AND objectid='$objectid'";
    $result = mysql_query($sql);
    if (mysql_num_rows($result) != 0)
        apologize("You already voted man");

    $sql = "INSERT INTO votes (id, type, objectid, vote) VALUES ('$id', '$type', '$objectid', '$vote')";
    mysql_query($sql);
    
    if ($type == 0)
    {
        $table = "posts";
        $idtype = "postid";
    }    
    elseif ($type == 1)
    {
        $table = "comments";
        $idtype = "commentid";
    }
    else
        apologize("Stop, please!");
    
    $sql = "UPDATE $table SET $votetype = $votetype + 1 WHERE $idtype = $objectid";
    mysql_query($sql);    

    // Redirect back to index
    redirect("index.php?amiawinner=yes&whatijustdid=voted");
    
?>
