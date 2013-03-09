<html>
<head>
<Title>Class Search Results - All</Title>
<style type="text/css">
    body { background-color: #fff; border-top: solid 10px #000;
        color: #333; font-size: .85em; margin: 20; padding: 20;
        font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
    }
    h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
    h1 { font-size: 2em; }
    h2 { font-size: 1.75em; }
    h3 { font-size: 1.2em; }
    table { margin-top: 0.75em; }
    th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
    td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
</style>
</head>
<body>
<h1>Course Info</h1>
<p>Here are the stats for all classes in database.</p>
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
    
    // Retrieve data
    $sql_select = "SELECT * FROM registration_tbl";
    $stmt = $conn->query($sql_select);
    $registrants = $stmt->fetchAll(); 
    if(count($registrants) > 0) {
        echo "<h2>People who are registered:</h2>";
        echo "<table>";
        echo "<tr><th>Name</th>";
        echo "<th>Email</th>";
        echo "<th>Course</th>";
        echo "<th>Term/Year</th></tr>";
        foreach($registrants as $registrant) {
            $course = $registrant['dept'].".".$registrant['cn'];
            echo "<tr><th>".$registrant['name']."</th>";
            echo "<th>".$registrant['email']."</th>";
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
?>
<form>
    <input type="button" value="Click to go back." onClick="window.location.href='http://www.jackrlong.com/hack4/'">
</form>
</body>
</html>