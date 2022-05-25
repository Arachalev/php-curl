<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM  users 
                       WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);

    //here, a query is made to the database to fetch data that matches with the inputed email
    $user = $result->fetch_assoc();
    
    if ($user) {
        //if there's a user, the entered password is then verified. if the entered password is correct
        // the user is redirected to the index page
        if (password_verify($_POST["password"], $user["password_hash"])) {

            var_dump($user);

            
            session_start();
            
            session_regenerate_id();
            //a session is started and the user data is stored, so it can e=be accessed in other
            //pages while logged in.
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: index.php");
            exit;
        }
        die("login unsucessful");
    }
    
    $is_invalid = true;
}

?>
 <?php require("header.html") ?>

    
    <h1>Login</h1>
    
    <?php if ($is_invalid): ?>
        <em>Invalid login</em>
    <?php endif; ?>
    
    <form method="post">
        <label for="email">email</label>
        <input type="email" name="email" id="email"
               value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
        
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        
        <button>Log in</button>
    </form>
    
    <?php require("footer.html") ?>
 