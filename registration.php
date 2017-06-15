<?

    // require common code
    require_once("includes/common.php");

?>

<!DOCTYPE html>

<html>

  <head>
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <title>Harvard World: Register</title>
  </head>

  <body>

    <?include 'toolbar.html';?>

    <div id="middle">
      <form action="register.php" method="post">
        <table>
          <tr>
            <td align="right">Enter Username:</td>
            <td><input name="username" type="text"></td>
          </tr>
          <tr>
            <td align="right">Enter Password:</td>
            <td><input name="password" type="password" ></td>
          </tr>
          <tr>
            <td align="right">Confirm Password:</td>
            <td><input name="password2" type="password" ></td>
          </tr>
          <tr>
            <td align="right">Enter Email:</td>
            <td><input name="email" type="text"></td>
          </tr>
          <tr>
            <td align="right">Confirm Email:</td>
            <td><input name="email2" type="text"></td>
          </tr>
          <tr>
            <td colspan="2"><input type="submit" value="Register"></td>
          </tr>
        </table>
      </form>
    </div>
  </body>

</html>
