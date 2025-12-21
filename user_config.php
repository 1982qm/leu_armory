<?php
session_start();//start a session
$dbu=realpath(__DIR__).'/database/login.db'; //database location
$salt='energyleuarmory'; //used for security reasons
$sess_time=30*24*60*60; //session expires in seconds before user has to login again. 
$header_redirect = "index.php"; //redirect after accessful login

function getToken($length = 5)
{
    return strtoupper(substr(uniqid(md5(rand())), 0, $length));
}

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function isLoggedIn(){
	//check if a user is logged in and return false or 
	//$user['id','user_name','name','email','user_type']
	global $salt,$sess_time,$dbu;
	$sessID=SQLite3::escapeString(session_id());

	if (isset($_SERVER['HTTP_USER_AGENT'])) {
		$hash=SQLite3::escapeString(hash("sha512",$sessID.$salt.$_SERVER['HTTP_USER_AGENT']));
	} else {
		$hash=SQLite3::escapeString(hash("sha512",$sessID.$salt));
	}

	$dbnu = new PDO('sqlite:'.$dbu);
	//$dbnu->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt=$dbnu->prepare('SELECT au.user_id FROM active_users au JOIN users u on u.id = au.user_id WHERE au.terminated = 0 AND au.session_id = :sessID AND au.hash = :hash AND (au.expires>'.time().' OR u.user_type = 1) LIMIT 1');
	$stmt->bindValue(":sessID",$sessID, PDO::PARAM_STR);
	$stmt->bindValue(":hash",$hash, PDO::PARAM_STR);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if(empty($row)){
	  	return false;
	} else {
	  $user_id=$row['user_id'];
	  $stmt=$dbnu->prepare('SELECT * FROM users WHERE id = :user_id LIMIT 1');
	  $stmt->bindValue(":user_id",$user_id, PDO::PARAM_STR);
	  $stmt->execute();
	  $row = $stmt->fetch(PDO::FETCH_ASSOC);
	  $user=$row;
	  return $user;
	}
}

function createToken($user_id, $dbnu){
	global $salt,$sess_time,$dbu;

	$token = getToken(32);

	//$dbnu = new PDO('sqlite:'.$dbu);
	//$dbnu->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $dbnu->prepare("INSERT INTO user_tokens (user_id,token) VALUES (:user_id,:token)");
	$stmt->bindParam(":user_id",$user_id, PDO::PARAM_INT);
	$stmt->bindParam(":token",$token, PDO::PARAM_STR);
	$stmt->execute();	
	setcookie("WNtoken", $token, time()+$sess_time);
}

function releaseToken($dbnu){
	global $salt,$sess_time,$dbu;

	if(isset($_COOKIE["WNtoken"])) {
		//$dbnu = new PDO('sqlite:'.$dbu);
		//$dbnu->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt=$dbnu->prepare('DELETE FROM user_tokens WHERE token = :token');
		$stmt->bindValue(":token",$_COOKIE["WNtoken"], PDO::PARAM_STR);
		$stmt->execute();
		unset($_COOKIE["WNtoken"]);
	}
}

function checkToken(){
	global $salt,$sess_time,$dbu;

	if(isset($_COOKIE["WNtoken"])) {
		$dbnu = new PDO('sqlite:'.$dbu);
		//$dbnu->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt=$dbnu->prepare('SELECT ut.user_id FROM user_tokens ut JOIN users u on u.id = ut.user_id WHERE ut.token = :token LIMIT 1');
		$stmt->bindValue(":token",$_COOKIE["WNtoken"], PDO::PARAM_STR);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(empty($row)){
			return false;
		} else {
			$user_id=$row['user_id'];
			$stmt=$dbnu->prepare('SELECT * FROM users WHERE id = :user_id LIMIT 1');
			$stmt->bindValue(":user_id",$user_id, PDO::PARAM_STR);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$user=$row;
			return $user;
		}
	} else {
		return false;
	}
}

function createSession($user_id, $dbnu_in){
	global $salt,$sess_time,$dbu;
	$sessID = SQLite3::escapeString(session_id());
	if (isset($_SERVER['HTTP_USER_AGENT'])) {
		$hash=SQLite3::escapeString(hash("sha512",$sessID.$salt.$_SERVER['HTTP_USER_AGENT']));
	} else {
		$hash=SQLite3::escapeString(hash("sha512",$sessID.$salt));
	}
	$expires = time()+$sess_time;
	if (!$dbnu_in) {
		$dbnu = new PDO('sqlite:'.$dbu);
	} else {
		$dbnu = $dbnu_in;
	}
	//$dbnu->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $dbnu->prepare("INSERT INTO active_users (user_id,session_id,hash,expires,ip,connection_ts) VALUES (:user_id,:session_id, :hash, :expires, :ip, datetime(CURRENT_TIMESTAMP, 'localtime'))");
	$stmt->bindParam(":user_id",$user_id, PDO::PARAM_INT);
	$stmt->bindParam(":session_id",$sessID, PDO::PARAM_STR);
	$stmt->bindParam(":hash",$hash, PDO::PARAM_STR);
	$stmt->bindParam(":expires",$expires, PDO::PARAM_INT);
	$stmt->bindParam(":ip",$_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
	$stmt->execute();
}

function updateExpire($user){ //if session is valid, update expiration time to additional $sess_time
	global $salt,$sess_time,$dbu;
	$expires=time()+$sess_time;
	$dbnu = new PDO('sqlite:'.$dbu);
	//$dbnu->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// Aggiorno la durata della sessione
	$stmt=$dbnu->prepare('UPDATE active_users SET expires=:expires WHERE terminated = 0 AND session_id=:session_id AND user_id=:user_id');
	$stmt->bindValue(":expires",$expires, PDO::PARAM_INT);
	$stmt->bindValue(":session_id",session_id(), PDO::PARAM_STR);
	$stmt->bindValue(":user_id",$user, PDO::PARAM_INT);
	$stmt->execute();
	// Loggo la chiamata
	$stmt = $dbnu->prepare("INSERT INTO log (request,request_ts,session_id) VALUES (:request, datetime(CURRENT_TIMESTAMP, 'localtime'), :session_id)");
	$stmt->bindValue(":session_id",session_id(), PDO::PARAM_STR);
	$stmt->bindParam(":request",$_SERVER['REQUEST_URI'], PDO::PARAM_STR);
	$stmt->execute();
}
?>
