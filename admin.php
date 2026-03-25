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
  <script src="lib/datatables.min.js"></script>
  <script src="js/messages.js"></script>
  <script src="js/manageDT.js?1.0"></script>
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
    .then(data => {
      show_info("Cambio password eseguito");
      $("#UserName").val("");
      $("#UserName").trigger("change");
      $("#newPwd").val("");
    })
    .catch(error => show_error("Errore in cambio password: " + error));
  }

  function SetGuild () {
    fetch('php/set_guild.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: '{' +
            '"username": "' + $("#UserNameGuild").val() + '", ' +
            '"gilda": "' + $("#Guild").val() + '"' +
        '}',
    })
    .then(data => { 
      show_info("Gilda settata correttamente");
      $("#UserNameGuild").val("");
      $("#UserNameGuild").trigger("change");
      $("#Guild").val("");
      $("#Guild").trigger("change");
      FetchGuilds();
    })
    .catch(error => show_error("Errore modifica gilda: " + error));
  }  

  function LoadAccounts (data, ddl) {
    var def1 = document.createElement("option");
    document.getElementById(ddl).appendChild(def1);

    data.forEach( 
        element => {
            var option = document.createElement("option");
            option.innerText = element.user_name;

            document.getElementById(ddl).appendChild(option);
        }
      )

      $("#"+ddl).select2({
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
    .then(data => {
      LoadAccounts(data, "UserName");
      LoadAccounts(data, "UserNameGuild");
    })
    .catch(error => console.log("Errore in caricamento: " + error));
  }


  function FetchGuilds () {
    fetch('php/load_guilds.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => LoadGuilds(data))
    .catch(error => console.log("Errore in caricamento: " + error));
  }

  function LoadGuilds (data) {
    var table = LoadDataTable($("#datatableGuilds"),
                              data,
                              function (element) {
                                  return [element.username,
                                          element.gilda
                                          ];
                              },
                              undefined, //click function
                              false, //selectable
                              undefined //ordinamento
    );
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
          <div class="card-body" style="display:flex">
                  <div style="width: 300px; margin-right: 20px;"><select id="UserNameGuild"></select></div>
                  <div style="width: 300px; margin-right: 20px;">
                    <select id="Guild">
                      <option value=''></option>
                      <option value='Luce!'>Luce!</option>
                      <option value='Spettri'>Spettri</option>
                      <option value='Lama e Pietra'>Lama e Pietra</option>
                      <option value='Jedi'>Jedi</option>
                      <option value='Vendicatori'>Vendicatori</option>
                      <option value='I Filosofi'>I Filosofi</option>
                      <option value='ARKANGELI'>ARKANGELI</option>
                      <option value='Vampiri'>Vampiri</option>
                      <option value='Mercenari'>Mercenari</option>
                      <option value='Cavalieri del Tuono'>Cavalieri del Tuono</option>
                      <option value='Esploratori'>Esploratori</option>
                      <option value='[S]alii'>[S]alii</option>
                      <option value='Anacronisti'>Anacronisti</option>
                      <option value='Bibliotecari'>Bibliotecari</option>
                      <option value='Grigi'>Grigi</option>                      
                    </select>
                  </div>
                  <button onclick="javascript:SetGuild()" style="margin-right: 20px;" class="btn btn-sm btn-primary">Setta la Gilda</button>
          </div>

          <div id="gridContainer" class="collapse show" style="font-size: 14px;">
              <div class="card-body">
                  <table id="datatableGuilds" class="table table-striped hover compact">
                      <thead>
                          <tr>
                              <th>UserName</th>
                              <th>Gilda</th>
                          </tr>
                      </thead>
                      <tfoot>
                          <tr>
                              <th>UserName</th>
                              <th>Gilda</th>
                          </tr>
                      </tfoot>
                      <tbody></tbody>
                  </table>
              </div>
          </div>          
      </div>
    </div>

    <div id="confirm-modal" class="modal" style="display: none">
      <div class="modal-content">
          <center>
                <div class="modal-header">
                    <div class="modal-title">
                        <span id="confirm-modal-text" class="text-white">Confermi?</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" id="modal-confirm-btn-yes"
                        data-dismiss="modal">Si</button>
                    <button type="button" class="btn btn-primary btn-sm" id="modal-confirm-btn-no"
                        data-dismiss="modal">No</button>
                </div>
          </center>
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
        $("#Guild").select2({
          placeholder: "Seleziona Gilda...",
          language: "it"
        });
        var initComplete = function (dt) {
            window.addEventListener('orientationchange', function (){
                var dtTable = $("#datatableGuilds").DataTable();
                dtTable.columns.adjust();
            });
            FetchGuilds();
        };
        CreateDataTable($("#datatableGuilds"), initComplete);
      });
  </script>  
</body>

</html>