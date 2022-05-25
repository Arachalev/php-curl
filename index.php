<?php
// index page of the program
session_start();
// a session is created to keep users logged in 

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM users
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    //a query is made to the database to get the details of the user with the passed in id
    
    $user = $result->fetch_assoc();
}
$_SESSION['user'] = $user
//This user data is stored in this variable $user, so it can be accessed in different pages while 
//the user is logged in 

?>
 <?php require("header.html") ?>
    
    <h1>Home</h1>
    
    <?php if (isset($user)): ?>
        
        <?php $oid = $user["oid"];?>
        <p>Hello <?= htmlspecialchars($user["name"]) ?></p>
        <p>oid = <?= htmlspecialchars($user["oid"])?></p>

        <div>
            <!-- A form to take in the required details as specified in the exam document -->
            <form action="process-send.php" method="post" id="userdata" novalidate>

                 <select name="civility" id="civility" >
                     <option value="1">Monsieur</option>
                     <option value="2">Madame</option>
                     <option value="3">Mademoiselle</option>
                 </select>
                 <label for="telephone">Telephone</label>
                 <input type="number" name="telephone" id="telephone">
                 <label for="email">Email</label>
                 <input type="email" id="email" name="email" value="recette01@pichet.com">
                 <label for="name">Nom</label>
                 <input type="text" id="name" name="name" value="HTTPS Test [AddService Media]">
                 <label for="postal">Postal Code</label>
                 <input type="number" id="postal" name="postal">
                 <select name="imposition" id="imposition">
                     <option value="1">Non imposable</option>
                     <option value="2">Moins de 2000 &euro;</option>
                     <option value="3">Moins de 2500 &euro;</option>
                     <option value="4">Entre 2500 &euro; et 3000 &euro;</option>
                     <option value="5">Entre 3000 &euro; et 5000 &euro;</option>
                     <option value="6">Entre 5000 &euro; et 10000 &euro;</option>
                     <option value="7">Plus de 10000 &euro;</option>
                 </select>
                 <label for="oid">Oid:</label>
                 <input type="text" name="oid" id="oid" value= 'PV21REC0885'  >                
               <button >Submit</button>
            </form>
        </div>


        
        <button class="logout"><a href="logout.php">Log out</a></button>
        
    <?php else: ?>
        
        <button><a href="login.php">Log in</a> or <a href="signup.php">sign up</a></button>
        
    <?php endif; ?>
    
    <?php require("footer.html") ?>
 