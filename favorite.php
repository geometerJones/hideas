<?  

    // require common code
    require_once("includes/common.php"); 

    // check if logged in
    if (!isset($_SESSION["id"]))
        redirect("index.php?amiawinner=no");
    
    $id = $_SESSION["id"];

    // check if id is valid 
    $sqlid = "SELECT * FROM users WHERE id=$id";
    $resultid = mysql_query($sqlid);
    
    if (mysql_num_rows($resultid) != 1)
        redirect("index.php?amiawinner=no");

    $postid = mysql_real_escape_string($_POST['postid']);
    
    // find if object is already favorited
    $sql = "SELECT * FROM favorites WHERE id=$id AND postid=$postid";
    $result = mysql_query($sql);
    
    // if already favorited, delete; else insert to favorites
    if (mysql_num_rows($result) == 0)
    {
        $sql1 = "INSERT INTO favorites (id, postid) VALUES ($id, $postid)";
        $change = "addedfav";
    }
    else
    {
        $sql1 = "DELETE FROM favorites WHERE id=$id AND postid=$postid";  
        $change = "removedfav";
    }
    
    mysql_query($sql1);

    // Redirect back to index
    redirect("index.php?amiawinner=yes&whatijustdid=$change");
    
?>
