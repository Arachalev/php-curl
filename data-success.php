<!-- Code to show when a data has been successfully sent  -->

<?php
session_start();
$user = $_SESSION['user'] ;
$data = $_SESSION['responseId'];



?>
<?php require "header.html" ?>


 
        <h4><?= htmlspecialchars($user["name"]) ?></h4>
        <h4><?= htmlspecialchars($user["oid"])?></h4>
        <h4>Response Id =  <?= htmlspecialchars($data["id"]) ?></h4>

        <p>Data recorded successfully</p>
        <button><a href="./logout.php">Log Out</a></button>
        <button><a href="./index.php">Home</a></button>
 

<?php require "footer.html" ?>
