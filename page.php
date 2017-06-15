<!DOCTYPE html>

<html>

  <head>
    <?require_once("includes/common.php"); ?>
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <script src="helpers.js"></script>
    <title>Harvard Ideas</title>
  </head>

  <body>

    <?include 'toolbar.html';?>
   
        <?
          // scrub input
          $postid = mysql_real_escape_string($_GET["postid"]);
          
          // find post
          $sql = "SELECT * FROM posts WHERE postid=$postid";
          $result = mysql_query($sql);
          
          // verify post is valid
          if (mysql_num_rows($result) != 1)
            apologize("Not a valid post, dude...");
          
          // find post data
          $row = mysql_fetch_array($result);
          $id = $row["id"];
          $text = $row["text"];
          $upvotes = $row["upvotes"];
          $downvotes = $row["downvotes"];
          $comments = $row["comments"];
          $time = $row["time"];
            
          // find postername
          $sql = "SELECT username FROM users WHERE id=$id";
          $result = mysql_query($sql);
          $row = mysql_fetch_array($result);
          $postername = $row["username"];
          
          // set default vote, favorite-status
          $vote = 0;
          $favorite = "favorite!";
          
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
            $sql = "SELECT vote FROM votes WHERE id={$_SESSION['id']} AND type=0 AND objectid=$postid";
            $result = mysql_query($sql);
            if ($row = mysql_fetch_array($result))
              $vote = $row["vote"];
                
            // find favorite-status
            $sql = "SELECT * FROM favorites WHERE id={$_SESSION['id']} AND postid=$postid";
            $result = mysql_query($sql);
            if (mysql_num_rows($result) == 1)
              $favorite = "unfavorite!"; 
          }
          
          // display the page's post, vote buttons, (un)favorite button(buttons disabled if not logged-in)
          echo "<div id='makecomment'>
              Comment Here Please:
              <form action='comment.php' method='post' onsubmit='return validateSubmission(this);'>        
                <textarea id='postarea' name='submissionBox' $disable type='text' maxlength='1000' rows='19' cols='40' onchange='pageDirtyFlag=true;'></textarea>
                <br>
                <input type='submit' $disable value='Submit Comment'>
                <input type='hidden' name='postid' value='$postid'>
              </form>
            </div>
            
        <div id='pagepost' class='post'>
          <table>
            <tr> 
              <td bgcolor='#CCC' width='250' height='10'></td><td bgcolor='#CCC' width='1000' height='10'></td>
            </tr>
            <tr>
              <td>
                <table>
                  <tr>
                    <form action='vote.php' method='post'>
                      <input name='upvote' $disable type='submit' value='$upvotes legit'>  
                      <input name='downvote' $disable type='submit' value='$downvotes weak'>
                      <input name='type' type='hidden' value='0'>
                      <input name='objectid' type='hidden' value='$postid'>  
                    </form>
                    <form action='favorite.php' method='post'>
                      <input name='favorite' $disable type='submit' value='$favorite'>
                      <input name='type' type='hidden' value='0'>
                      <input name='objectid' type='hidden' value='$postid'>  
                    </form>
                  </tr>
                </table>";
             
          // if logged-in, indicate user's vote
          if ($loggedin)
          {
            if ($vote == 1)
              echo "you UPvoted this post!";
            else if ($vote == -1)
              echo "you DOWNvoted this post!";
            else
              echo "vote on this post!";
          }
          else
            echo "you must be logged in to vote or favorite a post!";
        ?>
                
            </td>
            <td class="grad<?=$gradient?>"> 
              posted by <a href='profile.php?id=$id'><?=$postername?></a> at <?=$time?>:
              <br><br><?=$text?><br><br>
            </td>
          </tr>
          <tr> 
            <td bgcolor='#CCC' width='250' height='10'></td><td bgcolor='#CCC' width='1000' height='10'></td>
          </tr>
        </table>      
    </div>

    <div id="commentlist">
        <?
          // find number of comments about this post in 'comments'
          $sql = "SELECT COUNT(commentid) AS count FROM comments WHERE postid=$postid";
          $result = mysql_query($sql);
          $row = mysql_fetch_array($result);
          $count = $row["count"];
           
          if ($count == 0)
              echo "No comments here!";
          else    
          { 
              echo "displaying $count comments<br>";
              
              // find comments
              $sql = "SELECT * FROM comments WHERE postid=$postid ORDER BY time DESC";
              $result = mysql_query($sql);
              
              require_once("commentloop.php");
          }
        ?>
        <tr> 
          <td bgcolor='#888' width='250' height='10'></td><td bgcolor='#888' width='1000' height='10'></td>
        </tr>
      </table>
    </div>

  </body>

</html>
