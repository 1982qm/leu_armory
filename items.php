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
</head>

<script src="lib/jquery-3.5.1.min.js"></script>
<script src="lib/bootstrap.bundle.min.js"></script>
<script src="lib/md5.js"></script>
<script src="lib/select2.min.js"></script>
<script src="lib/select2.it.min.js"></script>
<script src="lib/datatables.min.js"></script>
<script src="lib/chart.js"></script>
<script src="js/make_chart.js"></script>
<script src="js/manageDT.js?1.0"></script>
<script src="js/common.js"></script>

<body>
  <main>
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
              <img src="img\items.svg" width="36px" height="36px" />
              <span style="padding-left: 15px;">Filtri</span>
          </div>
          <div id="filtersContainer" class="collapse show" style="font-size: 14px;">
            <form style="margin: 20px; display: flex; flex-wrap: wrap;">
              <div class="filterInputContainer">
                <label for="fItemNome" class="filterLabel">Nome:</label><br>
                <input type="text" id="fItemNome" name="fItemNome" class="filterValue">
              </div>
              <div class="filterInputContainer">
                <label for="fItemPercorso" class="filterLabel">Percorso:</label><br>
                <input type="text" id="fItemPercorso" name="fItemPercorso" class="filterValue">
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
    
    <div id="content" class="container-fluid px-4" style="display: none;top: 30px;position: relative;">
      <div class="card bg-dark text-white mb-4" style="opacity: 95%;">
          <div class="card-header d-flex align-items-center">
              <img src="img\items.svg" width="36px" height="36px" />
              <span id="datatableTitle" style="padding-left: 15px;">Items</span>
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
   
  </main>  

  <script>
        var json_poteri_speciali;
        $.getJSON("database/poteri_speciali.json", function (json) { json_poteri_speciali = json; });

        var json_spell_armi;
        $.getJSON("database/spell_armi.json", function (json) { json_spell_armi = json; });

        document.addEventListener("DOMContentLoaded", function () {
            CreateDataTable($("#datatableItems"), undefined, undefined, undefined);
            window.addEventListener('orientationchange', function (){
                var dtTable = $("#datatableItems").DataTable();
                dtTable.columns.adjust();
            });
            InitializeStep2();
            //FetchItems();
        })

        function InitializeStep2 () {
            $("#fItemSlot").select2({
              placeholder: "Seleziona gli slot...",
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
                    '  ,"percorso" : "' + $("#fItemPercorso").val() + '"' + 
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
                                                element.percorso,
                                                element.ac,
                                                element.arma,
                                                element.potere_1,
                                                element.potere_2,
                                                element.potere_3,
                                                element.potere_4,
                                                element.potere_5,
                                                element.potere_6,
                                                element.bonus_2p,
                                                element.bonus_4p
                                               ];
                                    },
                                    undefined
          );
          //table .column('5')
          //      .order('desc')
          //      .draw();
          
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

</script>

</body>

</html>
