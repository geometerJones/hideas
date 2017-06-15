<?
  while ($row = mysql_fetch_array($result))
  {
    // find comment data
    $commentid = $row["commentid"];
    $id = $row["id"];
    $text = $row["text"];
    $upvotes = $row["upvotes"];
    $downvotes = $row["downvotes"];
    $time = $row["time"];
    
    // find commentername
    $sql1 = "SELECT username FROM users WHERE id=$id";
    $result1 = mysql_query($sql1);
    $row1 = mysql_fetch_array($result1);
    $commentername = $row1["username"];
    
    // set default vote, favorite-status
    $vote = 0;
  
    // if logged in, find user's vote, favorite status for the post
    if ($loggedin)
    { 
      // find vote
      $sql2 = "SELECT vote FROM votes WHERE id={$_SESSION['id']} AND type=1 AND objectid=$commentid";
      $result2 = mysql_query($sql2);
      if ($row2 = mysql_fetch_array($result2))
        $vote = $row2["vote"];
    }
    
    // display the page's post, vote buttons, (un)favorite button(buttons disabled if not logged-in)
    echo "<table>
        <tr> 
          <td bgcolor='#888' width='250' height='10'></td><td bgcolor='#888' width='1000' height='10'></td>
        </tr>
        <tr id='comment$commentid' class='comment'>
          <td>
          <table>
            <tr>
              <form action='vote.php' method='post'>
                <input name='upvote' $disable type='submit' value='$upvotes legit'>  
                <input name='downvote' $disable type='submit' value='$downvotes weak'>
                <input name='type' type='hidden' value='1'>
                <input name='objectid' type='hidden' value='$commentid'>  
              </form>
            </tr><br>";
      
    // if logged-in, indicate user's vote
    if ($loggedin)
    {
      if ($vote == 1)
        echo "you UPvoted this comment!";
      else if ($vote == -1)
        echo "you DOWNvoted this comment!";
      else
        echo "vote on this comment!";
    }
    
    echo "</table></td>
      <td>
        posted by <a href='profile.php?id=$id'>$commentername</a> at $time:
        <br><br>$text<br><br>
      </td>
    </tr>";
  }
?>
