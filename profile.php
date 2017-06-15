<!DOCTYPE html>

<html>

  <head>
    <?require_once("includes/common.php"); ?>
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <script src="helpers.js" type="text/javascript"></script>
    <title>Harvard World: Profile</title>
  </head>

  <body>

    <?include 'toolbar.html';?>

    <?
      // scrub input
      $profileid = mysql_real_escape_string($_GET["id"]);

      // check if id is valid 
      $sql = "SELECT * FROM users WHERE id=$profileid";
      $result = mysql_query($sql);
    
      if (mysql_num_rows($result) != 1)
        apologize("Not a valid profile id!");
      
      // find data of profile  
      $row = mysql_fetch_array($result);
      $profileusername = $row["username"];
      $joined = $row["time"];
      
      echo "<div id='profilename'>
        $profileusername's profile! member since $joined  
      </div>"; 
      
      // if profile belongs to user, display post box
      if ($loggedin && $profileid == $_SESSION["id"])
        echo "<div id='makepost'>
          Post Here Please:
          <br>
          <form action='post.php' method='post' onsubmit='return validateSubmission(this);'>
            <textarea id='postarea' name='submissionBox' $disable type='text' maxlength='1000' rows='19' cols='40' onchange='pageDirtyFlag=true;'></textarea>
            <br>
            <input type='submit' $disable value='Submit Post'>
          </form>
        </div>";
      
      //else, display follow-status
      else 
      {
          $follow = "Follow this cooool cat!";
          
          if ($loggedin)
          {
            $sql = "SELECT * FROM followees WHERE id={$_SESSION['id']} AND followeeid=$profileid";
            $result = mysql_query($sql);
            $confirm = mysql_num_rows($result);
            if ($confirm == 1)
              $follow = "Unfollow this f*cker.";
          }    
              
          echo "<div id='followstatus'>
            <form action='follow.php' method='post'>
              <input type='submit' $disable value='$follow'>
              <input type='hidden' name='followeeid' value='$profileid'>
            </form>
          </div>";
      }

      // retrieve followees
      $sql = "SELECT * FROM followees WHERE id=$profileid ORDER BY time DESC";
      $result = mysql_query($sql);
      
      echo "<div id='followeelist'>
        <h1>People $profileusername is following:</h1>";
      while ($row = mysql_fetch_array($result))
      {
        $followeeid = $row["followeeid"];
        $time = $row["time"];

        // find username of followee
        $sql1 = "SELECT username FROM users WHERE id=$followeeid";
        $result1 = mysql_query($sql1);
        $row1 = mysql_fetch_array($result1);
        $followeename = $row1["username"];
        
        echo "<div id='followee$followeeid' class='followee'>
          <a href='profile.php?id=$followeeid'>$followeename</a>, since $time
        </div>";
      }
      echo "</div>";
      
      // retrieve posts
      $sql = "SELECT * FROM posts WHERE id=$profileid ORDER BY time DESC";
      $result = mysql_query($sql);
      
      echo "<table id='postlist'>
        <h1>Posts by $profileusername:</h1>";
        
      require_once("postloop.php");

      echo "<tr> 
              <td bgcolor='#CCC' width='250' height='10'></td><td bgcolor='#CCC' width='1000' height='10'></td>
            </tr>
          </table>";


      // retrieve favorites
      echo "<table id='favoritelist'>
        <h1>$profileusername's favorite posts: </h1>";
        
      
      $sql = "SELECT * FROM favorites WHERE id=$profileid";
      $result = mysql_query($sql);
      
      require_once("favoriteloop.php");
      
      echo "<tr> 
              <td bgcolor='#888' width='250' height='10'></td><td bgcolor='#888' width='1000' height='10'></td>
            </tr>
          </table>";
    
    ?>

  </body>

</html>
