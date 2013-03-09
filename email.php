<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php
    include "dbinfo.php";
    // DB connection info
    //TODO: Update the values for $host, $user, $pwd, and $db
    //using the values you retrieved earlier from the portal.
    // Connect to database.
    try {
        $conn = new PDO( "mysql:host=$host;dbname=$db", $user, $pwd);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch(Exception $e){
        die(var_dump($e));
    }
    // Insert registration info
    if(empty($_POST)) {
        echo "Empty form!";
    }
    else{
        $email = $_POST['email'];
        echo "<h1> Emailing to: ".$email."<h1>";
        // Retrieve data
        $sql_select = "SELECT * FROM registration_tbl WHERE email = '$email'";
        $stmt = $conn->query($sql_select);
        $registrants = $stmt->fetchAll();
        if(count($registrants) > 0) {
            $body = "";
            foreach($registrants as $registrant) {
                $course = $registrant['dept'].".".$registrant['cn'];
                $body = $body + "<th>".$course."</th>";
            }
            mail($email, "Your courses on Telebears Search", $body, $email);
            echo "Sent!";
        } else {
            echo "<h3>Not currently registered.</h3>";
        }
    }
?>
<form>
    <input type="button" value="Click to go back." onClick="window.location.href='http://www.jackrlong.com/telebears/'">
</form>
</html>