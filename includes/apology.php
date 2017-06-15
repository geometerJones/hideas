
<!DOCTYPE html>

<html>

  <head>
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <title>Harvard Ideas: Sorry!</title>
  </head>

  <body>

    <div id="top">
      <a href="index.php"><img alt="Harvard World" src="images/logowhite.jpg"></a>
    </div>

    <div id="middle">
      <h1>Sorry!</h1>
      <h2><?= $message ?></h2>
    </div>

    <div id="bottom">
      <a href="javascript:history.go(-1);">Back</a>
    </div>

  </body>

</html>
