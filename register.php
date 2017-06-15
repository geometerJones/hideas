<?

    // require common code
    require_once("includes/common.php"); 

    // check for blank fields
    if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["password2"]) || empty($_POST["email"]) || empty($_POST["email2"]))
        apologize("Please fill out all required fields");   
        
    // check password == password2
    if (strcmp($_POST["password"], $_POST["password2"]) != 0)
        apologize("Your passwords do not match");
        
    // check email2 == email2
    if (strcmp($_POST["email"], $_POST["email2"]) != 0)
        apologize("Your emails do not match");
    
    // escape username to avoid SQL injection attacks
    $username = mysql_real_escape_string($_POST["username"]);

    // encrypt password
    $hash = crypt($_POST["password"]);
    
    // get user's email address
    $email = $_POST["email"];
    
    // divide email into two strings at @
    $domain = explode('@', $email, 2);
    
    // check if email has Harvard domain
    if (strcmp($domain[1], "college.harvard.edu") != 0 && strcmp($domain[1], "fas.harvard.edu") != 0)
        apologize("Sorry. You must have a Harvard email.");
        
    // check if email is in use
    $result = mysql_query("SELECT email FROM users WHERE email='$email'");
    if (mysql_num_rows($result) != 0)
        apologize("Sorry that email is already taken");
    
    // prepare insert username, password and email
    $sql = "INSERT INTO users (username, hash, email) VALUES ('$username', '$hash', '$email')";
    
    // insert into table or else
    if (!mysql_query($sql))
        apologize("Sorry that username is already taken");
        
    // user's now logged in by caching user's ID in session
    $_SESSION["id"] = mysql_insert_id();
    
    // redirect to portfolio
    redirect("index.php");
    
?>
