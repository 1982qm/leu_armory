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
  async function CleanLog () {
    fetch('php/clean_log.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
    })
    .then(data => show_info("Pulizia log eseguita"))
    .catch(error => show_error("Errore in pulizia log: " + error));
  }

  async function CleanSessions () {
    fetch('php/clean_sessions.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
    })
    .then(data => show_info("Pulizia sessioni eseguita"))
    .catch(error => show_error("Errore in pulizia sessioni: " + error));
  }  

  function CleanDB () {
    CleanLog ();
    CleanSessions ();   
  }

  function WipePlayers () {
    var wipe = function () {
      fetch('php/wipe_players.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json'
          },
      })
      .then(data => show_info("Wipe eseguita"))
      .catch(error => show_error("Errore in wipe players: " + error));
    };
    show_confirmation_modal("Sei sicuro?", wipe);
  }  

  function SetPwd () {
    fetch('php/set_pwd.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: '{' +
            '"user": "' + $("#UserName").val() + '", ' +
            '"pwd": "' + $("#newPwd").val() + '"' +
        '}',
    })
    .then(data => { show_info("Cambio password eseguito"); $("#UserName").val(""); $("#newPwd").val(""); })
    .catch(error => show_error("Errore in wipe players: " + error));
  }

  function LoadAccounts (data) {
    var def1 = document.createElement("option");
    document.getElementById("UserName").appendChild(def1);

    data.forEach( 
        element => {
            var option = document.createElement("option");
            option.innerText = element.user_name;

            document.getElementById("UserName").appendChild(option);
        }
      )

      $("#UserName").select2({
        placeholder: "Seleziona Utente...",
        language: "it"
      });      
  }

  function FetchAccounts () {
    fetch('php/load_accounts.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => LoadAccounts(data))
    .catch(error => console.log("Errore in caricamento: " + error));
  }

</script>
<body>

    <div id="content" class="container-fluid px-4" style="top: 30px;position: relative;">
      <div class="card bg-dark text-white mb-4" style="opacity: 95%;">
          <div class="card-header d-flex align-items-center">
              <img src="img\admin.svg" width="36px" height="36px" />
              <span id="datatableTitle" style="padding-left: 15px;">Admin Functions</span>
          </div>
          <div class="card-body">
              <button onclick="javascript:CleanDB()" class="btn btn-sm btn-primary">Clean DB</button>
          </div>
          <div class="card-body">
              <button onclick="javascript:WipePlayers()" class="btn btn-sm btn-primary">Wipe Players</button>
          </div>
          <div class="card-body" style="display:flex">
                  <div style="width: 300px; margin-right: 20px;"><select id="UserName"></select></div>
                  <input type="text" id="newPwd" placeholder="New Password" style="margin-right: 20px;"></input>
                  <button onclick="javascript:SetPwd()" style="margin-right: 20px;" class="btn btn-sm btn-primary">Cambia Password</button>
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

  <script>
      $( document ).ready(function() {
        FetchAccounts();
      });
  </script>  
</body>

</html>