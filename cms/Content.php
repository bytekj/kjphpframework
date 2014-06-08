<?php
class Content{

	public static function GetContentList(){
		$sql = "select topics.topic_ID,topic_title,content,created_date 
		from topics, topic_content, topics_approved
		where topics.topic_ID=topic_content.topic_ID and 
		topics_approved.topic_ID=topics.topic_ID and 
		topic_content.content_type=1 and
		topics_approved.approved=true
		order by created_date desc";

		$dh = new DataHandler();
		$result = $dh->GetQuery($sql);
		if($result == ""){
			return NO_TOPICS_FOUND;
		}
		else 
			return $result;
	}
	public static function GetContentListByReporterID($reporterID){
		$sql = "select topics.topic_ID,topic_title,content,created_date,approved 
		from topics, topic_content, topics_approved
		where topics.topic_ID=topic_content.topic_ID and 
		topics_approved.topic_ID=topics.topic_ID and 
		topic_content.content_type=1 and
		topics.user_ID='".$reporterID."'
		group by topics_approved.approved
		order by created_date desc";
		$dh = new DataHandler();
		$result = $dh->GetQuery($sql);
		if($result == ""){
			return NO_TOPICS_FOUND;
		}
		else 
			return $result;	
	}
	public static function GetContentListForEditor(){
		$sql = "select topics.topic_ID,topic_title,content,created_date, approved, forename, surname 
		from topics, topic_content, topics_approved, users 
		where topics.topic_ID=topic_content.topic_ID and 
		topics_approved.topic_ID=topics.topic_ID and 
		topic_content.content_type=1 and 
		topics.user_ID=users.user_ID
		order by approved,created_date desc";

		$dh = new DataHandler();
		$result = $dh->GetQuery($sql);
		if($result == ""){
			return NO_TOPICS_FOUND;
		}
		else 
			return $result;	
	}

	public static function GetContentDetailByReporterID($topicID, $userID){
		$sql = "select topics.topic_ID,topic_title,content,created_date, approved 
		from topics, topic_content, topics_approved 
		where topics.topic_ID=topic_content.topic_ID and 
		topics_approved.topic_ID=topics.topic_ID and
		topics.topic_ID = '".$topicID."' and
		topics.user_ID = '".$userID."'
		group by topic_content.content_type";
		$dh = new DataHandler();
		$result = $dh->GetQuery($sql);
		if($result == ""){
			return INVALID_TOPIC;
		}
		else{
			return $result;
		}
	}

	public static function GetContentDetail($topicID){
		$sql = "select topics.topic_ID,topic_title,content,created_date 
		from topics, topic_content, topics_approved 
		where topics.topic_ID=topic_content.topic_ID and 
		topics_approved.topic_ID=topics.topic_ID and
		topics.topic_ID = '".$topicID."' and
		topics_approved.approved=true
		group by topic_content.content_type";
		$dh = new DataHandler();
		$result = $dh->GetQuery($sql);
		if($result == ""){
			return INVALID_TOPIC;
		}
		else{
			return $result;
		}
	}
	public static function GetContentDetailForEditor($topicID){
		$sql = "select topics.topic_ID,topic_title,content,created_date, forename,surname, approved
		from topics, topic_content, topics_approved, users 
		where topics.topic_ID=topic_content.topic_ID and 
		topics_approved.topic_ID=topics.topic_ID and
		topics.topic_ID = '".$topicID."' and
		users.user_ID = topics.user_ID
		group by topic_content.content_type";
		$dh = new DataHandler();
		$result = $dh->GetQuery($sql);
		if($result == ""){
			return INVALID_TOPIC;
		}
		else{
			return $result;
		}
	}

	public static function AddComment($topicID, $userID, $commentText){
		$sql = "INSERT INTO `posted_comments`
		(`topic_ID`, `user_ID`, `comment_text`, `posted_date`) 
		VALUES ('".$topicID."','".$userID."','".$commentText."',CURRENT_TIMESTAMP)";
		$dh = new DataHandler();
		$result = $dh->PutQuery($sql);
		return $result;	

	}

	public static function GetComments($topicID){
		$sql = "SELECT forename,surname,comment_text,posted_date 
		FROM users,posted_comments WHERE users.user_ID=posted_comments.user_ID and topic_ID=".$topicID." order by posted_date desc";
		$dh = new DataHandler();
		$result = $dh->GetQuery($sql);
		if($result == ""){
			return NO_COMMENTS;
		}
		else{
			return $result;
		}	
	}

	public static function AddContent($topicTitle, $topicContent,$contentType,$userID){
		//insert into topics
		$topicsInsertSQL = 
		"INSERT INTO `topics`(`topic_title`, `user_ID`, `created_date`) 
		VALUES ('".$topicTitle."','".$userID."',CURRENT_TIMESTAMP)";
		//echo "<br>".$topicsInsertSQL;
		$dh = new DataHandler();
		$dh->connect();
		$dh->NoConnectPutQuery($topicsInsertSQL);

		//get last inserted topic id
		$lastInsertID = $dh->LastInsertID();
		//echo "<br>last insertid :".$lastInsertID;
		//insert into topic_content
		$topicContentInsertSQL = 
		"INSERT INTO `topic_content`(`topic_ID`, `content_type`, `content`) 
		VALUES ('".$lastInsertID."','".$contentType."','".$topicContent."')";
		//echo "<br>".$topicsInsertSQL;

		$dh->NoConnectPutQuery($topicContentInsertSQL);
		
		//insert into topics_approved
		$topicApprovedInsertSQL = 
		"INSERT INTO `topics_approved`(`topic_ID`, `approved`) 
		VALUES ('".$lastInsertID."',false)";
		//echo "<br>".$topicApprovedInsertSQL;
		$dh->NoConnectPutQuery($topicApprovedInsertSQL);
		$dh->Disconnect();
	}

	public static function ApproveContent($topicID){
		$sql = "UPDATE `topics_approved` SET `approved`=true WHERE topic_ID=".$topicID;
		//return $sql;
		
		$dh = new DataHandler();
		$result = $dh->PutQuery($sql);
		return $result;	

	}

	public static function SearchContent($keyword,$twoKeyowrds){
		$sql = "";

		if($twoKeyowrds == false){
			$sql = "select topics.topic_ID as topic_ID,topic_title,content,comment_text,created_date 
			from topics, topic_content, topics_approved,posted_comments 
			where topics.topic_ID=topic_content.topic_ID and 
			topics_approved.topic_ID=topics.topic_ID and 
			topic_content.content_type=1 and 
			topics_approved.approved=true and 
			(topic_title like '%".$keyword."%' or content like '%".$keyword."%' or comment_text like '%".$keyword."%') 
			group by topic_ID order by created_date desc";
		}
		if($twoKeyowrds == true){
			
			$sql = "select topics.topic_ID as topic_ID,topic_title,content,comment_text,created_date 
			from topics, topic_content, topics_approved,posted_comments 
			where topics.topic_ID=topic_content.topic_ID and 
			topics_approved.topic_ID=topics.topic_ID and 
			topic_content.content_type=1 and 
			topics_approved.approved=true and 
			((topic_title like '%".$keyword[0]."%' and topic_title like '%".$keyword[1]."%') or	(content like '%".$keyword[0]."%' and content like '%".$keyword[1]."%') or (comment_text like '%".$keyword[0]."%' and comment_text like '%".$keyword[1]."%'))group by topic_ID order by created_date desc";	
		}
		//return $sql;

		$dh = new DataHandler();
		$result = $dh->GetQuery($sql);

		if($result == ""){
			return NO_TOPICS_FOUND;
		}
		else{

			/*
			filter duplicate results

			duplicates occure because of join with posted_comments
			since the query groups results by topic id the topic ids will not be scattered
			hence the duplicates can be filtered by comparing previous column matched and previous 
			topic id matched if they are same then the result under consideration is duplicate
			*/

			$filteredResult = "";

			$prevTopic = 0;
			$prevSearchCol = 0;
			$currentSearchCol = 0;
			$currentTopic = 0;
			$i = 0;
			foreach ($result as $key => $value) {
				$currentTopic = $value['topic_ID'];
				$currentCol = 0;
				$duplicate = false;
				if(strstr($value['topic_title'], $keyword)){
					$currentSearchCol = 1;
				}			
				else if(strstr($value['content'],$keyword)){
					$currentSearchCol = 2;
				}
				else if(strstr($value['comment_text'],$keyword)){
					$currentSearchCol = 3;
				}
				if($prevTopic == $currentTopic && $prevSearchCol == $currentSearchCol){
					//this is dupliucate result
					$duplicate = true;
				}
				else{
					$duplicate = false;
				}

				if($duplicate == false){
					$filteredResult[$i] = $value;
					$i++;
				}
				$prevTopic = $currentTopic;
				$prevSearchCol = $currentSearchCol;
			}

			return $filteredResult;
		}		

	}
}
?>