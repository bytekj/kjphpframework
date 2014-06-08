<?php
//this page shows form to add news 
if(isset($_POST["addnews"])){
	$newstitle = $_POST['newstitle'];
	$newstext = $_POST['news_text'];
	$userID = $currentUser->UserID;
	$contentType = 1;
	echo "<br>here";
	Content::AddContent($newstitle, $newstext,$contentType,$userID);
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/~unn_w12038150/');
}

?>
<div id="addnewspage">
	<script type="text/javascript">
	function submit_add_news_form(){
			var newstitleEle = document.getElementById("newstitle");
			var newsContentEle = document.getElementById("news_text");

			if(newstitleEle.value == newstitleEle.defaultValue){
				alert("Please enter the news title");
			}
			else if(newsContentEle.value == newsContentEle.defaultValue){
				alert("Please enter the news content");	
			}
			else{
				document.getElementById("comform").submit();
			}
		}
	</script>
	<form id="comform" action=<?php echo '"http://'.$_SERVER['HTTP_HOST'].'/~unn_w12038150/"'; ?> method="post">
		<input type="text" id="newstitle" name="newstitle" value="News title here" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;"/>
		<textarea id="news_text" name="news_text" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;">Enter your news content
		</textarea>
		<input type="hidden" name="addnews" value="1" />
		<input type="button" id="comment_button" value="Submit" onclick="submit_add_news_form()"> 
	</form>
</div>