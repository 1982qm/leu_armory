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
    <link href="css/builder.css" rel="stylesheet" />
</head>

<script src="lib/jquery-3.5.1.min.js"></script>
<script src="lib/bootstrap.bundle.min.js"></script>
<script src="lib/md5.js"></script>
<script src="lib/select2.min.js"></script>
<script src="lib/select2.it.min.js"></script>
<script src="lib/datatables.min.js"></script>
<script src="js/manageDT.js?1.0"></script>
<script src="js/common.js"></script>
<script src="js/semaphore.js"></script>
<script src="js/messages.js"></script>

<body>
  <main>
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

    <div id="build" class="container-fluid px-4" style="top: 30px;position: relative; display: none;">
      <a href="#" class="close" onclick="javascript:$('#build').hide();$('#gridContainer').show();"></a>
      <div class="card bg-dark text-white mb-4" style="opacity: 97%; min-height: 750px;">
          <div id="buildContainer" class="collapse show">
              <div class="card-body" style="display: flex;">

                <!-- PG -->
                <div class="card" style="width: 20rem; border: 0px; background: linear-gradient(black, transparent 70%); margin-left: 10px;">
                  <div class="card-body" style="z-index: 1; max-height: calc(100dvh - 150px);">
                    <!-- PUBBLICA -->
                    <div id="buildPubblica_switch" class="form-check form-switch " style="margin-bottom: 20px; cursor: pointer;">
                      <input class="form-check-input" type="checkbox" role="switch" id="buildPubblica" style="cursor: inherit;" onchange="SetPubblicaLabel()">
                      <label id="buildPubblicaLabel" class="form-check-label" for="buildPubblica" style="cursor: inherit;">Privata</label>
                      <button id="saveButton" class="btn btn-primary btn-sm" style="float: right; margin-left: 10px" onclick="SaveBuild()">Salva</button>
                      <button id="delButton" class="btn btn-danger btn-sm" style="float: right;" onclick="DeleteBuild()">Elimina</button>
                    </div>
                    <h3 id="buildName" class="card-title" style="text-shadow: 2px 2px 4px black;"></h3>
                    <input id="buildName_edit" class="card-title" style="text-shadow: 2px 2px 4px black; width: 100%" placeholder="Nome della build"></input>
                    <h5 id="className" class="card-title"></h5>
                    <div id="classNameDiv_edit">
                      <select id="className_edit" class="card-title" onchange="setImg()">
                        <option value=""></option>
                        <option value="Barbaro">Barbaro</option>
                        <option value="Chierico">Chierico</option>
                        <option value="Druido">Druido</option>
                        <option value="Guerriero">Guerriero</option>
                        <option value="Ladro">Ladro</option>
                        <option value="Mago">Mago</option>
                        <option value="Monaco">Monaco</option>
                        <option value="Paladino">Paladino</option>
                        <option value="Psionico">Psionico</option>
                        <option value="Ranger">Ranger</option>
                        <option value="Arcanista">Arcanista (Chierico/Mago)</option>
                        <option value="Asceta">Asceta (Druido/Guerriero)</option>
                        <option value="Illusionista">Illusionista (Guerriero/Mago)</option>
                        <option value="Mistificatore">Mistificatore (Ladro/Mago)</option>
                        <option value="Schermidore">Schermidore (Guerriero/Ladro)</option>
                        <option value="Templare">Templare (Chierico/Guerriero)</option>
                        <option value="Condottiero">Condottiero (Chierico/Guerriero/Mago)</option>
                        <option value="Errante">Errante (Chierico/Ladro/Mago)</option>
                      </select>
                    </div>
                    <div style="margin-top: 30px;" >
                      <img id="classImg" class="card-img-top">
                    </div>
                  </div>
                </div>

                <!-- EQUIPAGGIAMENTO -->
                <div class="card" style="min-width: 35rem; width: max-content; border: 0px; margin-left: 10px;">
                  <div class="card-body">
                    <h5 class="card-title" style="text-shadow: 1px 1px 2px black;">Equipaggiamento<span id="oggettiLimitati">Oggetti limitati <span id="oggettiLimitatiMin">0</span>/<span id="oggettiLimitatiMax">36</span></span></h5>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item list edit_link" slot="come luce" slot_db="Luce"><div class="eqrow"><span class="slot">come luce</span><span id="come_luce" class="eq"></span></div></li>
                      <li class="list-group-item list edit_link" slot="mano_destra" slot_db="Dita"><div class="eqrow"><span class="slot">mano destra</span><span id="mano_destra" class="eq"></span></div></li>
                      <li class="list-group-item list edit_link" slot="mano_sinistra" slot_db="Dita"><div class="eqrow"><span class="slot">mano sinistra</span><span id="mano_sinistra" class="eq"></span></div></li>
                      <li class="list-group-item list edit_link" slot="al_collo_1" slot_db="Collo"><div class="eqrow"><span class="slot">al collo</span><span id="al_collo_1" class="eq"></span></div></li>
                      <li class="list-group-item list edit_link" slot="al_collo_2" slot_db="Collo"><div class="eqrow"><span class="slot">al collo</span><span id="al_collo_2" class="eq"></span></div></li>
                      <li class="list-group-item list edit_link" slot="sul_corpo" slot_db="Corpo"><div class="eqrow"><span class="slot">sul corpo</span><span id="sul_corpo" class="eq"></span></div></li>
                      <li class="list-group-item list edit_link" slot="in_testa" slot_db="Testa"><div class="eqrow"><span class="slot">in testa</span><span id="in_testa" class="eq"></span></div></li>
                      <li class="list-group-item list edit_link" slot="sulle_gambe" slot_db="Gambe"><div class="eqrow"><span class="slot">sulle gambe</span><span id="sulle_gambe" class="eq"></span></div></li>
                      <li class="list-group-item list edit_link" slot="ai_piedi" slot_db="Piedi"><div class="eqrow"><span class="slot">ai piedi</span><span id="ai_piedi" class="eq"></span></div></li>
                      <li class="list-group-item list edit_link" slot="sulle_mani" slot_db="Mani"><div class="eqrow"><span class="slot">sule mani</span><span id="sulle_mani" class="eq"></span></div></li>
                      <li class="list-group-item list edit_link" slot="sulle_braccia" slot_db="Braccia"><div class="eqrow"><span class="slot">sulle braccia</span><span id="sulle_braccia" class="eq"></span></div></li>
                      <li class="list-group-item list edit_link" slot="come_scudo" slot_db="Scudo"><div class="eqrow"><span class="slot">come scudo</span><span id="come_scudo" class="eq"></span></div></li>
                      <li class="list-group-item list edit_link" slot="attorno_al_corpo" slot_db="Attorno"><div class="eqrow"><span class="slot">attorno al corpo</span><span id="attorno_al_corpo" class="eq"></span></div></li>
                      <li class="list-group-item list edit_link" slot="alla_vita" slot_db="Vita"><div class="eqrow"><span class="slot">alla vita</span><span id="alla_vita" class="eq"></span></div></li>
                      <li class="list-group-item list edit_link" slot="polso_destro" slot_db="Polso"><div class="eqrow"><span class="slot">polso destro</span><span id="polso_destro" class="eq"></span></div></li>
                      <li class="list-group-item list edit_link" slot="polso_sinistro" slot_db="Polso"><div class="eqrow"><span class="slot">polso sinistro</span><span id="polso_sinistro" class="eq"></span></div></li>
                      <li class="list-group-item list edit_link" slot="impugnato" slot_db="Impugnato"><div class="eqrow"><span class="slot">impugnato</span><span id="impugnato" class="eq"></span></div></li>
                      <li class="list-group-item list edit_link" slot="afferrato" slot_db="Afferrato"><div class="eqrow"><span class="slot">afferrato</span><span id="afferrato" class="eq"></span></div></li>
                      <li class="list-group-item list edit_link" slot="sulla_schiena" slot_db="Schiena"><div class="eqrow"><span class="slot">sulla schiena</span><span id="sulla_schiena" class="eq"></span></div></li>
                      <li class="list-group-item list edit_link" slot="orecchio_destro" slot_db="Orecchie"><div class="eqrow"><span class="slot">orecchio destro</span><span id="orecchio_destro" class="eq"></span></div></li>
                      <li class="list-group-item list edit_link" slot="orecchio_sinistro" slot_db="Orecchie"><div class="eqrow"><span class="slot">orecchio sinistro</span><span id="orecchio_sinistro" class="eq"></span></div></li>
                      <li class="list-group-item list edit_link" slot="sul_viso" slot_db="Viso"><div class="eqrow"><span class="slot">sul viso</span><span id="sul_viso" class="eq"></span></div></li>
                      <li class="list-group-item list edit_link" slot="incoccato" slot_db="Incoccato"><div class="eqrow"><span class="slot">incoccato</span><span id="incoccato" class="eq"></span></div></li>
                      <li class="list-group-item list edit_link" slot="come_aura" slot_db="Aura"><div class="eqrow"><span class="slot">come aura</span><span id="come_aura" class="eq"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                    </ul>
                  </div>
                </div>

                <div class="card" style="min-width: 22rem; width: max-content; border: 0px; margin-left: 10px;">
                  <div class="card-body">
                    <!-- BONUS -->
                    <h5 class="card-title" style="text-shadow: 1px 1px 2px black;">Bonus Attivi</h5>
                    <ul id="listaBonus" class="list-group list-group-flush">
                    </ul>
                  </div>
                </div>

                <div class="card" style="min-width: 22rem; width: max-content; border: 0px; margin-left: 10px;">
                  <div class="card-body">
                    <!-- NOTE -->
                    <h5 class="card-title" style="text-shadow: 1px 1px 2px black;">Note della build</h5>
                    <label id="buildNotes" class="buildNotes" readonly></label>
                    <textarea id="buildNotes_edit" class="buildNotes" placeholder="Inserisci qui eventuali note sulla build"></textarea>
                  </div>
                </div>

              </div>
          </div>
      </div>
    </div>
    
  </main>  

  <script>
        var json_p1;
        var oggetti_db;
        var oggetti_build;

        // Semafori, il numero è il parallelismo. Deve essere uguale al numero di fetch che devo fare parallelamente
        let sema = new Semaphore(2);

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
          "/armory/img/builder.svg",
          "/armory/img/background.jpg"
        )

        window.addEventListener("load", function () {
            CreateDataTable($("#datatableBuilds"), 'Nuova build', NewBuild);
            $("#className_edit").select2({
              placeholder: "Seleziona la classe...",
              language: "it"
            });
            FetchItems();
            FetchBuilds();
            ShowContent();
        })

        function CreateElements (el) {
            var html_start = `<li id="#slot#_edit" class="list-group-item list edit_item dynamic-generated" style="height: auto"> ` +
                       `  <div class="eqrow_edit"> ` +
                       `    <select id="#slot#_sel_item" class="sel_item" slot="#slot#" slot_db="#slot_db#" onchange="setObject('#slot#_sel_item')"> ` +
                       `      <option value=""></option> ` +
                       `    </select> ` +
                       `  </div> ` +
                       `  <div id="#slot#_edit_details" style="display: none;"> ` +
                       `    <div class="eqrow_edit"> ` +
                       `      <span>Percorso:</span><span id="#slot#_percorso_nome" class="percorso"></span> ` +
                       `      <span>Livello:</span> ` +
                       `      <select id="#slot#_percorso_livello" class="percorso_livello" onchange="updateObject('#slot#')"> ` +
                       `      </select> ` +
                       `    </div> `
            ;

            var html_ac = ` <div class="eqrow_edit"> ` +
                       `      <span class="potere_numero">AC</span> ` +
                       `      <input id="#slot#_ac" placeholder="AC" class="potere_valore" readonly></input> ` +
                       `    </div> `
            ;

            var html_dice = 
                       `    <div class="eqrow_edit"> ` +
                       `      <span class="danno_label">Danni</span> ` +
                       `      <input id="#slot#_danni" placeholder="Danni" class="danno_valore" readonly></input> ` +
                       `    </div> `
            ;
            
            var html_prop =  `  <div class="eqrow_edit"> ` +
                       `      <span class="potere_numero">[1]</span> ` +
                       `      <select id="#slot#_pow_1_tipo" class="sel_potere_tipo"> ` +
                       `        <option value=""></option> ` +
                       `      </select> ` +
                       `      <input id="#slot#_pow_1_valore" placeholder="Valore" class="potere_valore" readonly></input> ` +
                       `      <select id="#slot#_pow_1_nome" class="sel_potere_nome"> ` +
                       `        <option value=""></option> ` +
                       `      </select> ` +
                       `    </div> ` +
                       `    <div class="eqrow_edit"> ` +
                       `      <span class="potere_numero">[2]</span> ` +
                       `      <select id="#slot#_pow_2_tipo" class="sel_potere_tipo"> ` +
                       `        <option value=""></option> ` +
                       `      </select> ` +
                       `      <input id="#slot#_pow_2_valore" placeholder="Valore" class="potere_valore" readonly></input> ` +
                       `      <select id="#slot#_pow_2_nome" class="sel_potere_nome"> ` +
                       `        <option value=""></option> ` +
                       `      </select> ` +
                       `    </div> ` +
                       `    <div class="eqrow_edit"> ` +
                       `      <span class="potere_numero">[3]</span> ` +
                       `      <select id="#slot#_pow_3_tipo" class="sel_potere_tipo"> ` +
                       `        <option value=""></option> ` +
                       `      </select> ` +
                       `      <input id="#slot#_pow_3_valore" placeholder="Valore" class="potere_valore" readonly></input> ` +
                       `      <select id="#slot#_pow_3_nome" class="sel_potere_nome"> ` +
                       `        <option value=""></option> ` +
                       `      </select> ` +
                       `    </div> ` +
                       `    <div class="eqrow_edit"> ` +
                       `      <span class="potere_numero">[4]</span> ` +
                       `      <select id="#slot#_pow_4_tipo" class="sel_potere_tipo"> ` +
                       `        <option value=""></option> ` +
                       `      </select> ` +
                       `      <input id="#slot#_pow_4_valore" placeholder="Valore" class="potere_valore" readonly></input> ` +
                       `      <select id="#slot#_pow_4_nome" class="sel_potere_nome"> ` +
                       `        <option value=""></option> ` +
                       `      </select> ` +
                       `    </div> ` +
                       `    <div class="eqrow_edit"> ` +
                       `      <span class="potere_numero">[5]</span> ` +
                       `      <select id="#slot#_pow_5_tipo" class="sel_potere_tipo"> ` +
                       `        <option value=""></option> ` +
                       `      </select> ` +
                       `      <input id="#slot#_pow_5_valore" placeholder="Valore" class="potere_valore" readonly></input> ` +
                       `      <select id="#slot#_pow_5_nome" class="sel_potere_nome"> ` +
                       `        <option value=""></option> ` +
                       `      </select> ` +
                       `    </div> ` +
                       `    <div class="eqrow_edit"> ` +
                       `      <span class="potere_numero">[6]</span> ` +
                       `      <select id="#slot#_pow_6_tipo" class="sel_potere_tipo"> ` +
                       `        <option value=""></option> ` +
                       `      </select> ` +
                       `      <input id="#slot#_pow_6_valore" placeholder="Valore" class="potere_valore" readonly></input> ` +
                       `      <select id="#slot#_pow_6_nome" class="sel_potere_nome"> ` +
                       `        <option value=""></option> ` +
                       `      </select> ` +
                       `    </div> `
            ;
            var html_end =  `  </div> ` +
                       `</li>`
            ;            

            var slot = $(el).attr("slot");
            var slot_db = $(el).attr("slot_db");

            html_start = html_start.replaceAll("#slot#", slot).replaceAll("#slot_db#", slot_db);
            html_ac = html_ac.replaceAll("#slot#", slot).replaceAll("#slot_db#", slot_db);
            html_dice = html_dice.replaceAll("#slot#", slot).replaceAll("#slot_db#", slot_db);
            html_prop = html_prop.replaceAll("#slot#", slot).replaceAll("#slot_db#", slot_db);
            html_end = html_end.replaceAll("#slot#", slot).replaceAll("#slot_db#", slot_db);

            $(el).after(html_start+html_end);     

            //if (slot == "afferrato" || slot == "impugnato") {
            //  $(el).after(html_start+html_dice+html_prop+html_end);
            //} else {
            //  $(el).after(html_start+html_ac+html_prop+html_end);              
            //}
        }

        async function ShowContent() {
            //Prendo due semafori in modo da partire per forza dopo che le load hanno finito
            //il numero di semafori deve essere uguale al numero di fetch parallele che lancio, per ora sono 2
            await sema.acquire();
            await sema.acquire();
            document.getElementById("loadingDiv").style.display = "none";
            document.getElementById("content").style.display = "block";
            //Libero tutti i semafori
            sema.release();
            sema.release();
        }

        function NewBuild() {
            $('.dynamic-generated').remove();
            
            oggetti_build = [];

            $(".edit_link").css("cursor", "pointer");
            $("#buildName").hide();
            $("#className").hide();
            $("#buildName_edit").show();
            $("#classNameDiv_edit").show();
            $("#buildPubblica_switch").show();
            $("#delButton").hide();
            $("#saveButton").show();

            $("#buildName").val("");
            $("#buildName_edit").val("");
            $("#className").val("");
            $("#classNameDiv_edit").val("");

            $(".eq").text("");
            $("#oggettiLimitatiMin").text("0");
            $("#classImg").attr("src","");

            $(".edit_link").each(function( index ) {
              CreateElements (this);
              $(this).unbind('click');
              $(this).click(ToggleEdit);
            })

            $(".edit_item").hide();
            
            LoadItems();

            $("#buildPubblica").prop( "checked", false );
            $("#buildPubblica").trigger('change');

            $('#gridContainer').hide();
            $("#build").show();
        }

        async function FetchItems () {
          // Blocco il semaforo
          await sema.acquire();
          fetch('php/load_items.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json'
              },
              body: '{  "nome" : ""' + 
                    '  ,"percorso" : ""' + 
                    '  ,"slot" : ""' + 
                    '  ,"potere" : ""' + 
                    '}'
          })
          .then(response => response.json())
          .then(data => { oggetti_db = data; sema.release(); })
          .catch(error => console.log("Errore in caricamento: " + error));
        }

        function LoadItems (data) {
          var data = oggetti_db;

          data.forEach(
            element => {
                // Aggiungo la riga alla lista
                var opt = document.createElement ("option");
                $(opt).val(element.nome);
                $(opt).text(element.nome);

                if (element.slot == "Arma") {
                  $("select[slot_db='Impugnato']").append(opt);
                } else if (element.slot == "Arma Afferrato") {
                  $("select[slot_db='Impugnato']").append(opt);
                  // Aggiungo la riga alla lista
                  var opt2 = document.createElement ("option");
                  $(opt2).val(element.nome);
                  $(opt2).text(element.nome);
                  $("select[slot_db='Afferrato']").append(opt2);
                } else {
                  $("select[slot_db='"+element.slot+"']").append(opt);
                }
            }
          );

          $(".sel_item").each(function( index ) {
            $(this).select2({
              placeholder: "Seleziona un oggetto...",
              language: "it",
              sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
            });
          });

          AddPoteriTipo ("Brutale");
          AddPoteriTipo ("Cardinale");
          AddPoteriTipo ("Incantato");
          AddPoteriTipo ("Innato");
          AddPoteriTipo ("Mistico");
          AddPoteriTipo ("Progressivo");
          AddPoteriTipo ("Resiliente");
          AddPoteriTipo ("Volatile");
                    
          AddPoteriNome ("Astuzia");
          AddPoteriNome ("Bloccare con lo scudo");
          AddPoteriNome ("Causa ferite leggere");
          AddPoteriNome ("Colpo Critico");
          AddPoteriNome ("Danno Elettrico");
          AddPoteriNome ("Danno Energia");
          AddPoteriNome ("Danno Fisico");
          AddPoteriNome ("Danno Fisico/Potere Magico");
          AddPoteriNome ("Danno Freddo");
          AddPoteriNome ("Danno Fuoco");
          AddPoteriNome ("Danno Impatto");
          AddPoteriNome ("Danno Lumen");
          AddPoteriNome ("Danno Natura");
          AddPoteriNome ("Danno Perforazione");
          AddPoteriNome ("Danno Psichico");
          AddPoteriNome ("Danno Taglio");
          AddPoteriNome ("Danno Trauma");
          AddPoteriNome ("Danno Umbra");
          AddPoteriNome ("Eff. Abilita` (Elettrico)");
          AddPoteriNome ("Eff. Abilita` (Energia)");
          AddPoteriNome ("Eff. Abilita` (Freddo)");
          AddPoteriNome ("Eff. Abilita` (Fuoco)");
          AddPoteriNome ("Eff. Abilita` (Impatto)");
          AddPoteriNome ("Eff. Abilita` (Lumen)");
          AddPoteriNome ("Eff. Abilita` (Natura)");
          AddPoteriNome ("Eff. Abilita` (Perforazione)");
          AddPoteriNome ("Eff. Abilita` (Psichico)");
          AddPoteriNome ("Eff. Abilita` (Taglio)");
          AddPoteriNome ("Eff. Abilita` (Trauma)");
          AddPoteriNome ("Eff. Abilita` (Umbra)");
          AddPoteriNome ("Eff. Corpo a Corpo (Fisico)");
          AddPoteriNome ("Eff. Corpo a Corpo (Magico)");
          AddPoteriNome ("Letalita`");
          AddPoteriNome ("Penetrazione");
          AddPoteriNome ("Potere Magico");
          AddPoteriNome ("Precisione");
          AddPoteriNome ("Punti Ferita");
          AddPoteriNome ("Recupero Punti Ferita");
          AddPoteriNome ("Res. al Fuoco");
          AddPoteriNome ("Res. all'Impatto");
          AddPoteriNome ("Resistenza a Tutto");
          AddPoteriNome ("Resistenza al Divino");
          AddPoteriNome ("Resistenza al Fisico");
          AddPoteriNome ("Resistenza al Magico");
          AddPoteriNome ("Resistenza alla Perforazione");
          AddPoteriNome ("Vitalita`");          
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
                                                element.note,
                                                element.account,
                                                element.data_caricamento,
                                                element.pubblica == 1 ? "Pubblica" : "Privata"
                                               ];
                                    },
                                    ShowBuild,
                                    true
          );

          setTimeout(() => {
            table .column('4')
                  .order('desc')
                  .draw();
            $(".dt-search").parent().css("position","absolute");
            $(".dt-search").parent().css("top","-72px");
            $(".dt-search").parent().css("right","10px");
            $(".dt-search").parent().css("font-size","14px");
            $(".dt-search input").css("border-color","#464D54");
            window.addEventListener('orientationchange', function (){
                var dtTable = $("#datatableBuilds").DataTable();
                dtTable.columns.adjust();
            });
            // Libero il semaforo
            sema.release();            
          }, 300);          
        }

        function ShowBuild (tr) {
          nome=$(tr).find("td").eq(0).text();
          account=$(tr).find("td").eq(3).text();
          FetchBuildDetails(nome, account);
        }

        function FetchBuildDetails (nome, account) {
          fetch('php/load_build_details.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json'
              },
              body: '{"nome" : "' + nome + '", "account" : "' + account + '"}'
          })
          .then(response => response.json())
          .then(data => LoadBuildDetails(data))
          .catch(error => console.log("Errore in caricamento: " + error));
        }

        function LoadBuildDetails (data) {
          $('.dynamic-generated').remove();

          oggetti_build = [];

          json_p1 = data;
          var json =  JSON.parse(data.json.replaceAll('§','"'));

          $(".edit_link").each(function( index ) {
            CreateElements (this);
            $(this).unbind('click');
          })

          $(".edit_item").hide();
          $("#oggettiLimitatiMin").text("0");

          LoadItems();

          <?php if ($isLoggedIn && $user['user_type'] == "1") {?>
            console.log(json_p1);
          <?php } ?>

          if ("<?php if ($isLoggedIn) { echo $user['user_name']; } ?>" == json_p1.account ||
              "<?php if ($isLoggedIn) { echo $user['user_type']; } ?>" == "1") {
            $(".edit_link").css("cursor", "pointer");
            $("#buildName").hide();
            $("#className").hide();
            $("#buildName_edit").show();
            $("#classNameDiv_edit").show();
            $("#buildPubblica_switch").show();
            $("#buildNotes").hide();
            $("#buildNotes_edit").show(); 
            $("#delButton").show();
            $("#saveButton").show();
            $(".edit_link").each(function( index ) {
              $(this).click(ToggleEdit);
            })
          } else {
            $(".edit_link").css("cursor", "default");
            $("#buildName").show();
            $("#className").show();
            $("#buildName_edit").hide();
            $("#classNameDiv_edit").hide();
            $("#buildPubblica_switch").hide();
            $("#buildNotes").show();
            $("#buildNotes_edit").hide();
            $("#delButton").hide();
            $("#saveButton").hide();
          }

          setText("buildName", json_p1.nome);
          setText("className", json_p1.classe);
          $("#buildName_edit").val(json_p1.nome);
          $("#buildName_edit").trigger('change');
          $("#className_edit").val(json_p1.classe);
          $("#className_edit").trigger('change');
          $("#buildPubblica").prop( "checked", (json_p1.pubblica == 1) );
          $("#buildPubblica").trigger('change');
          $("#buildNotes").text(json_p1.note);
          $("#buildNotes_edit").val(json_p1.note);

          setImg();

          json.forEach(el => {
            $("#"+el.slot+"_sel_item").val(el.proprieta.nome);
            $("#"+el.slot+"_sel_item").trigger('change');
            $("#"+el.slot+"_percorso_livello").val(el.proprieta.livello_percorso);
            $("#"+el.slot+"_percorso_livello").trigger('change');
          })

          $('#gridContainer').hide();
          $("#build").show();
        }

        function ToggleEdit(el) {
          $(".edit_item").each(function (idx) {
            if ($(this).attr("id") != $("#"+($(el.currentTarget).attr("slot")) + "_edit").attr("id")) {
              $(this).hide();
            }
          });

          $("#"+($(el.currentTarget).attr("slot")) + "_edit").toggle();
        }

        function setImg() {
          $("#classImg").attr("src", 'img/' + $("#className_edit").val().toLowerCase() + '.png');
        }

        function getDannoArma (dadi, tipo_danno, perc_fisico, perc_magico) {
          if (dadi != undefined && dadi.length > 0) {
            var dice = dadi.toString().split("D");
            var media = ((parseFloat(isNull(dice[0],'0')) * parseFloat(isNull(dice[1],'0')) + parseFloat(isNull(dice[0],'0')))/2);
            return (dadi + ' (media ' + media + ') di tipologia ' + tipo_danno + ", %" + perc_fisico + ' DF, %' + perc_magico + ' PM');
          } else {
            return "";
          }
        }   

        function setObject (el) {
          var oggetto = $("#"+el).val();
          if (oggetto != undefined && oggetto.length > 0) {
              var slot = $("#"+el).attr("slot");
              var proprieta = oggetti_db.find((element) => element.nome == oggetto);
              
              $("#"+slot+"_percorso_livello").empty();
              for (idx = proprieta.livello_percorso; idx <= proprieta.livello_percorso_max; idx++) {
                var opt = document.createElement ("option");
                $(opt).addClass("dynamic-generated");
                $(opt).val(idx);
                $(opt).text(idx);
                $(opt).attr("limitato", getLimitatoValue(idx, proprieta.livello_percorso_max));
                $("#"+slot+"_percorso_livello").append(opt);
              }

              oggetti_build = oggetti_build.filter(function( obj ) {
                return obj.slot !== slot;
              });
              oggetti_build.push({slot: slot, proprieta: proprieta});

              updateObject(slot);

              $("#"+slot+"_percorso_nome").text(proprieta.percorso);
              $("#"+slot+"_ac").val(proprieta.ac);
              $("#"+slot+"_danni").val(getDannoArma(proprieta.dadi, proprieta.tipo_danno, proprieta.perc_fisico, proprieta.perc_magico));
              $("#"+slot+"_pow_1_tipo").val(proprieta.potere_1_tipo);
              $("#"+slot+"_pow_1_valore").val(proprieta.potere_1_valore);
              $("#"+slot+"_pow_1_nome").val(proprieta.potere_1_nome);
              $("#"+slot+"_pow_2_tipo").val(proprieta.potere_2_tipo);
              $("#"+slot+"_pow_2_valore").val(proprieta.potere_2_valore);
              $("#"+slot+"_pow_2_nome").val(proprieta.potere_2_nome);
              $("#"+slot+"_pow_3_tipo").val(proprieta.potere_3_tipo);
              $("#"+slot+"_pow_3_valore").val(proprieta.potere_3_valore);
              $("#"+slot+"_pow_3_nome").val(proprieta.potere_3_nome);
              $("#"+slot+"_pow_4_tipo").val(proprieta.potere_4_tipo);
              $("#"+slot+"_pow_4_valore").val(proprieta.potere_4_valore);
              $("#"+slot+"_pow_4_nome").val(proprieta.potere_4_nome);
              $("#"+slot+"_pow_5_tipo").val(proprieta.potere_5_tipo);
              $("#"+slot+"_pow_5_valore").val(proprieta.potere_5_valore);
              $("#"+slot+"_pow_5_nome").val(proprieta.potere_5_nome);
              $("#"+slot+"_pow_6_tipo").val(proprieta.potere_6_tipo);
              $("#"+slot+"_pow_6_valore").val(proprieta.potere_6_valore);
              $("#"+slot+"_pow_6_nome").val(proprieta.potere_6_nome);
              $('#'+slot+'_edit_details').show();
          }
        }

        function updateObject(slot) {
            var oggetto = oggetti_build.find((element) => element.slot == slot);
            var proprieta = oggetto.proprieta;
            var bonus = [];

            // Aggiorno i bonus
            oggetti_build.forEach(elem => {
                var b = bonus.find (bon => bon.nome == elem.proprieta.bonus);
                if (b == undefined) {
                  bonus.push ({nome : elem.proprieta.bonus,
                              items : 1,
                              bonus_2p_nome : elem.proprieta.bonus_2p_nome,
                              bonus_2p_valore : elem.proprieta.bonus_2p_valore,
                              bonus_4p_nome : elem.proprieta.bonus_4p_nome,
                              bonus_4p_valore : elem.proprieta.bonus_4p_valore
                              })
                } else {
                  b.items = b.items + 1;
                }
            })

            $("#listaBonus").empty();

            bonus.forEach(elem => {
                if (elem.items >= 4) {
                  AddBonus(elem.nome, '+' + elem.bonus_2p_valore + ' ' + elem.bonus_2p_nome, '+' + elem.bonus_4p_valore + ' ' + elem.bonus_4p_nome);
                } else if (elem.items >= 2) {
                  AddBonus(elem.nome, '+' + elem.bonus_2p_valore + ' ' + elem.bonus_2p_nome, '');
                }
            })            
            
            // Livello percorso
            var liv = $("#"+slot+"_percorso_livello").val();

            oggetto.proprieta.livello_percorso = liv;

            // Nome oggetto
            $("#"+slot).html("<span style='color:rgb(191,191,191)'>[</span>" + getRarita(proprieta.rarita) + "<span style='color:rgb(191,191,191)'>|</span>" + getLimitato(liv,proprieta.livello_percorso_max) + "<span style='color:rgb(191,191,191)'>]</span> " + proprieta.nome);

            var limitato = 0;

            // Aggiorno il conteggio degli oggetti limitati
            $(".percorso_livello").each(function( index ) {
              if ($(this).val() != undefined && $(this).val().length > 0) {
                var opt = $(this).find(":selected");
                limitato = limitato + Number($(opt).attr("limitato"));
              }
            })
            
            $("#oggettiLimitatiMin").text(limitato);
            if (limitato > 36) {
              $("#oggettiLimitatiMin").addClass("limiteSuperato");
            } else {
              $("#oggettiLimitatiMin").removeClass("limiteSuperato");
            }
        }

        function getRarita(rarita){
            var r = rarita.substring(0,1);
            var l;
            var c;

            switch (r) {
              case "A":
                l = "A";
                c = "cyan";
                break;
              case "L":
                l = "L";
                c = "orange";
                break;
              case "E":
                l = "E";
                c = "purple";
                break;
              case "U":
                l = "U";
                c = "yellow";
                break;
              case "S":
                l = "S";
                c = "yellow";
                break;
              case "C":
                l = "T";
                c = "gray";
                break;
              default:
            }
            return ("<span style='color: " + c + ";'>"+l+"</span>");
        }

        function getLimitato(liv, liv_max){
            var limitato = liv;
            if (liv == liv_max) {
              return ("<span style='color: rgb(255,0,255);'>"+limitato+"</span>");
            } else if ((Number(liv)+1) == liv_max || (Number(liv)+2) == liv_max) {
              return ("<span style='color: rgb(255,255,0);'>"+limitato+"</span>");
            } else if ((Number(liv)+3) == liv_max || (Number(liv)+4) == liv_max) {
              return ("<span style='color: rgb(0,255,0);'>"+limitato+"</span>");
            } else {
              return ("<span style='color: rgb(228,228,228);'>"+limitato+"</span>");
            }
        }

        function getLimitatoValue(liv, liv_max){
            if (liv == liv_max) {
              return 3;
            } else if ((Number(liv)+1) == liv_max || (Number(liv)+2) == liv_max) {
              return 2;
            } else if ((Number(liv)+3) == liv_max || (Number(liv)+4) == liv_max) {
              return 1;
            } else {
              return 0;
            }
        }        

        function AddPoteriTipo (nome) {
          $(".sel_potere_tipo").each(function( index ) {
              var opt = document.createElement ("option");
              $(opt).val(nome);
              $(opt).text(nome);
              $(this).append(opt);
          })
        }

        function AddPoteriNome (nome) {
          $(".sel_potere_nome").each(function( index ) {
              var opt = document.createElement ("option");
              $(opt).val(nome);
              $(opt).text(nome);
              $(this).append(opt);
          })
        } 

        function AddBonus (nome, p2, p4) {
            var li_name = document.createElement("li");
            var div_name = document.createElement("div");
            var span_name = document.createElement("span");

            li_name.classList.add("list-group-item", "list", "dynamic-generated");
            div_name.classList.add("info");
            span_name.classList.add("set_name");

            span_name.innerText = nome;

            li_name.appendChild(div_name);
            div_name.appendChild(span_name);

            document.getElementById("listaBonus").appendChild(li_name);

            //2 Pezzi
            if (p2 != undefined && p2.length > 0) {
              var li_2p = document.createElement("li");
              var div_2p = document.createElement("div");
              var span1_2p = document.createElement("span");
              var span2_2p = document.createElement("span");

              li_2p.classList.add("list-group-item", "list", "dynamic-generated");
              div_2p.classList.add("info");
              span1_2p.classList.add("set_pieces");
              span2_2p.classList.add("number_value");

              span1_2p.innerText = "(2 pezzi)";
              span2_2p.innerText = p2;

              li_2p.appendChild(div_2p);
              div_2p.appendChild(span1_2p);
              div_2p.appendChild(span2_2p);
              
              document.getElementById("listaBonus").appendChild(li_2p);
            }

            //4 Pezzi
            if (p4 != undefined && p4.length > 0) {
              var li_4p = document.createElement("li");
              var div_4p = document.createElement("div");
              var span1_4p = document.createElement("span");
              var span2_4p = document.createElement("span");

              li_4p.classList.add("list-group-item", "list", "dynamic-generated");
              div_4p.classList.add("info");
              span1_4p.classList.add("set_pieces");
              span2_4p.classList.add("number_value");

              span1_4p.innerText = "(4 pezzi)";
              span2_4p.innerText = p4;

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

        function SaveBuild () {
          var account = "<?php if ($isLoggedIn) { echo $user['user_name']; } ?>";
          var nome = $("#buildName_edit").val();
          var classe = $("#className_edit").val();
          var note = $("#buildNotes_edit").val();
          var json = JSON.stringify(oggetti_build).replaceAll('"','§');
          var pubblica = $("#buildPubblica").is(":checked") ? 1 : 0;

          if (nome.length == 0) {
            show_error ("Dai un nome alla build");
            return;
          }

          if (classe.length == 0) {
            show_error ("Scegli una classe");
            return;
          }

          ExecSaveBuild(account, nome, classe, note, json, pubblica);
        }

        function ExecSaveBuild(account, nome, classe, note, json, pubblica) {
            fetch('php/save_build.php', {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/json'
                  },
                  body: '{' +
                            '"account" : "'  +  account  + '",' + 
                            '"nome" : "'     +  nome     + '",' + 
                            '"classe" : "'   +  classe   + '",' + 
                            '"note" : "'     +  note     + '",' + 
                            '"json" : "'     +  json     + '",' + 
                            '"pubblica" : "' +  pubblica + '"' +
                        '}' 
            })
            .then(response => { FetchBuilds(); show_info ("Salvataggio eseguito con successo") } )
            .catch(error => console.log("Errore in caricamento: " + error));
        }

        function DeleteBuild () {
          var account = "<?php if ($isLoggedIn) { echo $user['user_name']; } ?>";
          var nome = $("#buildName_edit").val();
          var ExecDeleteBuild = function () {
            fetch('php/delete_build.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                  body: '{' +
                            '"account" : "'  +  account  + '",' + 
                            '"nome" : "'     +  nome     + '"' + 
                        '}'                 
            })
            .then(data => {
                            $("#build").hide();
                            $('#gridContainer').show();
                            show_info("Cancellazione eseguita con successo")
                          })
            .catch(error => show_error("Errore in cancellazione build: " + error));
          };

          show_confirmation_modal("Sei sicuro?", ExecDeleteBuild);
        }

        function SetPubblicaLabel () {
          if ($("#buildPubblica").is(":checked")) {
              $("#buildPubblicaLabel").text("Pubblica");
          } else {
              $("#buildPubblicaLabel").text("Privata");
          }
        }

</script>

</body>

</html>
