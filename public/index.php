<?php

?>
<div id="main">
	<header>
		<?php require 'header.php';	?>
		
	</header>
	<div id="leftsidebar">
		<?php require 'leftsidebar.php';?>
	</div>
	<div id="page">
		<?php 
		if(isset($_GET['topic']) || isset($_POST['comm']) || isset($_GET['approve'])){
			require 'newspage.php';
		}
		else if(isset($_GET['req']) || isset($_POST["addnews"])){
			if($_GET['req']=="addnews" || isset($_POST["addnews"])){
				require 'addnews.php';	
			}
			else if($_GET['req'] == "credits"){
				require 'credits.php';
			}
		}
		else if(isset($_POST['search'])){
			require 'searchresults.php';
		}
		else{
			require 'page.php'; 
		}
		?>
	</div>
	<div id="rightsidebar">
		<?php require 'rightsidebar.php'; ?>
	</div>
	<footer>
		<?php require 'footer.php'; ?>
	</footer>
</div>
