
  <? 
    if (!preg_match("{/(:?login|logout|register)\d*\.php$}", $_SERVER["PHP_SELF"]) && !isset($_SESSION["id"])) 
    {
      // set status
      $loggedin = false;
      $disable = "disabled='disabled' title='log-in first!'";
      
      // allow log-in, register
      echo "<form action='login.php' method='post' onsubmit='return validateLogIn(this);'>
        <table id='login'>
          <tr>  
            <td>Username:</td>
            <td><input name='username' type='text'></td>
          </tr>
          <tr>
            <td>Password:</td>
            <td><input name='password' type='password'></td>
          </tr>
          <tr>
            <td></td>
            <td><input type='submit' value='Log In'></td>
          </tr>
        </table>  
      </form>
      <text id='login'>Or <a href='registration.php'>register</a> if you don't have an account.</text>";
    }
    else
    {
      // set status
      $loggedin = true;
      $disable = "";
      
      // find username
      $sql = "SELECT username FROM users WHERE id={$_SESSION['id']}";
      $result = mysql_query($sql);
      $row = mysql_fetch_array($result);
      $username = $row["username"];
      
      // display username, allow log-out
      echo " 
        <td>
          <a href='javascript:history.go(-1);'><img class='button' id='back' alt='Back' src='images/back.jpg'></a>
        </td>
        <td>  
          <a href='profile.php?id={$_SESSION["id"]}'><img class='button' id='page' alt='My Page' src='images/profile.jpg'></a>
        </td>
        <td>
          <a href='logout.php'><img class='button' id='logout' alt='Logout' src='images/logout.jpg'></a>
        </td>
        <td class='current'>
          <text id='login'>You are now logged in as $username.</text>
        </td>";
    } 
  ?>

