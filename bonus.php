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
              <img src="img\bonus.svg" width="36px" height="36px" />
              <span id="datatableTitle" style="padding-left: 15px;">Bonus</span>
          </div>
          <div id="gridContainer" class="collapse show" style="font-size: 14px;">
              <div class="card-body">
                  <table id="datatableBonus" class="table table-striped hover compact">
                      <thead>
                          <tr>
                              <th>Nome</th>
                              <th>Percorso</th>
                              <th>Potere 2P Nome</th>
                              <th>Potere 2P Valore</th>
                              <th>Potere 4P Nome</th>
                              <th>Potere 4P Valore</th>
                          </tr>
                      </thead>
                      <tfoot>
                          <tr>
                              <th>Nome</th>
                              <th>Percorso</th>
                              <th>Potere 2P Nome</th>
                              <th>Potere 2P Valore</th>
                              <th>Potere 4P Nome</th>
                              <th>Potere 4P Valore</th>
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
                  <label for="frmBonusNome" class="formLabel">Nome:</label><br>
                  <input type="text" id="frmBonusNome" name="frmBonusNome" class="formValue" placeholder="Nome del bonus">
                </div>
                <!-- percorso -->
                <div class="formInputContainer">
                  <label for="frmBonusPercorso" class="formLabel">Percorso:</label><br>
                  <input type="text" id="frmBonusPercorso" name="frmBonusPercorso" class="formValue" placeholder="Nome del percorso">
                </div>
                <!-- 2p -->
                <div class="formInputContainer">
                  <label for="frmBonus2PProp" class="formLabel">2P Proprietà:</label><br>
                  <input type="text" id="frmBonus2PProp" name="frmBonus2PProp" class="formValue" placeholder="Proprietà 2 pezzi">
                </div>
                <div class="formInputContainer">
                  <label for="frmBonus2PVal" class="formLabel">2P Valore:</label><br>
                  <input type="text" id="frmBonus2PVal" name="frmBonus2PVal" class="formValue" placeholder="Valore 2 pezzi">
                </div>
                <!-- 4p -->
                <div class="formInputContainer">
                  <label for="frmBonus4PProp" class="formLabel">4P Proprietà:</label><br>
                  <input type="text" id="frmBonus4PProp" name="frmBonus4PProp" class="formValue" placeholder="Proprietà 4 pezzi">
                </div>
                <div class="formInputContainer">
                  <label for="frmBonus4PVal" class="formLabel">4P Valore:</label><br>
                  <input type="text" id="frmBonus4PVal" name="frmBonus4PVal" class="formValue" placeholder="Valore 4 pezzi">
                </div>
              </form>
              <div class="formInputContainer">
                <input type="submit" onclick="SaveBonus()" class="btn btn-success btm-sm formButton" value="Salva">
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
          "/armory/img/bonus.svg",
          "/armory/img/background.jpg"
        )

        $(document).ready(function() {
            CreateDataTable($("#datatableBonus"),
                              <?php if ($isLoggedIn && $user['user_type'] == "1") {?>
                                'Aggiungi', AddBonus, 'Modifica', EditBonus, 'Elimina', DeleteBonus
                              <?php } ?>
                            );
            window.addEventListener('orientationchange', function (){
                var dtTable = $("#datatableBonus").DataTable();
                dtTable.columns.adjust();
            });

            FetchBonus();
        })

        function FetchBonus () {
          fetch('php/load_bonus.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json'
              }
          })
          .then(response => response.json())
          .then(data => LoadBonus(data))
          .catch(error => console.log("Errore in caricamento: " + error));
        }

        function LoadBonus (data) {
          var table = LoadDataTable($("#datatableBonus"),
                                    data,
                                    function (element) {
                                        return [element.nome,
                                                element.percorso,
                                                element.potere_2p_nome,
                                                element.potere_2p_valore,
                                                element.potere_4p_nome,
                                                element.potere_4p_valore
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
          function AddBonus (el) {
            ResetForm ();
            $("#formModificaTitle").text("Aggiungi Bonus");
            $("#editForm").show();
            // Scrollo la pagina sulla form
            document.getElementById("editForm").scrollIntoView();          
          }

          function EditBonus (el) {
            ResetForm ();
            // Recupero il record selezionato
            var selected = document.getElementsByClassName("selected");
            // Deve essere selezionato un record
            if (selected.length == 1) {
              var itemName = selected[0].childNodes[0].innerText;
              FetchBonusDetail(itemName);
            } else {
                // Non è stato selezionato il record
                show_error('Seleziona un elemento');
            }          
          }

          function FetchBonusDetail(name) {
              fetch('php/load_bonus_detail.php', {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/json'
                  },
                  body: '{"nome" : "' + name + '"}'
              })
              .then(response => response.json())
              .then(data => LoadBonusDetail(data))
              .catch(error => console.log("Errore in caricamento: " + error));
          }

          function LoadBonusDetail(data) {
              var el = data[0];

              $("#frmBonusNome").val(el.nome);
              $("#frmBonusPercorso").val(el.percorso);
              $("#frmBonus2PProp").val(el.potere_2p_nome);
              $("#frmBonus2PVal").val(el.potere_2p_valore);              
              $("#frmBonus4PProp").val(el.potere_4p_nome);              
              $("#frmBonus4PVal").val(el.potere_4p_valore);              

              $("#formModificaTitle").text("Modifica Bonus");
              $("#editForm").show();
              // Scrollo la pagina sulla form
              document.getElementById("editForm").scrollIntoView();
          }

          function DeleteBonus (el) {
            // Recupero il record selezionato
            var selected = document.getElementsByClassName("selected");
            // Deve essere selezionato un record
            if (selected.length == 1) {
                var name = selected[0].childNodes[0].innerText;
                var delitem = function () {
                  ExecDeleteBonus(name);
                };
                show_confirmation_modal ("Confermi la cancellazione di: '" + name + "'?", delitem);
            } else {
                // Non è stato selezionato il record
                show_error('Seleziona un elemento');
            }
          }

          function ExecDeleteBonus (name) {
              fetch('php/delete_bonus.php', {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/json'
                  },
                  body: '{"nome" : "' + name + '"}'
              })
              .then(response => FetchBonus ())
              .catch(error => console.log("Errore in caricamento: " + error));
          }

          function CancelEditing () {
            $("#editForm").hide();
          }

          function SaveBonus () {
            var name = $("#frmItemNome").val();
            ExecSaveBonus(name);
            $("#editForm").hide();
          }

          function ExecSaveBonus (name) {
              fetch('php/insert_bonus.php', {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/json'
                  },
                  body: '{' +
                           '"nome" : "'                 +  $("#frmBonusNome").val()     + '",' + 
                           '"percorso" : "'             +  $("#frmBonusPercorso").val()    + '",' + 
                           '"potere_2p_nome" : "'       +  $("#frmBonus2PProp").val()      + '",' + 
                           '"potere_2p_valore" : "'     +  $("#frmBonus2PVal").val()       + '",' + 
                           '"potere_4p_nome" : "'       +  $("#frmBonus4PProp").val()      + '",' + 
                           '"potere_4p_valore" : "'     +  $("#frmBonus4PVal").val()       + '"' + 
                        '}' 
              })
              .then(response => FetchBonus ())
              .catch(error => console.log("Errore in caricamento: " + error));
          }

          function ResetForm () {
              $("#frmBonusNome").val("");
              $("#frmBonusPercorso").val("");
              $("#frmBonus2PProp").val("");
              $("#frmBonus2PVal").val("");
              $("#frmBonus4PProp").val("");
              $("#frmBonus4PVal").val("");
          }

        <?php }?>

  </script>

</body>

</html>
