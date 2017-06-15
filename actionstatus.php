  <?
    $amiawinner = htmlspecialchars($_GET["amiawinner"]);
    
    if ($amiawinner == "yes")
    {
      $whatijustdid = htmlspecialchars($_GET["whatijustdid"]);
     
      if ($whatijustdid == "posted")
        $whatijustdid = "posted new content!";
      else if ($whatijustdid == "commented")
        $whatijustdid = "made a comment!";
      else if ($whatijustdid == "voted")
        $whatijustdid = "casted your vote!";
      else if ($whatijustdid == "addedfav")
        $whatijustdid = "added stuff to your favorites!";
      else if ($whatijustdid == "removedfav")
        $whatijustdid = "removed stuff from your favorites!";
      else if ($whatijustdid == "followed")
        $whatijustdid = "started following some person!";
      else if ($whatijustdid == "unfollowed")
        $whatijustdid = "unfollowed some dude!";
      else if ($whatijustdid == "loggedon")
        $whatijustdid = "logged on!";
      else
        $whatijustdid = "messed with the webpage :(";
      echo "congratulations $username! you just $whatijustdid
      <br>"; 
    }
    if ($amiawinner == "no")
      echo "please log in first!
      <br>"; 
  ?>
