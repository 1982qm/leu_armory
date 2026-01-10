<!DOCTYPE html>
<html lang="it" data-bs-theme="dark">
<head>
  <meta charset="utf-8">

  <link href="css/select2.min.css" rel="stylesheet" />
  <link href="css/styles.css?1.0" rel="stylesheet" />    
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/datatables.min.css" rel="stylesheet">
  <link href="css/dataTables.bootstrap5.css" rel="stylesheet">
  <link href="css/content.css?1.4" rel="stylesheet" />
  <link href="css/login.css" rel="stylesheet" />
  <script src="lib/jquery-3.5.1.min.js"></script>
  <script src="lib/select2.min.js"></script>
  <script src="lib/select2.it.min.js"></script>
  <script src="js/messages.js"></script>
</head>

<?php require("user_config.php");
			$isLoggedIn = isLoggedIn();
			if($isLoggedIn) {
				$user=$isLoggedIn;
        updateExpire($user['id']);
      } else {
        //header('location:../login.php?logout=y');
        echo "<script>
                var url = (window.location != window.parent.location)
                        ? document.referrer
                        : document.location.href;
                window.top.location.href=url;
              </script>";
        die();
      }
?>

<script>
  
  function SetPwd () {
    if ($("#newPwd").val() == "") {
      show_error("Inserire una password")
      return;
    }    
    if ($("#newPwd").val() != $("#newPwdRepeat").val()) {
      show_error("Le password non coincidono")
      return;
    }
    fetch('php/set_pwd.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: '{' +
            '"user": "<?php if ($isLoggedIn) { echo $user['user_name']; } ?>", ' +
            '"pwd": "' + $("#newPwd").val() + '"' +
        '}',
    })
    .then(data => { show_info("Cambio password eseguito"); $("#newPwd").val(""); $("#newPwdRepeat").val(""); })
    .catch(error => show_error("Errore in wipe players: " + error));
  }

</script>
<body>

    <div id="content" class="container-fluid px-4" style="top: 30px;position: relative;">
      <div class="card bg-dark text-white mb-4" style="opacity: 95%;">
          <div class="card-header d-flex align-items-center">
              <img src="img\pwd.svg" width="36px" height="36px" />
              <span id="datatableTitle" style="padding-left: 15px;">Cambia la password</span>
          </div>
          <div class="card-body" style="display:flex">
                  <input type="text" id="newPwd" placeholder="Nuova Password" style="margin-right: 20px;"></input>
                  <input type="text" id="newPwdRepeat" placeholder="Ripeti la Password" style="margin-right: 20px;"></input>
                  <button onclick="javascript:SetPwd()" class="btn btn-sm btn-primary" style="margin-right: 20px;">Cambia Password</button>
          </div>
      </div>
    </div>

    <div id="messages-modal" class="modal" style="display: none">
      <div id="messages-modal-content" class="modal-content">
          <center>
              <span id="messages-modal-text" style="position:relative; padding:20px;"></span>
          </center>
      </div>
    </div>

</body>

</html>