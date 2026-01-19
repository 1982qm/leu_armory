<!DOCTYPE HTML>
<html lang="it" data-bs-theme="dark">

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

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>LeU Armory</title>
    <link href="css/select2.min.css" rel="stylesheet" />
    <link href="css/styles.css?1.0" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/datatables.min.css" rel="stylesheet">
    <link href="css/dataTables.bootstrap5.css" rel="stylesheet">
    <link href="css/content.css?1.4" rel="stylesheet" />
    <link href="css/login.css" rel="stylesheet" />
    <link href="css/filters.css?1.0" rel="stylesheet" />
    <link href="css/forms.css" rel="stylesheet" />
</head>

<script src="lib/jquery-3.5.1.min.js"></script>
<script src="lib/fontawesome.all.js"></script>
<script src="lib/bootstrap.bundle.min.js"></script>
<script src="lib/md5.js"></script>
<script src="lib/select2.min.js"></script>
<script src="lib/select2.it.min.js"></script>
<script src="lib/datatables.min.js"></script>
<script src="lib/chart.js"></script>
<script src="js/make_chart.js"></script>
<script src="js/manageDT.js?1.0"></script>
<script src="js/common.js"></script>

<?php if ($isLoggedIn && $user['user_type'] == "1") {?>
  <script src="js/messages.js"></script>
<?php }?>

<body id="body">
  <main>

    <?php if ($isLoggedIn && $user['user_type'] == "1") {?>
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
    <?php }?>

    <div id="loadingDiv" class="modal" style="display: none">
      <div id="loadingDivContent" class="modal-content">
          <center>
              <img src="img/loading.gif"/><span style="position:relative; padding:20px;">Caricamento in corso...</span>
          </center>
      </div>
    </div>
    
    <div id="content" class="container-fluid px-4" style="display: none; top: 30px;position: relative;">
      <div class="card bg-dark text-white mb-4" style="opacity: 95%;">
          <div class="card-header d-flex align-items-center">
              <img src="img\percorsi.svg" width="36px" height="36px" />
              <span id="datatableTitle" style="padding-left: 15px;">Percorsi</span>
          </div>
          <div id="gridContainer" class="collapse show" style="font-size: 14px;">
              <div class="card-body">
                  <table id="datatablePercorsi" class="table table-striped hover compact">
                      <thead>
                          <tr>
                              <th>Nome</th>
                              <th>Livello Minimo</th>
                              <th>Livello Massimo</th>
                              <th>Limiti</th>
                          </tr>
                      </thead>
                      <tfoot>
                          <tr>
                              <th>Nome</th>
                              <th>Livello Minimo</th>
                              <th>Livello Massimo</th>
                              <th>Limiti</th>
                          </tr>
                      </tfoot>
                      <tbody></tbody>
                  </table>
              </div>
          </div>
      </div>
    </div>

    <?php if ($isLoggedIn && $user['user_type'] == "1") {?>
      <!-- Form di inserimento / modifica - inizio -->
      <div id="editForm" class="container-fluid px-4" style="display: none; top: 30px; position: relative;">
        <div class="card bg-dark text-white mb-4" style="opacity: 95%;">
            <div class="card-header d-flex align-items-center">
                <img src="img\percorsi.svg" width="24px" height="24px" />
                <span id="formModificaTitle" style="padding-left: 15px;">Inserisci/Modifica</span>
            </div>
            <div id="formInputContainer" class="collapse show" style="font-size: 14px;">
              <form style="margin: 20px; display: flex; flex-wrap: wrap;">
                <!-- nome -->
                <div class="formInputContainer">
                  <label for="frmPercorsoNome" class="formLabel">Nome:</label><br>
                  <input type="text" id="frmPercorsoNome" name="frmPercorsoNome" class="formValue" placeholder="Nome del percorso">
                </div>
                <!-- liv min -->
                <div class="formInputContainer">
                  <label for="frmPercorsoLivMin" class="formLabel">Livello Minimo:</label><br>
                  <input type="text" id="frmPercorsoLivMin" name="frmPercorsoLivMin" class="formValue" placeholder="Livello minimo">
                </div>
                <!-- liv max -->
                <div class="formInputContainer">
                  <label for="frmPercorsoLivMax" class="formLabel">Livello Massimo:</label><br>
                  <input type="text" id="frmPercorsoLivMax" name="frmPercorsoLivMax" class="formValue" placeholder="Livello massimo">
                </div>
                <!-- limiti -->
                <div class="formInputContainer">
                  <label for="frmPercorsoLimiti" class="formLabel">Limiti:</label><br>
                  <input type="text" id="frmPercorsoLimiti" name="frmPercorsoLimiti" class="formValue" placeholder="Limiti">
                </div>
              </form>
              <div class="formInputContainer">
                <input type="submit" onclick="SavePercorso()" class="btn btn-success btm-sm formButton" value="Salva">
                <input type="submit" onclick="CancelEditing()" class="btn btn-secondary btm-sm formButton" value="Annulla">
              </div>
            </div>
        </div>
      </div> 
      <!-- Form di inserimento / modifica - fine -->
    <?php } ?>
  </main>  

  <script>
        //PRELOAD
        var images = [];

        function preload() {
          for (var i = 0; i < arguments.length; i++) {
            images[i] = new Image();
            images[i].src = preload.arguments[i];
          }
        }

        preload (
          "/armory/img/percorsi.svg",
          "/armory/img/background.jpg"
        )

        $(document).ready(function() {
            CreateDataTable($("#datatablePercorsi"),
                              <?php if ($isLoggedIn && $user['user_type'] == "1") {?>
                                'Aggiungi', AddPercorso, 'Modifica', EditPercorso, 'Elimina', DeletePercorso
                              <?php } ?>
                            );
            window.addEventListener('orientationchange', function (){
                var dtTable = $("#datatablePercorsi").DataTable();
                dtTable.columns.adjust();
            });

            FetchPercorsi();
        })

        function FetchPercorsi () {
          fetch('php/load_percorsi.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json'
              }
          })
          .then(response => response.json())
          .then(data => LoadPercorsi(data))
          .catch(error => console.log("Errore in caricamento: " + error));
        }

        function LoadPercorsi (data) {
          var table = LoadDataTable($("#datatablePercorsi"),
                                    data,
                                    function (element) {
                                        return [element.nome,
                                                element.liv_min,
                                                element.liv_max,
                                                element.limiti
                                               ];
                                    },
                                    undefined, //click function
                                    true, //selectable
                                    undefined //ordinamento
          );
          setTimeout(() => {
            $(".dt-search").parent().css("position","absolute");
            $(".dt-search").parent().css("top","-72px");
            $(".dt-search").parent().css("right","10px");
            $(".dt-search").parent().css("font-size","14px");
            $(".dt-search input").css("border-color","#464D54");

            table.on('childRow.dt', function (e, show, row) {
              $("ul.dtr-details > li").each (function() {
                  if ($(this).find(".dtr-data").text().length == 0) {
                    $(this).addClass("hideDetail");
                  }
              })
            })

            document.getElementById("loadingDiv").style.display = "none";
            document.getElementById("content").style.display = "block";
          }, 300);
        }

        <?php if ($isLoggedIn && $user['user_type'] == "1") {?>
          function AddPercorso (el) {
            ResetForm ();
            $("#formModificaTitle").text("Aggiungi Percorso");
            $("#editForm").show();
            // Scrollo la pagina sulla form
            document.getElementById("editForm").scrollIntoView();          
          }

          function EditPercorso (el) {
            ResetForm ();
            // Recupero il record selezionato
            var selected = document.getElementsByClassName("selected");
            // Deve essere selezionato un record
            if (selected.length == 1) {
              var itemName = selected[0].childNodes[0].innerText;
              FetchPercorsoDetail(itemName);
            } else {
                // Non è stato selezionato il record
                show_error('Seleziona un elemento');
            }          
          }

          function FetchPercorsoDetail(name) {
              fetch('php/load_percorso_detail.php', {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/json'
                  },
                  body: '{"nome" : "' + name + '"}'
              })
              .then(response => response.json())
              .then(data => LoadPercorsoDetail(data))
              .catch(error => console.log("Errore in caricamento: " + error));
          }

          function LoadPercorsoDetail(data) {
              var el = data[0];

              $("#frmPercorsoNome").val(el.nome);
              $("#frmPercorsoLivMin").val(el.liv_min);
              $("#frmPercorsoLivMax").val(el.liv_max);
              $("#frmPercorsoLimiti").val(el.limiti);              

              $("#formModificaTitle").text("Modifica Percorso");
              $("#editForm").show();
              // Scrollo la pagina sulla form
              document.getElementById("editForm").scrollIntoView();
          }

          function DeletePercorso (el) {
            // Recupero il record selezionato
            var selected = document.getElementsByClassName("selected");
            // Deve essere selezionato un record
            if (selected.length == 1) {
                var name = selected[0].childNodes[0].innerText;
                var delitem = function () {
                  ExecDeletePercorso(name);
                };
                show_confirmation_modal ("Confermi la cancellazione di: '" + name + "'?", delitem);
            } else {
                // Non è stato selezionato il record
                show_error('Seleziona un elemento');
            }
          }

          function ExecDeletePercorso (name) {
              fetch('php/delete_percorso.php', {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/json'
                  },
                  body: '{"nome" : "' + name + '"}'
              })
              .then(response => FetchPercorsi ())
              .catch(error => console.log("Errore in caricamento: " + error));
          }

          function CancelEditing () {
            $("#editForm").hide();
          }

          function SavePercorso () {
            var name = $("#frmItemNome").val();
            ExecSavePercorso(name);
            $("#editForm").hide();
          }

          function ExecSavePercorso (name) {
              fetch('php/insert_percorso.php', {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/json'
                  },
                  body: '{' +
                           '"nome" : "'                 +  $("#frmPercorsoNome").val()         + '",' + 
                           '"liv_min" : "'              +  $("#frmPercorsoLivMin").val()       + '",' + 
                           '"liv_max" : "'              +  $("#frmPercorsoLivMax").val()       + '",' + 
                           '"limiti" : "'               +  $("#frmPercorsoLimiti").val()       + '"' + 
                        '}' 
              })
              .then(response => FetchPercorsi ())
              .catch(error => console.log("Errore in caricamento: " + error));
          }

          function ResetForm () {
              $("#frmPercorsoNome").val("");
              $("#frmPercorsoLivMin").val("");
              $("#frmPercorsoLivMax").val("");
              $("#frmPercorsoLimiti").val("");
          }

        <?php }?>

  </script>

</body>

</html>
