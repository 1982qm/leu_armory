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
    <div id="loadingDiv" class="modal">
      <div id="loadingDivContent" class="modal-content">
          <center>
              <img src="img/loading.gif"/><span style="position:relative; padding:20px;">Caricamento in corso...</span>
          </center>
      </div>
    </div>
        
    <div id="content" class="container-fluid px-4" style="display: none;top: 30px;position: relative;">
      <div class="card bg-dark text-white mb-4" style="opacity: 95%;">
          <div class="card-header d-flex align-items-center">
              <img src="img\players.svg" width="36px" height="36px" />
              <span id="datatableTitle" style="padding-left: 15px;">Players</span>
              <div id="compareToDiv" style="right: 20px; position: absolute; width: 17rem; display:none">
                <select id="compareToSelect" style="width: 100%;" onchange="ComparePlayer()"></select>
              </div>
          </div>
          <div id="gridContainer" class="collapse show" style="font-size: 14px;">
              <div class="card-body">
                  <table id="datatablePlayers" class="table table-striped hover compact dt-tables">
                      <thead>
                          <tr>
                              <th>Nome</th>
                              <th>Classe</th>
                              <th>Livello Medio Eq</th>
                              <th>Data Caricamento</th>
                          </tr>
                      </thead>
                      <tfoot>
                          <tr>
                              <th>Nome</th>
                              <th>Classe</th>
                              <th>Livello Medio Eq</th>
                              <th>Data Caricamento</th>
                          </tr>                          
                      </tfoot>
                      <tbody></tbody>
                  </table>
              </div>
          </div>
      </div>
    </div>

    <div id="player" class="container-fluid px-4" style="top: 30px;position: relative; display: none;">
      <a href="#" class="close" onclick="javascript:$('#compareToDiv').hide();$('#player').hide();$('#gridContainer').show();"></a>
      <div class="card bg-dark text-white mb-4" style="opacity: 97%; min-height: 750px;">
          <div id="playerContainer" class="collapse show">
              <div class="card-body" style="display: flex;">

                <!-- PG -->
                <div class="card" style="width: 20rem; border: 0px; background: linear-gradient(black, transparent 70%); margin-left: 10px;">
                  <div class="card-body" style="z-index: 1; max-height: calc(100dvh - 150px);">
                    <h3 id="playerName" class="card-title" style="text-shadow: 2px 2px 4px black;"></h3>
                    <h5 id="className" class="card-title"></h5>
                    <h3 id="avg_eq_level" class="card-title" style="position: absolute; color: #00FE1E; top: 15px; right: 20px; text-shadow: 1px 1px 2px black;"></h3>
                    <div style="height: 430px; width: auto; margin-top: -60px; margin-bottom: 90px; align-content: center;" >
                      <img id="classImg" class="card-img-top" style="scale: 80%;">
                    </div>

                    <?php if ($isLoggedIn && $user['user_type'] == "1") { ?>
                      <!-- Personalizza immagine -->
                      <form id="uploadForm" enctype="multipart/form-data" style="width: auto;position: absolute;top: 60px; right: 15px;">
                          <!-- input file nascosto -->
                          <input type="file"
                              id="image"
                              name="image"
                              accept="image/png"
                              style="display:none;">

                          <!-- bottone di reset -->
                          <button type="button" id="resetBtn" class="upload-btn" onclick="resetImg()">
                              <img src="img/reset.svg" title="Torna all'immagine di default"/>
                          </button>

                          <!-- bottone di upload -->
                          <button type="button" id="uploadBtn" class="upload-btn">
                              <img src="img/edit.svg" title="Personalizza immagine"/>
                          </button>
                      </form>
                    <?php } ?>
                    
                    <div class="chart_player" style="top:-90px">
                      <canvas id="chart_stat" style="width: 300px; height:300px"></canvas>
                    </div>
                  </div>
                </div>

                <!-- STATISTICHE -->
                <div class="card" style="width: 18rem; border: 0px; margin-left: 10px;">
                  <div class="card-body">
                    <h5 class="card-title" style="text-shadow: 1px 1px 2px black;">Statistiche</h5>
                    <ul id="listaStats" class="list-group list-group-flush">
                      <li class="list-group-item list"><div class="info"><span class="stat">Razza</span><span id="razza" class="number_value"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><div class="info"><span class="stat">HP </span><span id="hp" class="number_value"></span></div></li>
                      <li class="list-group-item list"><div class="info"><span class="stat">Mana</span><span id="mana" class="number_value"></span></div></li>
                      <li class="list-group-item list"><div class="info"><span class="stat">Energia</span><span id="energia" class="number_value"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><div class="info"><span class="stat">Danno Fisico</span><span id="danno_fisico" class="number_value"></span></div></li>
                      <li class="list-group-item list"><div class="info"><span class="stat">Potere Magico</span><span id="potere_magico" class="number_value"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><div class="info"><span class="stat">Forza</span><span id="forza" class="number_value"></span></div></li>
                      <li class="list-group-item list"><div class="info"><span class="stat">Intelligenza</span><span id="intelligenza" class="number_value"></span></div></li>
                      <li class="list-group-item list"><div class="info"><span class="stat">Saggezza</span><span id="saggezza" class="number_value"></span></div></li>
                      <li class="list-group-item list"><div class="info"><span class="stat">Destrezza</span><span id="destrezza" class="number_value"></span></div></li>
                      <li class="list-group-item list"><div class="info"><span class="stat">Costituzione</span><span id="costituzione" class="number_value"></span></div></li>
                      <li class="list-group-item list"><div class="info"><span class="stat">Carisma</span><span id="carisma" class="number_value"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                    </ul>
                  </div>
                </div>

                <!-- EQUIPAGGIAMENTO -->
                <div class="card" style="min-width: 18rem; width: max-content; border: 0px; margin-left: 10px;">
                  <div class="card-body">
                    <h5 class="card-title" style="text-shadow: 1px 1px 2px black;">Equipaggiamento<span id="oggettiLimitati">Oggetti limitati <span id="oggettiLimitatiMin"></span>/<span id="oggettiLimitatiMax"></span></span></h5>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item list"><div class="eqrow"><span class="slot">come luce</span><span id="come_luce" class="eq"></span></div></li>
                      <li class="list-group-item list"><div class="eqrow"><span class="slot">mano destra</span><span id="mano_destra" class="eq"></span></div></li>
                      <li class="list-group-item list"><div class="eqrow"><span class="slot">mano sinistra</span><span id="mano_sinistra" class="eq"></span></div></li>
                      <li class="list-group-item list"><div class="eqrow"><span class="slot">al collo</span><span id="al_collo_1" class="eq"></span></div></li>
                      <li class="list-group-item list"><div class="eqrow"><span class="slot">al collo</span><span id="al_collo_2" class="eq"></span></div></li>
                      <li class="list-group-item list"><div class="eqrow"><span class="slot">sul corpo</span><span id="sul_corpo" class="eq"></span></div></li>
                      <li class="list-group-item list"><div class="eqrow"><span class="slot">in testa</span><span id="in_testa" class="eq"></span></div></li>
                      <li class="list-group-item list"><div class="eqrow"><span class="slot">sulle gambe</span><span id="sulle_gambe" class="eq"></span></div></li>
                      <li class="list-group-item list"><div class="eqrow"><span class="slot">ai piedi</span><span id="ai_piedi" class="eq"></span></div></li>
                      <li class="list-group-item list"><div class="eqrow"><span class="slot">sule mani</span><span id="sulle_mani" class="eq"></span></div></li>
                      <li class="list-group-item list"><div class="eqrow"><span class="slot">sulle braccia</span><span id="sulle_braccia" class="eq"></span></div></li>
                      <li class="list-group-item list"><div class="eqrow"><span class="slot">come scudo</span><span id="come_scudo" class="eq"></span></div></li>
                      <li class="list-group-item list"><div class="eqrow"><span class="slot">attorno al corpo</span><span id="attorno_al_corpo" class="eq"></span></div></li>
                      <li class="list-group-item list"><div class="eqrow"><span class="slot">alla vita</span><span id="alla_vita" class="eq"></span></div></li>
                      <li class="list-group-item list"><div class="eqrow"><span class="slot">polso destro</span><span id="polso_destro" class="eq"></span></div></li>
                      <li class="list-group-item list"><div class="eqrow"><span class="slot">polso sinistro</span><span id="polso_sinistro" class="eq"></span></div></li>
                      <li class="list-group-item list"><div class="eqrow"><span class="slot">impugnato</span><span id="impugnato" class="eq"></span></div></li>
                      <li class="list-group-item list"><div class="eqrow"><span class="slot">afferrato</span><span id="afferrato" class="eq"></span></div></li>
                      <li class="list-group-item list"><div class="eqrow"><span class="slot">sulla schiena</span><span id="sulla_schiena" class="eq"></span></div></li>
                      <li class="list-group-item list"><div class="eqrow"><span class="slot">orecchio destro</span><span id="orecchio_destro" class="eq"></span></div></li>
                      <li class="list-group-item list"><div class="eqrow"><span class="slot">orecchio sinistro</span><span id="orecchio_sinistro" class="eq"></span></div></li>
                      <li class="list-group-item list"><div class="eqrow"><span class="slot">sul viso</span><span id="sul_viso" class="eq"></span></div></li>
                      <li class="list-group-item list"><div class="eqrow"><span class="slot">incoccato</span><span id="incoccato" class="eq"></span></div></li>
                      <li class="list-group-item list"><div class="eqrow"><span class="slot">come aura</span><span id="come_aura" class="eq"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                    </ul>
                  </div>
                </div>

                <div class="card" style="width: 18rem; border: 0px; margin-left: 10px;">
                  <div class="card-body">
                    <!-- RESISTENZE -->
                    <h5 class="card-title" style="text-shadow: 1px 1px 2px black;">Resistenze</h5>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item list"><div class="info"><span class="resi">Assorbimento Fisico</span><span id="ass_fisico" class="number_value"></span></div></li>
                      <li class="list-group-item list"><div class="info"><span class="resi">Assorbimento Magico</span><span id="ass_magico" class="number_value"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><div class="info"><span class="resi">Impatto</span><span id="res_impatto" class="number_value"></span></div></li>
                      <li class="list-group-item list"><div class="info"><span class="resi">Perforazione</span><span id="res_perforazione" class="number_value"></span></div></li>
                      <li class="list-group-item list"><div class="info"><span class="resi">Taglio</span><span id="res_taglio" class="number_value"></span></div></li>
                      <li class="list-group-item list"><div class="info"><span class="resi">Trauma</span><span id="res_trauma" class="number_value"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><div class="info"><span class="resi">Fuoco</span><span id="res_fuoco" class="number_value"></span></div></li>
                      <li class="list-group-item list"><div class="info"><span class="resi">Freddo</span><span id="res_freddo" class="number_value"></span></div></li>
                      <li class="list-group-item list"><div class="info"><span class="resi">Elettricità</span><span id="res_elettricita" class="number_value"></span></div></li>
                      <li class="list-group-item list"><div class="info"><span class="resi">Acido</span><span id="res_acido" class="number_value"></span></div></li>
                      <li class="list-group-item list"><div class="info"><span class="resi">Energia</span><span id="res_energia" class="number_value"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><div class="info"><span class="resi">Natura</span><span id="res_natura" class="number_value"></span></div></li>
                      <li class="list-group-item list"><div class="info"><span class="resi">Psichico</span><span id="res_psichico" class="number_value"></span></div></li>
                      <li class="list-group-item list"><div class="info"><span class="resi">Lumen</span><span id="res_lumen" class="number_value"></span></div></li>
                      <li class="list-group-item list"><div class="info"><span class="resi">Umbra</span><span id="res_umbra" class="number_value"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><div class="info"><span class="resi">Caos</span><span id="res_caos" class="number_value"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                    </ul>
                  </div>
                </div>

                <div class="card" style="min-width: 18rem; width: max-content; border: 0px; margin-left: 10px;">
                  <div class="card-body">
                    <!-- ATTACCHI -->
                    <h5 class="card-title" style="text-shadow: 1px 1px 2px black;">Attacchi</h5>
                    <ul id="listaAttacchi" class="list-group list-group-flush">
                      <li class="list-group-item list"><div class="info"><span class="resi">Numero attacchi</span><span id="num_attacks" class="number_value"></span></div></li>
                      <li class="list-group-item list"><div class="info"><span class="resi">Chance di critico</span><span id="crit_chance" class="number_value"></span></div></li>
                      <li class="list-group-item list"><div class="info"><span class="resi" style="white-space: pre">Moltiplicatore</span><span id="crit_molt" class="number_value"></span></div></li>
                    </ul>
                    <!-- BONUS -->
                    <h5 class="card-title" style="text-shadow: 1px 1px 2px black;">Bonus Attivi</h5>
                    <ul id="listaBonus" class="list-group list-group-flush">
                    </ul>
                  </div>
                </div>

              </div>
          </div>
      </div>
    </div>
    
  </main>  

  <script>
        var optgroupState;
        var chart_stat;
        var json_p1;

        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var input_name = urlParams.get('name');

        var json_poteri_speciali;
        $.getJSON("database/poteri_speciali.json", function (json) { json_poteri_speciali = json; });

        var json_spell_armi;
        $.getJSON("database/spell_armi.json", function (json) { json_spell_armi = json; });

        //PRELOAD
        var images = [];

        function preload() {
          for (var i = 0; i < arguments.length; i++) {
            images[i] = new Image();
            images[i].src = preload.arguments[i];
          }
        }

        preload (
          "/armory/img/barbaro.png",
          "/armory/img/chierico.png",
          "/armory/img/druido.png",
          "/armory/img/guerriero.png",
          "/armory/img/ladro.png",
          "/armory/img/mago.png",
          "/armory/img/monaco.png",
          "/armory/img/paladino.png",
          "/armory/img/psionico.png",
          "/armory/img/ranger.png",
          "/armory/img/arcanista.png",
          "/armory/img/asceta.png",
          "/armory/img/condottiero.png",
          "/armory/img/errante.png",
          "/armory/img/illusionista.png",
          "/armory/img/mistificatore.png",
          "/armory/img/schermidore.png",
          "/armory/img/templare.png",
          "/armory/img/players.svg",
          "/armory/img/background.jpg"
        )

        $(document).ready(function() {
            Chart.defaults.font.family = "'DejaVu Sans Mono', monospace";
            Chart.defaults.color = "#fff";
            if(input_name) input_name = input_name.toString().replace(/"/g,"");
            InitImgBtn();
            var initComplete = function (dt) {
                window.addEventListener('orientationchange', function (){
                    var dtTable = $("#datatablePlayers").DataTable();
                    dtTable.columns.adjust();
                });
                FetchPlayers();
            };
            CreateDataTable($("#datatablePlayers"), initComplete);
        })

        function FetchPlayers () {
          fetch('php/load_players.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json'
              }
          })
          .then(response => response.json())
          .then(data => LoadPlayers(data))
          .catch(error => console.log("Errore in caricamento: " + error));
        }

        function LoadPlayers (data) {
          var table = LoadDataTable($("#datatablePlayers"),
                                    data,
                                    function (element) {
                                        return [element.titolo, element.classe, element.avg_eq_level, element.data_caricamento];
                                    },
                                    ShowPlayer, //click function
                                    false, //selectable
                                    '2;desc' //ordinamento
          );

          setTimeout(() => {
            $(".dt-search").parent().css("position","absolute");
            $(".dt-search").parent().css("top","-72px");
            $(".dt-search").parent().css("right","10px");
            $(".dt-search").parent().css("font-size","14px");
            $(".dt-search input").css("border-color","#464D54");
            window.addEventListener('orientationchange', function (){
                var dtTable = $("#datatablePlayers").DataTable();
                dtTable.columns.adjust();
            });
            LoadPlayersToCompare(data);
            document.getElementById("loadingDiv").style.display = "none";
            document.getElementById("content").style.display = "block";
            if (input_name) FetchPlayerDetailsByName(input_name);
          }, 300);
        }

        function LoadPlayersToCompare (data) {
          var actual_class = "";
          var class_group;

          var def1 = document.createElement("option");
          document.getElementById("compareToSelect").appendChild(def1);

          data.forEach( 
              element => {
                  if (actual_class != element.classe) {
                    actual_class = element.classe;
                    class_group = document.createElement("optgroup");
                    $(class_group).attr("label", element.classe);
                    document.getElementById("compareToSelect").appendChild(class_group);
                  }

                  var option = document.createElement("option");
                  option.classList.add("pg_name");
                  option.innerText = element.nome;
                  $(option).css("cursor", "pointer");

                  class_group.appendChild(option);
              }
            )

            optgroupState = {};

            InitializeStep2();

            $("body").on('click', '.select2-container--open .select2-results__group', function() {
              $(this).siblings().toggle();
              let id = $(this).closest('.select2-results__options').attr('id');
              let index = $('.select2-results__group').index(this);
              optgroupState[id][index] = !optgroupState[id][index];
            })
        }

        function InitializeStep2 () {
            $("#compareToSelect").select2({
              placeholder: "Confronta con...",
              language: "it"
            });

            $('#compareToSelect').on('select2:open', function() {
              $('.select2-dropdown--below').css('opacity', 0);
              setTimeout(() => {
                let groups = $('.select2-container--open .select2-results__group');
                let id = $('.select2-results__options').attr('id');
                if (!optgroupState[id]) {
                  optgroupState[id] = {};
                }
                $.each(groups, (index, v) => {
                  optgroupState[id][index] = optgroupState[id][index] || false;
                  optgroupState[id][index] ? $(v).siblings().show() : $(v).siblings().hide();
                })
                $('.select2-dropdown--below').css('opacity', 1);
              }, 0);
            })
        }

        function ComparePlayer () {
          var nome_p2 = $('#compareToSelect').find(":selected").text();
          var nome_p1 = $("#playerName").text();
          var url = location.origin+location.pathname;
          url=url.replaceAll("players.php","");
          url=url+'compare.php?p1="'+nome_p1+'"&p2="'+nome_p2+'"';
          window.location.href = url;
        }

        function ShowPlayer (tr) {
          nome=$(tr).find("td").eq(0).text();
          FetchPlayerDetails(nome);
        }

        function FetchPlayerDetails (nome) {
          fetch('php/load_player_details_by_title.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json'
              },
              body: '{"nome" : "' + nome + '"}'
          })
          .then(response => response.json())
          .then(data => LoadPlayerDetails(data))
          .catch(error => console.log("Errore in caricamento: " + error));
        }

        function FetchPlayerDetailsByName (nome) {
          fetch('php/load_player_details_by_name.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json'
              },
              body: '{"nome" : "' + nome + '"}'
          })
          .then(response => response.json())
          .then(data => LoadPlayerDetails(data))
          .catch(error => console.log("Errore in caricamento: " + error));
        }        

        function LoadPlayerDetails (data) {
          $('.dynamic-generated').remove();

          var json = JSON.parse(data.json);
          json_p1 = json;

          <?php if ($isLoggedIn && $user['user_type'] == "1") {?>
            console.log(json);
          <?php } ?>

          setText("playerName", json.player.nome);
          setText("avg_eq_level", json.player.avg_eq_level);

          // Disabilito il nome dalla lista dei compare
          $('#compareToSelect option').removeAttr('disabled');
          $('#compareToSelect option').css("cursor", "pointer");
          opt = $('#compareToSelect option').filter(function () { return $(this).text() == json.player.nome; });
          $(opt[0]).attr("disabled", true);
          $(opt[0]).css("cursor", "default");
          $("#compareToDiv").show();

          if(json.player.classe != undefined) {
              if(json.player.main_class != undefined && json.player.main_class != "Nessuna") {
                setText("className", json.player.classe + ' (' + json.player.main_class + ')');
              } else {
                setText("className", json.player.classe);
              }
          }

          setPlayerImg(json, data.custom_image_path,"classImg");

          setText("razza", json.player.razza);
          setText("hp", json.player.hp);
          setText("mana", json.player.mana);
          setText("energia", json.player.energia);
          setText("danno_fisico", json.player.dannoFisico);
          setText("potere_magico", json.player.potereMagico);          
          setText("forza", json.player.forza);
          setText("intelligenza", json.player.intelligenza);
          setText("saggezza", json.player.saggezza);
          setText("destrezza", json.player.destrezza);
          setText("costituzione", json.player.costituzione);
          setText("carisma", json.player.carisma);
          setText("oggettiLimitatiMin", json.player.oggLimitati);
          setText("oggettiLimitatiMax", json.player.oggLimitatiMax);

          if (json.player.oggLimitati != undefined) {
            $("#oggettiLimitati").show();
          } else {
            $("#oggettiLimitati").hide();
          }

          // ATTACCHI
          setText("crit_chance", json.player.critico_chance,"%");
          setText("crit_molt", json.player.critico_moltiplicatore,"%");
          setText("num_attacks", json.player.num_attacchi);

          if (json.attacks != undefined && json.attacks.length > 0) {
              var primaria = false;
              var secondaria = false;
              var tipologia;
              var media_princ = 0;
              var media_sec = 0;
              json.attacks.forEach(
                    element => {
                      if ((element.tipologia != undefined && element.tipologia == "Secondaria") || (element.tipologia == undefined && element.perc != undefined)) {
                        tipologia = "Secondaria";
                        media_sec += parseFloat(element.media);
                      } else {
                        tipologia = "Primaria";
                        media_princ += parseFloat(element.media);
                      }

                      if ((tipologia == "Secondaria" && !secondaria) || (tipologia == "Primaria" && !primaria)) {
                          var li = document.createElement("li");
                          var div = document.createElement("div");
                          var span1 = document.createElement("span");
                          var span2 = document.createElement("span");
                          span2.id = "media_arma_"+tipologia;

                          if (tipologia == "Secondaria") {
                            span1.innerText = "Arma Secondaria";
                            secondaria = true;
                          } else {
                            span1.innerText = "Arma Primaria";
                            primaria = true;
                          }

                          //span2.innerText = element.media;

                          li.classList.add("list-group-item", "list", "dynamic-generated");
                          div.classList.add("info");
                          span1.classList.add("stat");
                          span2.classList.add("number_value");

                          li.appendChild(div);
                          div.appendChild(span1);
                          div.appendChild(span2);

                          document.getElementById("listaAttacchi").appendChild(li);
                        }
                      }
              )

              if (media_princ > 0) $("#media_arma_Primaria").text(media_princ);
              if (media_sec > 0) $("#media_arma_Secondaria").text(media_sec);
          }

          // Alla fine aggiunto un separatore
          var li = document.createElement("li");
          li.classList.add("list-group-item", "list", "separatore", "dynamic-generated");
          document.getElementById("listaAttacchi").appendChild(li);

          // STATISTICHE
          if (json.statistiche != undefined && json.statistiche.length > 0) {
              json.statistiche.forEach(
                    element => {
                      if (!element.nome.startsWith("Resistenza")) {
                        var li = document.createElement("li");
                        var div = document.createElement("div");
                        var span1 = document.createElement("span");
                        var span2 = document.createElement("span");

                        li.classList.add("list-group-item", "list", "dynamic-generated");
                        div.classList.add("info");
                        span1.classList.add("stat");
                        span2.classList.add("number_value");

                        span1.innerText = element.nome;
                        span2.innerText = element.valore;

                        li.appendChild(div);
                        div.appendChild(span1);
                        div.appendChild(span2);

                        document.getElementById("listaStats").appendChild(li);
                      }
                    }
              )
              // Alla fine aggiunto un separatore
              var li = document.createElement("li");
              li.classList.add("list-group-item", "list", "separatore", "dynamic-generated");
              document.getElementById("listaStats").appendChild(li);
          }

          // BONUS
          if (json.bonus != undefined && json.bonus.length > 0) {
              json.bonus.forEach(
                    element => {
                        var li_name = document.createElement("li");
                        var div_name = document.createElement("div");
                        var span_name = document.createElement("span");

                        li_name.classList.add("list-group-item", "list", "dynamic-generated");
                        div_name.classList.add("info");
                        span_name.classList.add("set_name");

                        span_name.innerText = element.nome;

                        li_name.appendChild(div_name);
                        div_name.appendChild(span_name);

                        document.getElementById("listaBonus").appendChild(li_name);

                        //2 Pezzi
                        if (element.p2 != undefined && element.p2.length > 0) {
                          var li_2p = document.createElement("li");
                          var div_2p = document.createElement("div");
                          var span1_2p = document.createElement("span");
                          var span2_2p = document.createElement("span");

                          li_2p.classList.add("list-group-item", "list", "dynamic-generated");
                          div_2p.classList.add("info");
                          span1_2p.classList.add("set_pieces");
                          span2_2p.classList.add("number_value");

                          span1_2p.innerText = "(2 pezzi)";
                          span2_2p.innerText = element.p2;

                          li_2p.appendChild(div_2p);
                          div_2p.appendChild(span1_2p);
                          div_2p.appendChild(span2_2p);
                          
                          document.getElementById("listaBonus").appendChild(li_2p);
                        }

                        //4 Pezzi
                        if (element.p4 != undefined && element.p4.length > 0) {
                          var li_4p = document.createElement("li");
                          var div_4p = document.createElement("div");
                          var span1_4p = document.createElement("span");
                          var span2_4p = document.createElement("span");

                          li_4p.classList.add("list-group-item", "list", "dynamic-generated");
                          div_4p.classList.add("info");
                          span1_4p.classList.add("set_pieces");
                          span2_4p.classList.add("number_value");

                          span1_4p.innerText = "(4 pezzi)";
                          span2_4p.innerText = element.p4;

                          li_4p.appendChild(div_4p);
                          div_4p.appendChild(span1_4p);
                          div_4p.appendChild(span2_4p);
                          
                          document.getElementById("listaBonus").appendChild(li_4p);
                        }                        

                        // Alla fine aggiunto un separatore
                        var li = document.createElement("li");
                        li.classList.add("list-group-item", "list", "separatore", "dynamic-generated");
                        document.getElementById("listaBonus").appendChild(li);
                    }
              )
          }

          // RESISTENZE
          setText("ass_fisico", isNull(json.player.assorbimento_fisico,"0"),"%");
          setText("ass_magico", isNull(json.player.assorbimento_magico,"0"),"%");
          setText("res_impatto", getResistenza(json.resistenze, "Impatto"));
          setText("res_perforazione", getResistenza(json.resistenze, "Perforazione"));
          setText("res_taglio", getResistenza(json.resistenze, "Taglio"));
          setText("res_trauma", getResistenza(json.resistenze, "Trauma"));
          setText("res_fuoco", getResistenza(json.resistenze, "Fuoco"));
          setText("res_freddo", getResistenza(json.resistenze, "Freddo"));
          setText("res_elettricita", getResistenza(json.resistenze, "Elettricita"));
          setText("res_acido", getResistenza(json.resistenze, "Acido"));
          setText("res_energia", getResistenza(json.resistenze, "Energia"));
          setText("res_natura", getResistenza(json.resistenze, "Natura"));
          setText("res_psichico", getResistenza(json.resistenze, "Psichico"));
          setText("res_lumen", getResistenza(json.resistenze, "Lumen"));
          setText("res_umbra", getResistenza(json.resistenze, "Umbra"));
          setText("res_caos", getResistenza(json.resistenze, "Caos"));

          // EQUIPAGGIAMENTO
          if (Object.keys(json.equipment).length > 0) {
            $("#come_luce").html(getEq(json.equipment["come luce"]));
            $("#mano_destra").html(getEq(json.equipment["mano destra"]));
            $("#mano_sinistra").html(getEq(json.equipment["mano sinistra"]));
            $("#al_collo_1").html(getEq(json.equipment["al collo 1"]));
            $("#al_collo_2").html(getEq(json.equipment["al collo 2"]));
            $("#sul_corpo").html(getEq(json.equipment["sul corpo"]));
            $("#in_testa").html(getEq(json.equipment["in testa"]));
            $("#sulle_gambe").html(getEq(json.equipment["sulle gambe"]));
            $("#ai_piedi").html(getEq(json.equipment["ai piedi"]));
            $("#sulle_mani").html(getEq(json.equipment["sulle mani"]));
            $("#sulle_braccia").html(getEq(json.equipment["sulle braccia"]));
            $("#come_scudo").html(getEq(json.equipment["come scudo"]));
            $("#attorno_al_corpo").html(getEq(json.equipment["attorno al corpo"]));
            $("#alla_vita").html(getEq(json.equipment["alla vita"]));
            $("#polso_destro").html(getEq(json.equipment["polso destro"]));
            $("#polso_sinistro").html(getEq(json.equipment["polso sinistro"]));
            $("#impugnato").html(getEq(json.equipment["impugnato"]));
            $("#afferrato").html(getEq(json.equipment["afferrato"]));
            $("#sulla_schiena").html(getEq(json.equipment["sulla schiena"]));
            $("#orecchio_destro").html(getEq(json.equipment["orecchio destro"]));
            $("#orecchio_sinistro").html(getEq(json.equipment["orecchio sinistro"]));
            $("#sul_viso").html(getEq(json.equipment["sul viso"]));
            $("#incoccato").html(getEq(json.equipment["incoccato"]));
            $("#come_aura").html(getEq(json.equipment["come aura"]));
          }

          // Creo il grafico Stat
          if (chart_stat) chart_stat.destroy();
          chart_stat = CreaChartStat('chart_stat', json, undefined, false);

          $('#gridContainer').hide();
          $("#player").show();          
        }

        function InitImgBtn () {
            // Click  = apri file picker
            $('#uploadBtn').on('click', function() {
                $('#image').click();
            });

            // Dopo selezione file
            $('#image').on('change', function() {

                if (!this.files.length) return;

                const file = this.files[0];
                const maxSize = 5000 * 1024;

                if (file.size > maxSize) {
                    alert('Il file non deve superare i 5 MB');
                    return;
                }

                if (file.type !== 'image/png') {
                    alert('Il file deve essere PNG');
                    return;
                }

                const img = new Image();
                img.onload = function() {
                    const ratio = img.width / img.height;
                    const expectedRatio = 9 / 16;

                    if (Math.abs(ratio - expectedRatio) > 0.01) {
                        alert('L’immagine deve essere in formato 9:16');
                        return;
                    }

                    const formData = new FormData();
                    formData.append('image', file);
                    formData.append('user', "<?php if ($isLoggedIn) { echo $user['user_name']; } ?>");
                    formData.append('pg', $("#playerName").text());

                    fetch('php/upload.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => setPlayerImg(json_p1, data, "classImg"))
                    .catch(error => console.log("Errore in caricamento: " + error));
                };

                img.src = URL.createObjectURL(file);
            });
        }

        function resetImg() {
            const formData = new FormData();
            formData.append('user', "<?php if ($isLoggedIn) { echo $user['user_name']; } ?>");
            formData.append('pg', $("#playerName").text());

            fetch('php/delete_image.php', {
                method: 'POST',
                body: formData
            })
            .then(data => setPlayerImg(json_p1,null,"classImg"))
            .catch(error => console.log("Errore in cancellazione: " + error));
        }        

</script>

</body>

</html>
