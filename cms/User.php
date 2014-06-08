<?php

class User{
	
	var $Username;
	var $UserRole;
	var $Forename;
	var $Surname;
	var $UserID;
	/*
	user role 1: admin
	user role 2: editor
	user role 3: reporter
	user role 4: reader
	*/

	public static function CreateUser($forename, $surname, $userid, $password, $arrRoles){
		//insert into user
		$lastInsertID = 0;
		$insertUserSQL = "INSERT INTO `users`(`forename`, `surname`, `username`, `password`) 
		VALUES ('".$forename."','".$surname."','".$userid."','".$password."')";
		$dh = new DataHandler();
		$dh->connect();
		$dh->NoConnectPutQuery($insertUserSQL);

		$lastInsertID = $dh->LastInsertID();
		//get last insert id

		foreach ($arrRoles as $key => $role) {
			//insert into user roles
			$insertRoleSQL = "INSERT INTO `roles`(`user_ID`, `role`) VALUES ('".$lastInsertID."','".$role."')";
			$dh->NoConnectPutQuery($insertRoleSQL);
		}
		$dh->Disconnect();
		return $lastInsertID;
	}


	public function __construct(){
		$this->Username = "";
		$this->UserRole = "";
		$this->Forename = "";
		$this->Surname = "";
		$this->UserID = 0;
	}

	
	public function authenticate($username, $password, $role){
		$sql = "SELECT users.user_ID,users.username, roles.role, users.forename, users.surname 
		FROM users,roles 
		where users.user_ID = roles.user_ID and users.username = '".$username."' and users.password = '".$password."' and roles.role='".$role."'";
		/*
		echo $sql."<br>";
		exit();
		*/
		$dh = new DataHandler();
		$result = $dh->GetQuery($sql);

		if($result == ""){
			return INVALID_LOGIN;
		}
		else{
			/*
			echo "<pre>";
			print_r($result);
			echo "</pre>";
			exit();
			*/
			$this->Username = $result[0]["username"];
			$this->UserRole = $result[0]["role"];
			$this->Forename = $result[0]["forename"];
			$this->UserID = $result[0]['user_ID'];
			$this->Surname = $result[0]['surname'];

			return LOGIN_SUCCESS;
		}

	}
	public function getUser($userID,$userRole){
		$sql = "SELECT users.user_ID,users.username, roles.role, users.forename, users.surname 
		FROM users,roles 
		where users.user_ID = roles.user_ID  and users.user_ID='".$userID."' and roles.role=".$userRole; ;
		echo $sql;
		$dh = new DataHandler();
		$result = $dh->GetQuery($sql);

		if($result == ""){
			
			return INVALID_USER;
		}
		else{
			$this->Username = $result[0]["username"];
			$this->UserRole = $result[0]["role"];
			$this->Forename = $result[0]["forename"];
			$this->UserID = $result[0]['user_ID'];
			$this->Surname = $result[0]['surname'];

			return VALID_USER;
		}		
	}
}
?>