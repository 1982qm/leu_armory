<!DOCTYPE HTML>
<html lang="it">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
  	<link rel="stylesheet" href="css/login.css?1.0">
</head>

<script src="lib/jquery-3.5.1.min.js"></script>

<body>
  <div class="wrapper">
	<div style="position: relative">
		<img src="img\\title.png" style="height: 400px; position: relative; left:-10px;">
		<div id="formMsg">		
		<?php
			require("user_config.php");

			global $salt,$sess_time,$dbu;

			if(isset($_GET['logout']) AND $_GET['logout']=='y'){ //get the logout variable from login.php?logout=y
				$isLoggedIn = isLoggedIn();
				if($isLoggedIn) {
					$user=$isLoggedIn;
					$user_id = $user['id'];
					$dbnu = new PDO('sqlite:'.$dbu);
					//$dbnu->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$stmt = $dbnu->prepare('UPDATE active_users SET terminated = 1 WHERE session_id=:session_id AND user_id=:user_id');
					$stmt->bindValue(":user_id",$user_id, PDO::PARAM_INT);
					$stmt->bindValue(":session_id",session_id(), PDO::PARAM_STR);
					$stmt->execute();
					releaseToken($dbnu);
				}
			}
			// Controllo se c'è un token settato in cookie
			$checkToken = checkToken();
			if($checkToken) { 
				$user = $checkToken;
				createSession($user['id'], null);
				header('location:'.$header_redirect);
				exit();
			} else {
				$isLoggedIn = isLoggedIn();
				if($isLoggedIn) {
					$user=$isLoggedIn;
					updateExpire($user['id']);
					header('location:'.$header_redirect);
					exit();
				}
			}

			if(isset($_POST['registerButton'])){
				if (empty($_POST['username'])) {
					echo('<span class="spanMsg">Inserire uno Username</span>');
				}
				elseif (empty($_POST['password'])) {
					echo('<span class="spanMsg">Inserire una password</span>');
				}
				elseif (empty($_POST['passwordReg2'])) {
					echo('<span class="spanMsg">Ripetere la password</span>');
				}
				elseif ($_POST['passwordReg2'] != $_POST['password']) {
					echo('<span class="spanMsg">Le password non coincidono</span>');
				} else  {
					$dbnu = new PDO('sqlite:'.$dbu);
					//$dbnu->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$stmt = $dbnu->prepare('SELECT * FROM users WHERE upper(user_name) = upper(:username)LIMIT 1');
					$stmt->bindParam(":username",$_POST['username'], PDO::PARAM_STR);
					$stmt->execute();
					$row = $stmt->fetch(PDO::FETCH_ASSOC);
					if(!empty($row)) {
						echo('<span class="spanMsg">Username già registrato</span>');
					} else {
						$password=hash("sha512",$_POST['password']);
					
						//$dbnu->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$stmt = $dbnu->prepare("INSERT INTO users (user_name,name,email,password,user_type,registration_ts) VALUES (:username, :username, :username, :password, 3, datetime(CURRENT_TIMESTAMP, 'localtime'))");
						$stmt->bindParam(":username",ucfirst($_POST['username']), PDO::PARAM_STR);
						$stmt->bindParam(":password",$password, PDO::PARAM_STR);
						$stmt->execute();

						// Creo la sessione
						$stmt = $dbnu->prepare('SELECT * FROM users WHERE upper(user_name) = upper(:username) AND password = :password LIMIT 1');
						$stmt->bindParam(":username",$_POST['username'], PDO::PARAM_STR);
						$stmt->bindParam(":password",$password, PDO::PARAM_STR);
						$stmt->execute();
						$row = $stmt->fetch(PDO::FETCH_ASSOC);
						if(!empty($row)) {
							// Creo la sessione
							createSession($row['id'], $dbnu);
							// Creo il token
							createToken($row['id'], $dbnu);
							header('Location:'.$_SERVER["PHP_SELF"]);
							exit();
						} else {
								echo('<span class="spanMsg">Username o Password errati</span>');
						}						
					}
				}
			}

			if(isset($_POST['submitButton'])){
				if (empty($_POST['username'])) {
					echo('<span class="spanMsg">Inserire uno Username</span>');
				}
				elseif (empty($_POST['password'])) {
					echo('<span class="spanMsg">Inserire una password</span>');
				} else {
					$password=hash("sha512",$_POST['password']);
					//echo $_POST['username'].'<br>'.$password.'<br>';
					$dbnu = new PDO('sqlite:'.$dbu);
					//$dbnu->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$stmt = $dbnu->prepare('SELECT * FROM users WHERE upper(user_name) = upper(:username) AND password = :password LIMIT 1');
					$stmt->bindParam(":username",$_POST['username'], PDO::PARAM_STR);
					$stmt->bindParam(":password",$password, PDO::PARAM_STR);
					$stmt->execute();
					$row = $stmt->fetch(PDO::FETCH_ASSOC);
					if(!empty($row)) {
						// Creo la sessione
						createSession($row['id'], $dbnu);
						// Creo il token
						createToken($row['id'], $dbnu);
						header('Location:'.$_SERVER["PHP_SELF"]);
						exit(); 
					} else {
						echo('<span class="spanMsg">Username o Password errati</span>');
					}
				}
			}
			if (!isLoggedIn()) { //show login form if not logged in
		?>
		</div>
		<div id="formContainer">
			<form id="login" method="post" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
			<input type="text" name="username" id="username" placeholder="Username" style="text-transform: capitalize;"
				<?php
				if (!empty($_POST['username'])) {
					echo(' value="'.$_POST['username'].'" ');
				} else {
					echo(' autofocus ');
				}
				?>
			>
			<br>
			<input type="password" name="password" id="password" placeholder="Password"
			<?php
				if (!empty($_POST['username'])) {
					echo(' autofocus ');
				}
				?>
			><br>
			<input type="submit" name="submitButton" id="submitButton" value="LOGIN" 
				<?php 
				if(isset($_POST['registerButton'])) {
					echo(' style="display: none;" ');
				} 
				?>
			>
			<br id="br1" 
				<?php 
				if(isset($_POST['registerButton'])) {
					echo(' style="display: none;" ');
				} 
				?>
			>
			<label id="showRegister" class="register" onClick="showRegister()"
			<?php 
				if(isset($_POST['registerButton'])) {
					echo(' style="display: none;" ');
				} 
				?>
			>Registrati</label>
			<br id="br2" 
				<?php 
				if(isset($_POST['registerButton'])) {
					echo(' style="display: none;" ');
				} 
				?>
			>
			<input type="password" name="passwordReg2" id="passwordReg2" placeholder="Ripeti la Password" 
				<?php 
				if(!isset($_POST['registerButton'])) {
					echo(' style="display: none;" ');
				}
				?>
			>
			<br>
			<input type="submit" name="registerButton" id="registerButton" value="REGISTRATI"
				<?php 
				if(!isset($_POST['registerButton'])) { 
					echo(' style="display: none;" ');
				}
				?>
			>
			</form>
		<?php } ?>
		</div>
	</div>
</div>

<script>
	function showRegister () {
		document.getElementById('passwordReg2').style.display = 'table-cell';
		document.getElementById('registerButton').style.display = 'table-cell';
		document.getElementById('submitButton').style.display = 'none';
		document.getElementById('showRegister').style.display = 'none';
		document.getElementById('br1').style.display = 'none';
		document.getElementById('br2').style.display = 'none';
		document.getElementById('username').focus();
	}

	<?php
	if(!(isset($_GET['logout']) AND $_GET['logout']=='y')) {
	?>
		window.addEventListener("load", function () {
			$("#username").val("Guest");
			$("#password").val("guest");
			$("#submitButton").click();
		})
	<?php } ?>

</script>

</body>

</html>
