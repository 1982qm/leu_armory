<!DOCTYPE HTML>
<html lang="it" data-bs-theme="dark">

<?php require("user_config.php"); 
      $isLoggedIn = isLoggedIn();
      if($isLoggedIn) {
        $user=$isLoggedIn;
        updateExpire($user['id']);
      } else {
        header('location:login.php');
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
                          <h5 class="text-white">Confermi?</h5>
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

    <div id="filters" class="container-fluid px-4" style="top: 30px; position: relative;">
      <div class="card bg-dark text-white mb-4" style="opacity: 95%;">
          <div class="card-header d-flex align-items-center">
              <img src="img\filter.svg" width="24px" height="24px" />
              <span style="padding-left: 15px;">Filtri</span>
              <a class="ms-auto p-2" href="#" data-bs-toggle="collapse" data-bs-target="#filtersContainer"
                  aria-expanded="true" aria-controls="filtersContainer">
                  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
              </a>
          </div>
          <div id="filtersContainer" class="collapse show" style="font-size: 14px;">
            <form style="margin: 20px; display: flex; flex-wrap: wrap;">
              <div class="filterInputContainer">
                <label for="fItemNome" class="filterLabel">Nome:</label><br>
                <input type="text" id="fItemNome" name="fItemNome" class="filterValue">
              </div>
              <div class="filterInputContainer">
                <label for="fItemPercorso" class="filterLabel">Percorso:</label><br>
                <div class="filterSelect">
                  <select id="fItemPercorso" name="fItemPercorso" multiple></select>
                </div>
              </div>
              <div class="filterInputContainer">
                <label for="fItemSlot" class="filterLabel">Slot:</label><br>
                <div class="filterSelect">
                  <select id="fItemSlot" name="fItemSlot" multiple>
                    <option value="Luce">Luce</option>
                    <option value="Dita">Dita</option>
                    <option value="Collo">Collo</option>
                    <option value="Corpo">Corpo</option>
                    <option value="Testa">Testa</option>
                    <option value="Gambe">Gambe</option>
                    <option value="Piedi">Piedi</option>
                    <option value="Mani">Mani</option>
                    <option value="Braccia">Braccia</option>
                    <option value="Scudo">Scudo</option>
                    <option value="Attorno">Attorno</option>
                    <option value="Vita">Vita</option>
                    <option value="Polso">Polso</option>
                    <option value="Impugnato,Arma,Arma Afferrato">Impugnato</option>
                    <option value="Afferrato,Arma Afferrato">Afferrato</option>
                    <option value="Schiena">Schiena</option>
                    <option value="Orecchie">Orecchie</option>
                    <option value="Viso">Viso</option>
                    <option value="Incoccato">Incoccato</option>
                    <option value="Aura">Aura</option>
                  </select>
                </div>
              </div>
              <div class="filterInputContainer">
                <label for="fItemPotere" class="filterLabel">Potere:</label><br>
                <input type="text" id="fItemPotere" name="fItemPotere" class="filterValue">
              </div>
            </form>
            <div class="filterInputContainer">
              <input type="submit" onclick="FetchItems()" class="btn btn-primary btm-sm filterButton" value="Cerca">
            </div>
          </div>
      </div>
    </div>
    
    <div id="content" class="container-fluid px-4" style="display: none; top: 30px;position: relative;">
      <div class="card bg-dark text-white mb-4" style="opacity: 95%;">
          <div class="card-header d-flex align-items-center">
              <img src="img\items.svg" width="36px" height="36px" />
              <span id="datatableTitle" style="padding-left: 15px;">Oggetti</span>
          </div>
          <div id="gridContainer" class="collapse show" style="font-size: 14px;">
              <div class="card-body">
                  <table id="datatableItems" class="table table-striped hover compact">
                      <thead>
                          <tr>
                              <th>Nome</th>
                              <th>Slot</th>
                              <th>Rarità</th>
                              <th>Percorso</th>
                              <th class="none">Ac</th>
                              <th class="none">Danni</th>
                              <th class="none">Potere 1</th>
                              <th class="none">Potere 2</th>
                              <th class="none">Potere 3</th>
                              <th class="none">Potere 4</th>
                              <th class="none">Potere 5</th>
                              <th class="none">Potere 6</th>
                              <th class="none">Bonus 2 pezzi</th>
                              <th class="none">Bonus 4 pezzi</th>
                          </tr>
                      </thead>
                      <tfoot>
                          <tr>
                              <th>Nome</th>
                              <th>Slot</th>
                              <th>Rarità</th>
                              <th>Percorso</th>
                              <th>Ac</th>
                              <th>Danni</th>
                              <th>Potere 1</th>
                              <th>Potere 2</th>
                              <th>Potere 3</th>
                              <th>Potere 4</th>
                              <th>Potere 5</th>
                              <th>Potere 6</th>
                              <th>Bonus 2 pezzi</th>
                              <th>Bonus 4 pezzi</th>
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
                <img src="img\items.svg" width="24px" height="24px" />
                <span id="formModificaTitle" style="padding-left: 15px;">Inserisci/Modifica</span>
            </div>
            <div id="formInputContainer" class="collapse show" style="font-size: 14px;">
              <form style="margin: 20px; display: flex; flex-wrap: wrap;">
                <!-- ident -->
                <div class="formInputContainer">
                  <label for="frmItemIdent" class="formLabel">Ident:</label><br>
                  <input type="text" id="frmItemIdent" name="frmItemIdent" class="formValue" placeholder="Incolla qui l'ident per il parsing...">
                </div>
                <!-- nome -->
                <div class="formInputContainer">
                  <label for="frmItemNome" class="formLabel">Nome:</label><br>
                  <input type="text" id="frmItemNome" name="frmItemNome" class="formValue" placeholder="Nome dell'oggetto">
                </div>
                <div class="formInputContainer" style="width: 410px !important">
                  <div style="width: 100%; display: flex">
                    <!-- slot -->
                    <div style="width: 50%">
                      <label for="frmItemSlot" class="formLabel" style="width: 100px !important">Slot:</label><br>
                      <div class="formSelect" style="width: 190px !important">
                        <select id="frmItemSlot" name="frmItemSlot">
                          <option value=""></option>
                          <option value="Luce">Luce</option>
                          <option value="Dita">Dita</option>
                          <option value="Collo">Collo</option>
                          <option value="Corpo">Corpo</option>
                          <option value="Testa">Testa</option>
                          <option value="Gambe">Gambe</option>
                          <option value="Piedi">Piedi</option>
                          <option value="Mani">Mani</option>
                          <option value="Braccia">Braccia</option>
                          <option value="Scudo">Scudo</option>
                          <option value="Attorno">Attorno</option>
                          <option value="Vita">Vita</option>
                          <option value="Polso">Polso</option>
                          <option value="Impugnato">Impugnato</option>
                          <option value="Arma">Arma</option>
                          <option value="Arma Afferrato">Arma Afferrato</option>
                          <option value="Afferrato">Afferrato</option>
                          <option value="Schiena">Schiena</option>
                          <option value="Orecchie">Orecchie</option>
                          <option value="Viso">Viso</option>
                          <option value="Incoccato">Incoccato</option>
                          <option value="Aura">Aura</option>
                        </select>
                      </div>
                    </div>
                    <div style="width: 50%">
                      <!-- rarita -->
                      <label for="frmItemRarita" class="formLabel" style="width: 100px !important">Rarità:</label><br>
                      <div class="formSelect" style="width: 190px !important">
                        <select id="frmItemRarita" name="frmItemRarita">
                          <option value=""></option>
                          <option value="Astrale">Astrale</option>
                          <option value="Comune">Comune</option>
                          <option value="Epico">Epico</option>
                          <option value="Leggendario">Leggendario</option>
                          <option value="Raro">Raro</option>
                          <option value="Set">Set</option>
                          <option value="Unico">Unico</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- percorso -->
                <div class="formInputContainer">
                  <label for="frmItemPercorso" class="formLabel">Percorso:</label><br>
                  <input type="text" id="frmItemPercorso" name="frmItemPercorso" class="formValue" style="width: 135px !important" placeholder="Nome">
                  <input type="text" id="frmItemLivPercorso" name="frmItemLivPercorso" class="formValue" style="width: 70px !important" placeholder="Livello">
                  <input type="text" id="frmItemLivPercorsoMax" name="frmItemLivPercorsoMax" class="formValue" style="width: 70px !important" placeholder="Liv. Max">
                  <input type="text" id="frmItemLimitato" name="frmItemLimitato" class="formValue" style="width: 70px !important" placeholder="Limitato">
                </div>
                <!-- bonus -->
                <div class="formInputContainer">
                  <label for="frmItemBonus" class="filterLabel">Bonus:</label><br>
                  <input type="text" id="frmItemBonus" name="frmItemBonus" class="formValue" placeholder="Nome del Bonus">
                </div>                
                <div class="formInputContainer">
                <!-- ac -->
                  <label for="frmItemAC" class="formLabel" style="white-space: preserve; width: 300px !important;">AC:      Danni Arma:</label><br>
                  <input type="text" id="frmItemAC" name="frmItemAC" class="formValue" style="width: 30px !important" placeholder="AC">
                <!-- arma -->
                  <input type="text" id="frmItemDadi" name="frmItemDadi" class="formValue" style="width: 60px !important" placeholder="Dadi">
                  <input type="text" id="frmItemTipoDanno" name="frmItemTipoDanno" class="formValue" style="width: 100px !important" placeholder="Tipo Danno">
                  <input type="text" id="frmItemPercFisico" name="frmItemPercFisico" class="formValue" style="width: 70px !important" placeholder="% Fisico">
                  <input type="text" id="frmItemPercMagico" name="frmItemPercMagico" class="formValue" style="width: 70px !important" placeholder="% Magico">
                </div>
                <!-- potere 1 -->
                <div class="formInputContainer">
                  <label for="frmItemPotere1" class="filterLabel">Potere 1:</label><br>
                  <input type="text" id="frmItemPotere1" name="frmItemPotere1" class="formValue" style="width: 122px !important" placeholder="Tipo">
                  <input type="text" id="frmItemPotere1_nome" name="frmItemPotere1_nome" class="formValue" style="width: 182px !important" placeholder="Nome">
                  <input type="text" id="frmItemPotere1_val" name="frmItemPotere1_val" class="formValue" style="width: 60px !important" placeholder="Valore">
                </div>
                <!-- potere 2 -->
                <div class="formInputContainer">
                  <label for="frmItemPotere2" class="filterLabel">Potere 2:</label><br>
                  <input type="text" id="frmItemPotere2" name="frmItemPotere2" class="formValue" style="width: 122px !important" placeholder="Tipo">
                  <input type="text" id="frmItemPotere2_nome" name="frmItemPotere2_nome" class="formValue" style="width: 182px !important" placeholder="Nome">
                  <input type="text" id="frmItemPotere2_val" name="frmItemPotere2_val" class="formValue" style="width: 60px !important" placeholder="Valore">
                </div>
                <!-- potere 3 -->
                <div class="formInputContainer">
                  <label for="frmItemPotere3" class="filterLabel">Potere 3:</label><br>
                  <input type="text" id="frmItemPotere3" name="frmItemPotere3" class="formValue" style="width: 122px !important" placeholder="Tipo">
                  <input type="text" id="frmItemPotere3_nome" name="frmItemPotere3_nome" class="formValue" style="width: 182px !important" placeholder="Nome">
                  <input type="text" id="frmItemPotere3_val" name="frmItemPotere3_val" class="formValue" style="width: 60px !important" placeholder="Valore">
                </div>
                <!-- potere 4 -->
                <div class="formInputContainer">
                  <label for="frmItemPotere4" class="filterLabel">Potere 4:</label><br>
                  <input type="text" id="frmItemPotere4" name="frmItemPotere4" class="formValue" style="width: 122px !important" placeholder="Tipo">
                  <input type="text" id="frmItemPotere4_nome" name="frmItemPotere4_nome" class="formValue" style="width: 182px !important" placeholder="Nome">
                  <input type="text" id="frmItemPotere4_val" name="frmItemPotere4_val" class="formValue" style="width: 60px !important" placeholder="Valore">
                </div>
                <!-- potere 5 -->
                <div class="formInputContainer">
                  <label for="frmItemPotere5" class="filterLabel">Potere 5:</label><br>
                  <input type="text" id="frmItemPotere5" name="frmItemPotere5" class="formValue" style="width: 122px !important" placeholder="Tipo">
                  <input type="text" id="frmItemPotere5_nome" name="frmItemPotere5_nome" class="formValue" style="width: 182px !important" placeholder="Nome">
                  <input type="text" id="frmItemPotere5_val" name="frmItemPotere5_val" class="formValue" style="width: 60px !important" placeholder="Valore">
                </div>
                <!-- potere 6 -->
                <div class="formInputContainer">
                  <label for="frmItemPotere6" class="filterLabel">Potere 6:</label><br>
                  <input type="text" id="frmItemPotere6" name="frmItemPotere6" class="formValue" style="width: 122px !important" placeholder="Tipo">
                  <input type="text" id="frmItemPotere6_nome" name="frmItemPotere6_nome" class="formValue" style="width: 182px !important" placeholder="Nome">
                  <input type="text" id="frmItemPotere6_val" name="frmItemPotere6_val" class="formValue" style="width: 60px !important" placeholder="Valore">
                </div>
              </form>
              <div class="formInputContainer">
                <input type="submit" onclick="SaveItem()" class="btn btn-success btm-sm formButton" value="Salva">
                <input type="submit" onclick="CancelEditing()" class="btn btn-secondary btm-sm formButton" value="Annulla">
              </div>
            </div>
        </div>
      </div> 
      <!-- Form di inserimento / modifica - fine -->
    <?php } ?>
  </main>  

  <script>
        var json_poteri_speciali;
        $.getJSON("database/poteri_speciali.json", function (json) { json_poteri_speciali = json; });

        var json_spell_armi;
        $.getJSON("database/spell_armi.json", function (json) { json_spell_armi = json; });

        document.addEventListener("DOMContentLoaded", function () {
            CreateDataTable($("#datatableItems"),
                              <?php if ($isLoggedIn && $user['user_type'] == "1") {?>
                                'Aggiungi', AddItem, 'Modifica', EditItem, 'Elimina', DeleteItem
                              <?php } ?>
                            );
            window.addEventListener('orientationchange', function (){
                var dtTable = $("#datatableItems").DataTable();
                dtTable.columns.adjust();
            });
            $("#fItemSlot").select2({
              placeholder: "Seleziona gli slot...",
              language: "it"
            });
            
            <?php if ($isLoggedIn && $user['user_type'] == "1") {?>
              $("#frmItemSlot").select2({
                placeholder: "Seleziona lo slot...",
                language: "it"
              });
              $("#frmItemRarita").select2({
                placeholder: "Seleziona la rarità...",
                language: "it"
              });
            <?php } ?>
            FetchItemsPercorsi();
            //Gestione dell'enter sui filtri di tipo text
            CatchKeypress("fItemNome",13,FetchItems);
            CatchKeypress("fItemPotere",13,FetchItems);
        })

        function FetchItemsPercorsi () {
          fetch('php/load_items_percorsi.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json'
              }
          })
          .then(response => response.json())
          .then(data => LoadItemsPercorsi(data))
          .catch(error => console.log("Errore in caricamento: " + error));
        }

        function LoadItemsPercorsi (data) {
          data.forEach(
              element => {
                  // Aggiungo la riga alla lista
                  var opt = document.createElement ("option");
                  $(opt).val(element.percorso);
                  $(opt).text(element.percorso);
                  $("#fItemPercorso").append(opt);
              }
          );
          $("#fItemPercorso").select2({
            placeholder: "Seleziona i percorsi...",
            language: "it"
          });
        }

        function FetchItems () {
          document.getElementById("loadingDiv").style.display = "block";
          fetch('php/load_items.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json'
              },
              body: '{  "nome" : "' + $("#fItemNome").val() + '"' + 
                    '  ,"percorso" : "' + $("#fItemPercorso").val().toString() + '"' + 
                    '  ,"slot" : "' + $("#fItemSlot").val().toString() + '"' + 
                    '  ,"potere" : "' + $("#fItemPotere").val() + '"' + 
                    '}'
          })
          .then(response => response.json())
          .then(data => LoadItems(data))
          .catch(error => console.log("Errore in caricamento: " + error));
        }

        function LoadItems (data) {
          var table = LoadDataTable($("#datatableItems"),
                                    data,
                                    function (element) {
                                        return [element.nome,
                                                element.slot,
                                                element.rarita,
                                                getPercorso(element.percorso,element.livello_percorso,element.livello_percorso_max),
                                                element.ac,
                                                getDannoArma(element.dadi, element.tipo_danno, element.perc_fisico, element.perc_magico),
                                                getPower(element.potere_1_tipo, element.potere_1_nome, element.potere_1_valore),
                                                getPower(element.potere_2_tipo, element.potere_2_nome, element.potere_2_valore),
                                                getPower(element.potere_3_tipo, element.potere_3_nome, element.potere_3_valore),
                                                getPower(element.potere_4_tipo, element.potere_4_nome, element.potere_4_valore),
                                                getPower(element.potere_5_tipo, element.potere_5_nome, element.potere_5_valore),
                                                getPower(element.potere_6_tipo, element.potere_6_nome, element.potere_6_valore),
                                                getBonus(element.bonus_nome, element.bonus_2p_nome, element.bonus_2p_valore),
                                                getBonus(element.bonus_nome, element.bonus_4p_nome, element.bonus_4p_valore)
                                               ];
                                    },
                                    undefined
          );
          
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

          setTimeout(() => {
            document.getElementById("loadingDiv").style.display = "none";
            document.getElementById("content").style.display = "block";
          }, 300);
        }

        function getPercorso (percorso, livello_percorso, livello_percorso_max) {
          return (percorso + ' (' + livello_percorso + '/' + livello_percorso_max + ')');
        }

        function getDannoArma (dadi, tipo_danno, perc_fisico, perc_magico) {
          if (dadi != undefined && dadi.length > 0) {
            var dice = dadi.toString().split("D");
            var media = ((parseFloat(isNull(dice[0],'0')) * parseFloat(isNull(dice[1],'0')) + parseFloat(isNull(dice[0],'0')))/2);
            return (dadi + ' (media ' + media + ') di tipologia ' + tipo_danno + ", %" + perc_fisico + ' danno fisico, %' + perc_magico + ' potere magico');
          } else {
            return "";
          }
        }        

        function getPower (tipo, nome, valore) {
          var out = "";
          if (tipo != undefined && tipo.length > 0) {
            out = '[' + tipo + '] ';
            if (valore != undefined && valore.length > 0) {
              out += '+' + valore + ' ' + nome;
            } else {
              out += nome;
            }
          }

          return out;
        }

        function getBonus (bonus, nome, valore) {
          if (valore != undefined && valore.length > 0) {
            return ("+" + valore + " " + nome);
          } else {
            return "";
          }
        }        

        <?php if ($isLoggedIn && $user['user_type'] == "1") {?>
          function AddItem (el) {
            console.log("AddItem");
            console.log(el);
            $("#formModificaTitle").text("Aggiungi Oggetto");
            $("#editForm").show();
            // Scrollo la pagina sulla form
            document.getElementById("editForm").scrollIntoView();          
          }

          function EditItem (el) {
            // Recupero il record selezionato
            var selected = document.getElementsByClassName("selected");
            // Deve essere selezionato un record
            if (selected.length == 1) {
              console.log("EditItem");
              console.log(el);
              $("#formModificaTitle").text("Modifica Oggetto");
              $("#editForm").show();
              // Scrollo la pagina sulla form
              document.getElementById("editForm").scrollIntoView();
            } else {
                // Non è stato selezionato il record
                show_error('Seleziona un elemento');
            }          
          }

          function DeleteItem (el) {
            // Recupero il record selezionato
            var selected = document.getElementsByClassName("selected");
            // Deve essere selezionato un record
            if (selected.length == 1) {
                var delitem = function () {
                  console.log("Cancellare l'item");
                };
                show_confirmation_modal (delitem);
                console.log("DeleteItem");
                console.log(el);
            } else {
                // Non è stato selezionato il record
                show_error('Seleziona un elemento');
            }          
          }

          function CancelEditing () {
            console.log("CancelEditing");
            $("#editForm").hide();
          }

          function SaveItem () {
            console.log("SaveItem");
          }
        <?php }?>

  </script>

</body>

</html>
