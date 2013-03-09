<html>
<body>
<?php
include "dbinfo.php";
$con=mysqli_connect($host,$user,$pwd,$db);
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
if(empty($_POST)) {
    mysqli_query($con,"DELETE FROM registration_tbl");
    mysqli_close($con);
    echo "<h1>Deleted all!</h1>";
}
else{
    $email2 = $_POST['email2'];
    echo "<h1>".$email2."<h1>";
    mysqli_query($con,"DELETE FROM registration_tbl WHERE email = '$email2'");
    mysqli_close($con);
    echo "Deleted!";
}
?>

<form>
    <input type="button" value="Click to go back." onClick="window.location.href='http://www.jackrlong.com/hack4/'">
</form>
</body>
</html>