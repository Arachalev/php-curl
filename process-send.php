<?php
 
session_start();
// $_SESSION['status'] = $status_code;


if (empty($_POST["name"])) {
    die("Name is required");
}

if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

$civility = (int)$_POST["civility"];
$email = $_POST["email"];
$telephone = $_POST["telephone"];
$name = $_POST["name"];
$postal = $_POST["postal"];
$imposition = (int)$_POST["imposition"];
$oid =  $_POST["oid"];

//the post data gotten from the index page is stored in variables. This is to make the code cleaner
// another table in the database is created. This is to store the unique details/information of 
//each user through their unique iod




 
$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO `user` (civility,telephone,email,name,postal , imposition,oid)
         VALUES (?, ?, ?,?,?,?,?)";
        
$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}


$stmt->bind_param("issssis",
                    $civility, 
                    $telephone,
                    $email,
                     $name,
                     $postal,
                     $imposition,
                     $oid                   
                  );
 //these variables are then passed into the database table                 
if ($stmt->execute()) {

    
$ch = require "init-curl.php";



 //the postdata for the curl function is created so that it matches the specific format  
 //indicated in the FINAL TEST document
$_curl_post_data = array("modelId"=>"zegqb7 ", 
                             "rawData"=>array(
                                            "civilte"=>$civility,
                                            "telephone"=>$telephone,
                                            "email"=>$email,
                                            "nom"=>$name,
                                            "code_postal"=>$postal,
                                            "imposition"=>$imposition,
                                            "oid"=>$oid
                            )
                            );

 


//HERE, I checked the json format of the $_curl_post_data and it matched what was 
//indicated in the exam file. But, I keep getting a 500 error that the modelId field and rawData fields are empty


// $newPost = implode("" ,$_curl_post_data);

// die( json_encode($_curl_post_data));
// exit();

// $post_data = json_encode($_curl_post_data);

curl_setopt($ch, CURLOPT_URL, "https://gateway.preprod.aws.itf.pichet.fr/psr-lead/api/v1/leads");
 
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS,  $_curl_post_data);
//Here, the data is then sent with a post request

$response = curl_exec($ch);


$status_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);


curl_close($ch);

$data = json_decode($response, true);
$_SESSION['responseId'] = $data;

// die($data[0]);
// var_dump($data["id"]);
// exit();

//Here, I check the various returned status code to be certain the post request was made

if ($status_code === 422) {
    
    echo "status 422, something went wrong ";
    print_r($data["errors"]);
    print_r($data["message"]);

    exit;
}
if ($status_code === 400) {
    
    echo "status 400, something went wrong ";
    print_r($data["errors"]);
    print_r($data["message"]);

    exit;
}
if ($status_code === 500) {
    
    echo "status 500, something went wrong ";
    print_r($data["errors"]);
    print_r($data["message"]);

    exit;
}
if ($status_code == 201) {
    
    echo($status_code["id"]);
    header("Location: data-success.php");
      //The user is redirected to the data-success page while still logged in 
    exit;
}

if ($status_code !== 201) {
    
    echo "Unexpected status code: $status_code";
    var_dump($data);    
    exit;
}

    header("Location: data-success.php");
    exit;
    
} else {
    
    if ($mysqli->errno === 1062) {
        die("email already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}
