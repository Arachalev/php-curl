
<?php

session_start();

session_destroy();

header("Location: login.php");
exit;

//the session is destryed and the user is redirected to the login page 