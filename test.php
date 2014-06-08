<?php
/*
session_start();  
if(isset($_SESSION['views']))
    $_SESSION['views'] = $_SESSION['views']+ 1;
else
    $_SESSION['views'] = 1;

echo "views = ". $_SESSION['views']; 
session_destroy();
*/
//header("Location: index.php")
session_start();
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
?>