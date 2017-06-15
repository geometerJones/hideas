
  <?
    while ($row = mysql_fetch_array($result))
    { 
      // find post data
      $postid = $row["postid"];
      $id = $row["id"];
      $text = $row["text"];
      $upvotes = $row["upvotes"];
      $downvotes = $row["downvotes"];
      $comments = $row["comments"];
      $time = $row["time"];

      // find postername
      $sql1 = "SELECT username FROM users WHERE id=$id";
      $result1 = mysql_query($sql1);
      $row1 = mysql_fetch_array($result1);
      $postername = $row1["username"];
        
      // set default vote, favorite-status
      $vote = 0;
      $favorite = "favorite";
      
      // set gradient color
      $totalvotes = $upvotes + $downvotes;
      if ($totalvotes == 0)
        $gradient = 5;
      else
        $gradient = floor(10 * $upvotes / $totalvotes);

      // if logged in, find user's vote, favorite status for the post
      if ($loggedin)
      { 
        // find vote
        $sql2 = "SELECT vote FROM votes WHERE id={$_SESSION['id']} AND type=0 AND objectid=$postid";
        $result2 = mysql_query($sql2);
        if ($row2 = mysql_fetch_array($result2))
          $vote = $row2["vote"];
           
        // find favorite-status
        $sql3 = "SELECT * FROM favorites WHERE id={$_SESSION['id']} AND postid=$postid";
        $result3 = mysql_query($sql3);
        if (mysql_num_rows($result3) == 1)
          $favorite = "unfavorite"; 
      }
      
      // display the page's post, vote buttons, (un)favorite button(buttons disabled if not logged-in)
      echo "<tr> 
              <td bgcolor='#CCC' width='250' height='10'></td><td bgcolor='#CCC' width='1000' height='10'></td>
            </tr>
        <tr id='post$postid' class='post'>
          <td>
          <table>
          <tr>
            <form id='features' action='vote.php' method='post'>
              <input name='upvote' $disable type='submit' value='$upvotes legit'>
              <input name='downvote' $disable type='submit' value='$downvotes weak'>
              <input name='type' type='hidden' value='0'>
              <input name='objectid' type='hidden' value='$postid'>  
            </form>
            <form id='features' action='favorite.php' method='post'>
              <input name='favorite' $disable type='submit' value='$favorite'>
              <input name='postid' type='hidden' value='$postid'>  
            </form>
          </tr><br>";
          

      // if logged-in, indicate user's vote
      if ($loggedin)
      {
        if ($vote == 1)
          echo "you liked this post";
        else if ($vote == -1)
          echo "you disliked this post";
        else
          echo "vote on this post";
      } 
      echo "</table></td>
          <td class='grad$gradient'>
            posted by <a href='profile.php?id=$id'>$postername</a> at $time:
            <br><br>$text<br><br>
            $comments <a href='page.php?postid=$postid'>comments</a>
          </td>
      </tr>";
    }
  ?>

