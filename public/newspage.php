<?php
if(isset($_POST['comm'])){
	if($currentUser->UserRole == REPORTER || $currentUser->UserRole == READER){
		$topicID = $_POST['comm'];
	//echo "<br>userid: ".$currentUser->UserID;
		$commentResult = Content::AddComment($topicID,$currentUser->UserID,urlencode($_POST['comment_text']));	
		header('Location: http://'.$_SERVER['HTTP_HOST']."/~unn_w12038150/?topic=".$topicID);
	}
}
else if(isset($_GET['topic'])){
	$topicID = $_GET['topic'];	
}
else if(isset($_GET['approve'])){
	if($currentUser->UserRole == EDITOR){

		$topicID = $_GET['approve'];
		echo "here";
		$result = Content::ApproveContent($topicID);
		header("Location: ".$_SERVER['REQUEST_URI']);
		echo $result;
	}
}

if($currentUser->UserRole == REPORTER){
	$topicDetail = Content::GetContentDetailByReporterID($topicID,$currentUser->UserID);
}
else if($currentUser->UserRole == READER){
	$topicDetail = Content::GetContentDetail($topicID);
}
else if($currentUser->UserRole == EDITOR){

	$topicDetail = Content::GetContentDetailForEditor($topicID);
	//echo "here";
}
/*
echo "<pre>";
print_r($topicDetail);
echo "</pre>";
*/
if($topicDetail == INVALID_TOPIC){
	echo "<h2>No donut for you!</h2>";
}
else{
	?>
	<div id="newsdetail">
		<h2 id="newstitlebig"><?php echo $topicDetail[0]['topic_title'] ?></h2>
		<div id="newstext">
			<p class="justifytext">
				<?php
				echo $topicDetail[0]['content'];
				?>
			</p>
		</div>
		<div class="newsdate">Date posted: <?php 
			$date = strtotime( $topicDetail[0]['created_date'] );
			$topicDate = date( 'D M Y', $date );
			echo $topicDate; ?>
		</div>
		<?php 
		if($currentUser->UserRole == REPORTER || $currentUser->UserRole == EDITOR){
			if($topicDetail[0]['approved'] == 0){
				$status = "Pending for approval";
			}
			else{
				$status = "published";
			}
			echo '<div class="news_status">Status: '.$status.'</div>';
		}
		if($currentUser->UserRole == EDITOR){
			echo '<div class="news_created_by">Posted by: '.$topicDetail[0]['forename'].' '.$topicDetail[0]['surname'].'</div>';
		}
		?>
	</div>
	<?php
	if($currentUser->UserRole == EDITOR && $topicDetail[0]['approved'] == 0){
		?>
		<div id="approveform">
			<form method="get" action=<?php echo '"'.$_SERVER['REQUEST_URI'].'"'; ?>>
				<input type="hidden" name="approve" value=<?php echo '"'.$topicDetail[0]['topic_ID'].'"' ?>>
				<input type="submit" value="Publish">
			</form>
		</div>
		<?php
	}
	else if($currentUser->UserRole == REPORTER || $currentUser->UserRole == READER){


		?>

		<div id="comments">
			<div id="commentform">
				<script type="text/javascript">
					function submit_comments_form(){
						var commentEle = document.getElementById("comm_text");
						if(commentEle.value == commentEle.defaultValue){
							alert("Please enter your comment");
						}
						else{
							document.getElementById("comform").submit();
						}
					}
				</script>
				<form id="comform" action=<?php echo '"http://'.$_SERVER['HTTP_HOST'].'/~unn_w12038150/"'; ?> method="post">
					<textarea id="comm_text" name="comment_text" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;">Enter your comment here
					</textarea>
					<input type="hidden" name="comm" value=<?php echo '"'.$topicDetail[0]['topic_ID'].'"'?> />
					<input type="button" id="comment_button" value="Submit" onclick="submit_comments_form()"> 
				</form>
			</div>
			<?php
			$topicComments = Content::GetComments($topicID);

			if($topicComments != NO_COMMENTS){
				foreach ($topicComments as $key => $topicComment) {
			//forename,surname,comment_text,posted_date
					echo '<div class="comment">';
					echo '<div class="commentowener">'.$topicComment['forename'].' '.$topicComment['surname'].':</div>';
					echo '<div class="commenttext">'.urldecode($topicComment['comment_text']).'</div>';
					$date = strtotime( $topicComment['posted_date'] );
					$commentDate = date( 'D M Y', $date );
				//echo $date;
					echo '<div class="coment_date">'.$commentDate.'</div>';
					echo '</div>';
				}
			}
			?>
		</div>
		<?php
	}
}

echo "<pre>";
print_r($currentUser);
echo "</pre>";
//echo $commentResult;

?>