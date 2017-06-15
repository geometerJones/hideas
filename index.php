<!DOCTYPE html>

<html>

  <head>
    <?require_once("includes/common.php"); ?>
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <script src="helpers.js" type="text/javascript"></script>
    <title>Harvard Ideas: Home</title>
  </head>

  <body>
   
    <?include 'toolbar.html';?>
    
    <div id="main">

        <div id="flowtoss">
            <input type="submit" value="Flow-Bro Baggins" onclick="flowToss()">
        </div>
        <br>
        <div id="actionstatus">
          <?require_once("actionstatus.php"); ?>
        </div>

        <table>      
          <td id="makepost">
          <table>
          <tr>
            <form action="http://www.google.com/search">
                <input name="q" type="text">
                <input type="submit" value="Search the Web!">
            </form><br><br><br><br>
          </tr> 
          <tr>
          Post Here Please:
            <form action="post.php" method="post" onsubmit="return validateSubmission(this);">        
              <textarea id="postarea" name="submissionBox" <?=$disable?> type="text" maxlength="1000" rows="19" cols="40" onchange="pageDirtyFlag=true;"></textarea>
              <br>
              <input type='submit' <?=$disable?> value="Submit Post">
              <input type="button" value="Poop Toss" onclick="poopToss()">
            </form>
            
          <? if (!$loggedin): ?>
            Log in first, b*tch!
          <? endif; ?> 
          </tr>
          </table>
        </td>
        
        
        <td id='postlist'>
        <table>
          <?
            // find number of posts in 'posts'
            $sql = "SELECT COUNT(postid) AS count FROM posts";
            $result = mysql_query($sql);
            $row = mysql_fetch_array($result);
            $count = $row["count"];
            
            // find number of pages (0 indexed)
            $lastpage = intval(($count - 1) / POSTS_PER_PAGE);
            
            // scrub input
            $page = htmlspecialchars($_GET["page"]);
            
            // convert to int
            $page = intval($page);
            
            // find page number for display purposes
            $pagenumber = $page + 1;

            // check that page number is valid
            if ($page < 0 || $page > $lastpage)
                redirect("index.php?page=0");
             
            // set prev and next page numbers
            $prev = $page - 1;
            $next = $page + 1;
            
            // set boundaries for posts to be displayed on page
            $high = $count - $page * POSTS_PER_PAGE;
            $low = $high - POSTS_PER_PAGE + 1;
            if ($low < 1)
              $low = 1;         
            
            // find last page for display purposes
            $finalpage = $lastpage + 1;
            
            echo "<tr><td></td><td id='pagenumber'>you are on page $pagenumber of $finalpage</td>
            </tr>";
            
            // find posts
            $sql = "SELECT * FROM posts WHERE postid BETWEEN $low and $high ORDER BY time DESC";
            $result = mysql_query($sql);
              
            require_once("postloop.php");
          ?>
          <tr> 
            <td bgcolor='#CCC' width='200' height='10'></td><td bgcolor='#CCC' width='1000' height='10'></td>
          </tr>
        </table>
        </td>
        </table>
      </div>
        
      <div id="footer">  
        <div id="navigation">
          <? 
            if ($page > 0)
              echo "<a href='index.php?page=$prev'>previous</a>";
          ?>          
          <?   
            if ($page < $lastpage)
              echo "<a href='index.php?page=$next'>next</a>";
          ?>
        </div>
      </div>
    
    
  </body>

</html>
