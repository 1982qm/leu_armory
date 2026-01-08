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
    <link href="css/builder.css" rel="stylesheet" />
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
<script src="js/semaphore.js"></script>

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
              <img src="img\builder.svg" width="36px" height="36px" />
              <span id="datatableTitle" style="padding-left: 15px;">Builder</span>
          </div>
          <div id="gridContainer" class="collapse show" style="font-size: 14px;">
              <div class="card-body">
                  <table id="datatableBuilds" class="table table-striped hover compact dt-tables">
                      <thead>
                          <tr>
                              <th>Nome</th>
                              <th>Classe</th>
                              <th>Livello Medio Eq</th>
                              <th>Note</th>
                              <th>Creata Da</th>
                              <th>Data Caricamento</th>
                              <th>Visibilità</th>
                          </tr>
                      </thead>
                      <tfoot>
                          <tr>
                              <th>Nome</th>
                              <th>Classe</th>
                              <th>Livello Medio Eq</th>
                              <th>Note</th>
                              <th>Creata Da</th>
                              <th>Data Caricamento</th>
                              <th>Visibilità</th>
                          </tr>                          
                      </tfoot>
                      <tbody></tbody>
                  </table>
              </div>
          </div>
      </div>
    </div>

    <div id="player" class="container-fluid px-4" style="top: 30px;position: relative; display: none;">
      <a href="#" class="close" onclick="javascript:$('#player').hide();$('#gridContainer').show();"></a>
      <div class="card bg-dark text-white mb-4" style="opacity: 97%; min-height: 750px;">
          <div id="playerContainer" class="collapse show">
              <div class="card-body" style="display: flex;">

                <!-- PG -->
                <div class="card" style="width: 20rem; border: 0px; background: linear-gradient(black, transparent 70%); margin-left: 10px;">
                  <div class="card-body" style="z-index: 1; max-height: calc(100dvh - 150px);">
                    <h3 id="buildName" class="card-title" style="text-shadow: 2px 2px 4px black;"></h3>
                    <input id="buildName_edit" class="card-title" style="text-shadow: 2px 2px 4px black;" placeholder="Nome della build"></input>
                    <h5 id="className" class="card-title"></h5>
                    <div id="classNameDiv_edit">
                      <select id="className_edit" class="card-title">
                        <option value=""></option>
                        <option value="Chierico">Chierico</option>
                        <option value="Ranger">Ranger</option>
                        <option value="Paladino">Paladino</option>
                      </select>
                    </div>
                    <h3 id="avg_eq_level" class="card-title" style="position: absolute; color: #00FE1E; top: 15px; right: 20px; text-shadow: 1px 1px 2px black;"></h3>
                    <div style="height: 430px; width: auto; margin-top: -60px; margin-bottom: 90px; align-content: center;" >
                      <img id="classImg" class="card-img-top" style="scale: 80%;">
                    </div>
                    
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
                      <li class="list-group-item list" id="razza_li"><div class="info"><span class="stat">Razza</span><span id="razza" class="number_value"></span></div></li>
                      <li class="list-group-item list" id="razza_li_edit" style="height: 35px; border: 0px;">
                        <div class="info">
                          <select id="razza_edit">
                            <option value=""></option>
                            <option value="Umano">Umano</option>
                          </select>
                        </div>
                      </li>
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

                      <li class="list-group-item list edit_link" onclick="ToggleEdit('mano_destra_edit')"><div class="eqrow"><span class="slot">mano destra</span><span id="mano_destra" class="eq"></span></div></li>

                      <li id="mano_destra_edit" class="list-group-item list edit_item" style="height: auto">
                        <div class="eqrow_edit">
                          <select id="mano_destra_sel_item" class="sel_item" slot="Dita">
                            <option value=""></option>
                          </select>
                        </div>
                        <div id="mano_destra_edit_details" style="display: none;">
                          <div class="eqrow_edit">
                            <span>Percorso:</span><span id="mano_destra_percorso_nome" class="percorso"></span>
                            <span>Livello:</span>
                            <select id="mano_destra_percorso_livello" class="percorso_livello">
                            </select>
                          </div>
                          <div class="eqrow_edit">
                            <span class="potere_numero">AC</span>
                            <input id="mano_destra_ac" placeholder="AC" class="potere_valore" readonly></input>
                          </div>
                          <div class="eqrow_edit">
                            <span class="potere_numero">[1]</span>
                            <select id="mano_destra_pow_1_tipo" class="sel_potere_tipo">
                              <option value=""></option>
                            </select>
                            <input id="mano_destra_pow_1_valore" placeholder="Valore" class="potere_valore" readonly></input>
                            <select id="mano_destra_pow_1_nome" class="sel_potere_nome">
                              <option value=""></option>
                            </select>
                          </div>
                          <div class="eqrow_edit">
                            <span class="potere_numero">[2]</span>
                            <select id="mano_destra_pow_2_tipo" class="sel_potere_tipo">
                              <option value=""></option>
                            </select>
                            <input id="mano_destra_pow_2_valore" placeholder="Valore" class="potere_valore" readonly></input>
                            <select id="mano_destra_pow_2_nome" class="sel_potere_nome">
                              <option value=""></option>
                            </select>
                          </div>
                          <div class="eqrow_edit">
                            <span class="potere_numero">[3]</span>
                            <select id="mano_destra_pow_3_tipo" class="sel_potere_tipo">
                              <option value=""></option>
                            </select>
                            <input id="mano_destra_pow_3_valore" placeholder="Valore" class="potere_valore" readonly></input>
                            <select id="mano_destra_pow_3_nome" class="sel_potere_nome">
                              <option value=""></option>
                            </select>
                          </div>
                          <div class="eqrow_edit">
                            <span class="potere_numero">[4]</span>
                            <select id="mano_destra_pow_4_tipo" class="sel_potere_tipo">
                              <option value=""></option>
                            </select>
                            <input id="mano_destra_pow_4_valore" placeholder="Valore" class="potere_valore" readonly></input>
                            <select id="mano_destra_pow_4_nome" class="sel_potere_nome">
                              <option value=""></option>
                            </select>
                          </div>
                          <div class="eqrow_edit">
                            <span class="potere_numero">[5]</span>
                            <select id="mano_destra_pow_5_tipo" class="sel_potere_tipo">
                              <option value=""></option>
                            </select>
                            <input id="mano_destra_pow_5_valore" placeholder="Valore" class="potere_valore" readonly></input>
                            <select id="mano_destra_pow_5_nome" class="sel_potere_nome">
                              <option value=""></option>
                            </select>
                          </div>
                          <div class="eqrow_edit">
                            <span class="potere_numero">[6]</span>
                            <select id="mano_destra_pow_6_tipo" class="sel_potere_tipo">
                              <option value=""></option>
                            </select>
                            <input id="mano_destra_pow_6_valore" placeholder="Valore" class="potere_valore" readonly></input>
                            <select id="mano_destra_pow_6_nome" class="sel_potere_nome">
                              <option value=""></option>
                            </select>
                          </div>
                        </div>
                      </li>

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
          "/armory/img/players.svg",
          "/armory/img/background.jpg"
        )

        var json_poteri_speciali;
        $.getJSON("database/poteri_speciali.json", function (json) { json_poteri_speciali = json; });

        var json_spell_armi;
        $.getJSON("database/spell_armi.json", function (json) { json_spell_armi = json; });

        // Semafori, il numero è il parallelismo. Deve essere uguale al numero di fetch che devo fare parallelamente
        let sema = new Semaphore(2);

        document.addEventListener("DOMContentLoaded", function () {
            Chart.defaults.font.family = "'DejaVu Sans Mono', monospace";
            Chart.defaults.color = "#fff";
            if(input_name) input_name = input_name.toString().replace(/"/g,"");
            CreateDataTable($("#datatableBuilds"), 'Nuova build', NewBuild);
            window.addEventListener('orientationchange', function (){
                var dtTable = $("#datatableBuilds").DataTable();
                dtTable.columns.adjust();
            });
            $("#className_edit").select2({
              placeholder: "Seleziona la classe...",
              language: "it"
            });
            $("#razza_edit").select2({
              placeholder: "Seleziona la razza...",
              language: "it"
            });
            $(".sel_item").each(function( index ) {
              $(this).select2({
                placeholder: "Seleziona un oggetto...",
                language: "it"
              });
            });
            FetchItems();
            FetchBuilds();
            ShowContent();
        })

        async function ShowContent() {
            //Prendo due semafori in modo da partire per forza dopo che le load hanno finito
            //il numero di semafori deve essere uguale al numero di fetch parallele che lancio, per ora sono 2
            await sema.acquire();
            await sema.acquire();
            document.getElementById("loadingDiv").style.display = "none";
            document.getElementById("content").style.display = "block";
            //if (input_name) FetchPlayerDetailsByName(input_name);
            //Libero tutti i semafori
            sema.release();
            sema.release();
        }

        function NewBuild() {
          console.log("NewBuild");
        }

        async function FetchItems () {
          // Blocco il semaforo
          await sema.acquire();
          // Libero il semaforo
          sema.release();
        }        

        async function FetchBuilds () {
          // Blocco il semaforo
          await sema.acquire();
          fetch('php/load_builds.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json'
              },
              body: '{"account" : "<?php if ($isLoggedIn) { echo $user['user_name']; } ?>"}'
          })
          .then(response => response.json())
          .then(data => LoadBuilds(data))
          .catch(error => console.log("Errore in caricamento: " + error));
        }

        function LoadBuilds (data) {
          var table = LoadDataTable($("#datatableBuilds"),
                                    data,
                                    function (element) {
                                        return [element.nome,
                                                element.classe,
                                                element.avg_eq_level,
                                                element.note,
                                                element.account,
                                                element.data_caricamento,
                                                element.visibilita
                                               ];
                                    },
                                    ShowBuild,
                                    true
          );
          table .column('5')
                .order('desc')
                .draw();
          
          $(".dt-search").parent().css("position","absolute");
          $(".dt-search").parent().css("top","-72px");
          $(".dt-search").parent().css("right","10px");
          $(".dt-search").parent().css("font-size","14px");
          $(".dt-search input").css("border-color","#464D54");

          // Libero il semaforo
          sema.release();
        }

        function ShowBuild (tr) {
          nome=$(tr).find("td").eq(0).text();
          FetchBuildDetails(nome);
        }

        function FetchBuildDetails (nome) {
          fetch('php/load_build_details.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json'
              },
              body: '{"nome" : "' + nome + '", "account" : "<?php if ($isLoggedIn) { echo $user['user_name']; } ?>"}'
          })
          .then(response => response.json())
          .then(data => LoadBuildDetails(data))
          .catch(error => console.log("Errore in caricamento: " + error));
        }

        function LoadBuildDetails (data) {
          $('.dynamic-generated').remove();
          $(".edit_item").hide();

          var json = JSON.parse(data.json);
          json_p1 = json;

          <?php if ($isLoggedIn && $user['user_type'] == "1") {?>
            console.log(json);
          <?php } ?>

          if ("<?php if ($isLoggedIn) { echo $user['user_name']; } ?>" == data.json.account) {
            $(".edit_link").css("cursor", "pointer");
            $("#buildName").hide();
            $("#className").hide();
            $("#razza_li").hide();
            $("#buildName_edit").show();
            $("#classNameDiv_edit").show();
            $("#razza_li_edit").show();
          } else {
            $(".edit_link").css("cursor", "default");
            $("#buildName").show();
            $("#className").show();
            $("#razza_li").show();
            $("#buildName_edit").hide();
            $("#classNameDiv_edit").hide();
            $("#razza_li_edit").hide();
          }

          setText("buildName", json.player.nome);
          setText("avg_eq_level", json.player.avg_eq_level);

          if(json.player.classe != undefined) {
              if(json.player.main_class != undefined) {
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
          setText("ass_fisico", json.player.assorbimento_fisico,"%");
          setText("ass_magico", json.player.assorbimento_magico,"%");
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

        function ToggleEdit(id) {
          if ("<?php if ($isLoggedIn) { echo $user['user_name']; } ?>" == json_p1.account) {
            $("#"+id).toggle();
          }
        }

</script>

</body>

</html>
