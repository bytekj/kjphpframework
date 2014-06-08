<html>
<title>Northumbria Times</title>
<body><h3><?php echo "today is ".date("D M Y"); ?></h3>
<?php 
$host="localhost";
$port=3306;
$socket="";
$user="root";
$password="sam123";
$dbname="test";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
	or die ('Could not connect to the database server' . mysqli_connect_error());

if($con->connect_error) {
	echo $con->connect_errno;

}
else{
	echo "connection sucessful";
}
//$con->close();

 ?>
</body>
</html>