<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<Title>Class Search Results - Single</Title>
</head>
<body>
<h1>Course Info</h1>
<p>Here are the stats about your class.</p>
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
        echo "<h1>".$email."<h1>";
        // Retrieve data
        $sql_select = "SELECT * FROM registration_tbl WHERE email = '$email'";
        $stmt = $conn->query($sql_select);
        $registrants = $stmt->fetchAll();
        if(count($registrants) > 0) {
            echo "<table>";
            echo "<th>Course</th>";
            echo "<th>Term/Year</th></tr>";
            foreach($registrants as $registrant) {
                $course = $registrant['dept'].".".$registrant['cn'];
                echo "<th>".$course."</th>";
                echo "<th>".$registrant['term']."-".$registrant['year']."</th></tr>";
                $html = "https://apis-qa.berkeley.edu/cxf/asws/classoffering?courseNumber=".$registrant['cn']."&departmentName=".$registrant['dept']."&term=".$registrant['term']."&termYear=".$registrant['year']."&_type=xml&app_id=2377f86c&app_key=5876ded8c10cbe0454d7251211dbd23b";
                $ch = curl_init(); 

                // set url 
                curl_setopt($ch, CURLOPT_URL, $html); 

                //return the transfer as a string 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

                // $output contains the output string 
                $output = curl_exec($ch);
                
                // close curl resource to free up system resources 
                curl_close($ch);
                $xml = simplexml_load_string($output);
                echo "<tr>";
                //print_r($xml);
                foreach($xml->children() as $classOffering){
                    //echo "<td>".$classOffering->classUID."</td>";
                    //echo "</tr><tr>";
                    foreach($classOffering->children() as $section){
                        if ($section->getName() == "sections"){
                            echo "<td>".$section->sectionId." has ".$section->seatsAvailable." seats available.</td>";
                        }
                    }
                    echo "</tr>";
                }
                //echo "<tr><td>".$output."</td></tr>";
            }
            echo "</table>";
            
            
            
        } else {
            echo "<h3>No one is currently registered.</h3>";
        }
    }
?>
<form method="post" action="email.php" enctype="singlepart/data" >
    Email me this data! <input type="text" name="email" id="email"/></br>
    <input type="submit" name="sub1" value="Email me! (unfinished)" />
</form>
<form>
    <input type="button" value="Click to go back." onClick="window.location.href='http://www.jackrlong.com/telebears/'">
</form>
</body>
</html>