<?php
if($currentUser->UserRole == READER){
	if(isset($_POST['search'])){
		$searchString = $_POST['searchstring'];
		//echo "<br>".$searchString;
		$mutipleKeyWords = false;
		if(strstr($searchString, ",") != FALSE){
			$keywords = explode(",", $searchString);
			$mutipleKeyWords = true;
		}
		else{
			$keywords = $searchString;
		}
		$searchResult = Content::SearchContent($keywords, $mutipleKeyWords);	
		/*
		echo "<pre>";
		print_r($searchResult);
		echo "</pre>";
		*/
		//topics.topic_ID,topic_title,content,created_date, comment_text
		if($searchResult == NO_TOPICS_FOUND){
			$showMessage = "No results found for keyword '".$searchString."'";
		}
		else{
			$resultCount = sizeof($searchResult);
			$showMessage = $resultCount." results found for keyword '".$searchString."'";
		}
		?>
		<div id="searchform">
			<script type="text/javascript">
				function search_news(){
					if(document.getElementById("searchstring").value == ""){
						alert("Please enter keyword/keywords (move your mouse over the text box for tips)");
					}
					else{
						document.getElementById("searchfrm").submit();
					}
				}
			</script>
			<form id="searchfrm" action=<?php echo '"http://'.$_SERVER['HTTP_HOST'].'/~unn_w12038150/"' ?> method="post">
				<div title="You can search by entering a single word or two words seperated by ',' e.g. pizza,newcastle or pizaa. The two words entered will be searched together." class="forminput" style="margin-left:68%;margin-top:5px;"><input type="text" id="searchstring" name="searchstring"></div>
				<input type="hidden" name="search" value="1"/>
				<div class="button" style="float:right;margin-top:5px;margin-right:0px;"><input style="height:25px;" type="button" name="search" value="Search" onclick="search_news()" /></div>
			</form>
		</div>
		<?php
		echo '<div id="searchmsg">'.$showMessage.'</div>';

		if($searchResult != NO_TOPICS_FOUND){
			foreach ($searchResult as $key => $oneResult) {
				echo '<div class="newslist">';
				$topicTitle = "";
				$contentStr = implode(' ', array_slice(explode(' ', $oneResult['content']), 0, 40)).'...';
				
				if($mutipleKeyWords == true){
					$topicTitle = str_replace($keywords[0], '<span class="keyword">'.$keywords[0].'</span>', $oneResult['topic_title']);
					$topicTitle = str_replace($keywords[1], '<span class="keyword">'.$keywords[1].'</span>', $oneResult['topic_title']);
					$contentStr = str_replace($keywords[0], '<span class="keyword">'.$keywords[0].'</span>', $contentStr);	
					$contentStr = str_replace($keywords[1], '<span class="keyword">'.$keywords[1].'</span>', $contentStr);	
				}
				else{
					$topicTitle = str_replace($keywords, '<span class="keyword">'.$keywords.'</span>', $oneResult['topic_title']);
					$contentStr = str_replace($keywords, '<span class="keyword">'.$keywords.'</span>', $contentStr);	
				}
				
				echo '<h3 class="newstitle"><a href="http://'.$_SERVER['HTTP_HOST']."/~unn_w12038150/?topic=".$oneResult['topic_ID'].'">'.$topicTitle.'</a></h3><p>';
									
				echo '<div class="shortnews">'.$contentStr;
				echo '<a href="http://'.$_SERVER['HTTP_HOST']."/~unn_w12038150/?topic=".$oneResult['topic_ID'].'" style="float:right">Read more</a>';
				echo '</div>';
				echo '</div>';
			}
		}
		
	}
}

?>