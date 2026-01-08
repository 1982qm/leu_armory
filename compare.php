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
    <div class="container-fluid px-4" style="top: 30px; position: relative; width: max-content;">
      <div class="row align-items-start bg-dark text-white mb-4" style="min-height: 800px; max-height: calc(100dvh - 50px); opacity: 97%; padding: 16px;border: 1px solid #495057; border-radius: 0.375rem; margin: 0px;">
          <div class="col-md-auto" style="width: 20rem;">
                <div class="card" style="width: 20rem; border: 0px; background: linear-gradient(black, transparent 70%);">
                    <div class="card-body" style="z-index: 1; max-height: calc(100dvh - 70px);">
                      <!-- PG -->              
                      <select id="selPlayer1" onchange="ShowPlayer('selPlayer1','_1')"></select>                     
                      <h3 id="playerName_1" class="card-title" style="text-shadow: 2px 2px 4px black; margin-top: 15px; cursor: pointer;"></h3>
                      <h5 id="className_1" class="card-title"></h5>
                      <h3 id="avg_eq_level_1" class="card-title" style="position: absolute; color: #00FE1E; top: 65px; right: 20px; text-shadow: 1px 1px 2px black;"></h3>
                      <div style="height: 430px; width: auto; margin-top: -80px; margin-bottom: 95px; align-content: center;" >
                        <img id="classImg_1" class="card-img-top" style="scale: 70%"/>
                      </div>
                      <div class="chart_player">
                        <canvas id="chart_stat" style="width: 300px; height:300px"></canvas>
                      </div>
                    </div>
                  </div>          
          </div>
          <div class="col-md-auto" style="overflow-y: auto; min-height: 780px; max-height: calc(100dvh - 80px)">
            <!--
            <center style="margin: 30px 0px">
              <div class="chart_player">
                <canvas id="chart_stat" style="width: 300px; height:300px"></canvas>
                <canvas id="chart_dmg" style="width: 300px; height:300px"></canvas>
                <canvas id="chart_res" style="width: 300px; height:300px"></canvas>
              </div>
            </center>
            -->
            <div id="scheda_players" class="divFlex divHidden">
              <!-- Player 1 -->
              <div id="div_p1" style="width:100%">
                <div class="card" style="border: 0px; margin-left: 10px;">
                  <div class="card-body" style="padding-right: 0px;">
                    <!-- EQUIPAGGIAMENTO -->
                    <h5 class="card-title" style="white-space: pre; display: block"><span id="oggettiLimitati_1">Oggetti limitati <span id="oggettiLimitatiMin_1"></span>/<span id="oggettiLimitatiMax_1"></span></span> </h5>
                    <ul class="list-group list-group-flush" style="width: max-content; text-align: right">
                      <li class="list-group-item list"><div id="cmp_come_luce_1" class="eqrow_compare"><span id="come_luce_1" class="eq"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_mano_destra_1" class="eqrow_compare"><span id="mano_destra_1" class="eq"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_mano_sinistra_1" class="eqrow_compare"><span id="mano_sinistra_1" class="eq"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_al_collo_1_1" class="eqrow_compare"><span id="al_collo_1_1" class="eq"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_al_collo_2_1" class="eqrow_compare"><span id="al_collo_2_1" class="eq"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_sul_corpo_1" class="eqrow_compare"><span id="sul_corpo_1" class="eq"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_in_testa_1" class="eqrow_compare"><span id="in_testa_1" class="eq"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_sulle_gambe_1" class="eqrow_compare"><span id="sulle_gambe_1" class="eq"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_ai_piedi_1" class="eqrow_compare"><span id="ai_piedi_1" class="eq"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_sulle_mani_1" class="eqrow_compare"><span id="sulle_mani_1" class="eq"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_sulle_braccia_1" class="eqrow_compare"><span id="sulle_braccia_1" class="eq"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_come_scudo_1" class="eqrow_compare"><span id="come_scudo_1" class="eq"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_attorno_al_corpo_1" class="eqrow_compare"><span id="attorno_al_corpo_1" class="eq"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_alla_vita_1" class="eqrow_compare"><span id="alla_vita_1" class="eq"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_polso_destro_1" class="eqrow_compare"><span id="polso_destro_1" class="eq"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_polso_sinistro_1" class="eqrow_compare"><span id="polso_sinistro_1" class="eq"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_impugnato_1" class="eqrow_compare"><span id="impugnato_1" class="eq"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_afferrato_1" class="eqrow_compare"><span id="afferrato_1" class="eq"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_sulla_schiena_1" class="eqrow_compare"><span id="sulla_schiena_1" class="eq"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_orecchio_destro_1" class="eqrow_compare"><span id="orecchio_destro_1" class="eq"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_orecchio_sinistro_1" class="eqrow_compare"><span id="orecchio_sinistro_1" class="eq"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_sul_viso_1" class="eqrow_compare"><span id="sul_viso_1" class="eq"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_incoccato_1" class="eqrow_compare"><span id="incoccato_1" class="eq"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_come_aura_1" class="eqrow_compare"><span id="come_aura_1" class="eq"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                    </ul>
                    <!-- ATTACCHI -->
                    <h5 class="card-title" style="white-space: pre"> </h5>
                    <ul class="list-group list-group-flush" style="text-align: right">
                      <li class="list-group-item list"><div class="compare_info"><span id="num_attacks_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="crit_chance_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="crit_molt_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="arma_princ_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="arma_sec_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                    </ul>  
                    <!-- STATISTICHE -->
                    <h5 class="card-title" style="white-space: pre"> </h5>
                    <ul id="listaStats_1" class="list-group list-group-flush" style="text-align: right">
                      <li class="list-group-item list"><div class="compare_info"><span id="razza_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="hp_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="mana_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="energia_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="danno_fisico_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="potere_magico_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="forza_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="intelligenza_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="saggezza_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="destrezza_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="costituzione_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="carisma_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                    </ul>                  
                    <!-- RESISTENZE -->
                    <h5 class="card-title" style="white-space: pre"> </h5>
                    <ul class="list-group list-group-flush" style="text-align: right">
                      <li class="list-group-item list"><div class="compare_info"><span id="ass_fisico_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="ass_magico_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_impatto_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_perforazione_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_taglio_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_trauma_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_fuoco_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_freddo_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_elettricita_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_acido_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_energia_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_natura_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_psichico_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_lumen_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_umbra_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_caos_1" class="number_value_1"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                    </ul>
                  </div>
                </div>                      
              </div>
              <!-- Label -->
              <div style="width:fit-content">
                <div class="card" style="width: max-content; border: 0px; min-width: 250px;">
                  <div class="card-body" style="padding-left: 0px; padding-right: 0px;">
                    <!-- EQUIPAGGIAMENTO -->
                    <h5 class="card-title" style="text-shadow: 1px 1px 2px black; text-align: center;">Equipaggiamento</h5>
                    <ul class="list-group list-group-flush" style="text-align: center; padding: 0px !important;">
                      <li class="list-group-item list"><div id="cmp_come_luce"><span class="compare_label">come luce</span></div></li>
                      <li class="list-group-item list"><div id="cmp_mano_destra"><span class="compare_label">mano destra</span></div></li>
                      <li class="list-group-item list"><div id="cmp_mano_sinistra"><span class="compare_label">mano sinistra</span></div></li>
                      <li class="list-group-item list"><div id="cmp_al_collo_1"><span class="compare_label">al collo</span></div></li>
                      <li class="list-group-item list"><div id="cmp_al_collo_2"><span class="compare_label">al collo</span></div></li>
                      <li class="list-group-item list"><div id="cmp_sul_corpo"><span class="compare_label">sul corpo</span></div></li>
                      <li class="list-group-item list"><div id="cmp_in_testa"><span class="compare_label">in testa</span></div></li>
                      <li class="list-group-item list"><div id="cmp_sulle_gambe"><span class="compare_label">sulle gambe</span></div></li>
                      <li class="list-group-item list"><div id="cmp_ai_piedi"><span class="compare_label">ai piedi</span></div></li>
                      <li class="list-group-item list"><div id="cmp_sulle_mani"><span class="compare_label">sulle mani</span></div></li>
                      <li class="list-group-item list"><div id="cmp_sulle_braccia"><span class="compare_label">sulle braccia</span></div></li>
                      <li class="list-group-item list"><div id="cmp_come_scudo"><span class="compare_label">come scudo</span></div></li>
                      <li class="list-group-item list"><div id="cmp_attorno_al_corpo"><span class="compare_label">attorno al corpo</span></div></li>
                      <li class="list-group-item list"><div id="cmp_alla_vita"><span class="compare_label">alla vita</span></div></li>
                      <li class="list-group-item list"><div id="cmp_polso_destro"><span class="compare_label">polso destro</span></div></li>
                      <li class="list-group-item list"><div id="cmp_polso_sinistro"><span class="compare_label">polso sinistro</span></div></li>
                      <li class="list-group-item list"><div id="cmp_impugnato"><span class="compare_label">impugnato</span></div></li>
                      <li class="list-group-item list"><div id="cmp_afferrato"><span class="compare_label">afferrato</span></div></li>
                      <li class="list-group-item list"><div id="cmp_sulla_schiena"><span class="compare_label">sulla schiena</span></div></li>
                      <li class="list-group-item list"><div id="cmp_orecchio_destro"><span class="compare_label">orecchio destro</span></div></li>
                      <li class="list-group-item list"><div id="cmp_orecchio_sinistro"><span class="compare_label">orecchio sinistro</span></div></li>
                      <li class="list-group-item list"><div id="cmp_sul_viso"><span class="compare_label">sul viso</span></div></li>
                      <li class="list-group-item list"><div id="cmp_incoccato"><span class="compare_label">incoccato</span></div></li>
                      <li class="list-group-item list"><div id="cmp_come_aura"><span class="compare_label">come aura</span></div></li>
                      <li class="list-group-item list separatore"></li>
                    </ul>
                    <!-- ATTACCHI -->
                    <h5 class="card-title" style="text-shadow: 1px 1px 2px black; text-align: center;">Attacchi</h5>
                    <ul class="list-group list-group-flush" style="text-align: center;">
                      <li class="list-group-item list"><span class="compare_label">Numero attacchi</span></li>
                      <li class="list-group-item list"><span class="compare_label">Chance di critico</span></li>
                      <li class="list-group-item list"><span class="compare_label">Moltiplicatore</span></li>
                      <li class="list-group-item list"><span class="compare_label">Arma Primaria</span></li>
                      <li id="labelArmaSecondaria" class="list-group-item list"><span class="compare_label">Arma Secondaria</span></li>
                      <li class="list-group-item list separatore"></li>
                    </ul>                        
                    <!-- STATISTICHE -->
                    <h5 class="card-title" style="text-shadow: 1px 1px 2px black; text-align: center;">Statistiche</h5>
                    <ul id="listaStatsLabel" class="list-group list-group-flush" style="text-align: center;">
                      <li class="list-group-item list"><span class="compare_label">Razza</span></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><span class="compare_label">HP </span></li>
                      <li class="list-group-item list"><span class="compare_label">Mana</span></li>
                      <li class="list-group-item list"><span class="compare_label">Energia</span></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><span class="compare_label">Danno Fisico</span></li>
                      <li class="list-group-item list"><span class="compare_label">Potere Magico</span></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><span class="compare_label">Forza</span></li>
                      <li class="list-group-item list"><span class="compare_label">Intelligenza</span></li>
                      <li class="list-group-item list"><span class="compare_label">Saggezza</span></li>
                      <li class="list-group-item list"><span class="compare_label">Destrezza</span></li>
                      <li class="list-group-item list"><span class="compare_label">Costituzione</span></li>
                      <li class="list-group-item list"><span class="compare_label">Carisma</span></li>
                      <li class="list-group-item list separatore"></li>
                    </ul>
                    <!-- RESISTENZE -->
                    <h5 class="card-title" style="text-shadow: 1px 1px 2px black; text-align: center;">Resistenze</h5>
                    <ul class="list-group list-group-flush" style="text-align: center;">
                      <li class="list-group-item list"><span class="compare_label">Assorbimento Fisico</span></li>
                      <li class="list-group-item list"><span class="compare_label">Assorbimento Magico</span></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><span class="compare_label">Impatto</span></li>
                      <li class="list-group-item list"><span class="compare_label">Perforazione</span></li>
                      <li class="list-group-item list"><span class="compare_label">Taglio</span></li>
                      <li class="list-group-item list"><span class="compare_label">Trauma</span></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><span class="compare_label">Fuoco</span></li>
                      <li class="list-group-item list"><span class="compare_label">Freddo</span></li>
                      <li class="list-group-item list"><span class="compare_label">Elettricità</span></li>
                      <li class="list-group-item list"><span class="compare_label">Acido</span></li>
                      <li class="list-group-item list"><span class="compare_label">Energia</span></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><span class="compare_label">Natura</span></li>
                      <li class="list-group-item list"><span class="compare_label">Psichico</span></li>
                      <li class="list-group-item list"><span class="compare_label">Lumen</span></li>
                      <li class="list-group-item list"><span class="compare_label">Umbra</span></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><span class="compare_label">Caos</span></li>
                      <li class="list-group-item list separatore"></li>
                    </ul>
                  </div>
                </div>
              </div>
              <!-- Player 2 -->
              <div id="div_p2" style="width:100%">
                <div class="card" style="border: 0px; margin-right: 10px;">
                  <div class="card-body" style="padding-left: 0px;">
                    <!-- EQUIPAGGIAMENTO -->
                    <h5 class="card-title" style="white-space: pre; display: block"> <span id="oggettiLimitati_2">Oggetti limitati <span id="oggettiLimitatiMin_2"></span>/<span id="oggettiLimitatiMax_2"></span></span></h5>
                    <ul class="list-group list-group-flush" style="width: max-content; text-align: left">
                      <li class="list-group-item list"><div id="cmp_come_luce_2" class="eqrow_compare"><span id="come_luce_2" class="eq_2"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_mano_destra_2" class="eqrow_compare"><span id="mano_destra_2" class="eq_2"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_mano_sinistra_2" class="eqrow_compare"><span id="mano_sinistra_2" class="eq_2"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_al_collo_1_2" class="eqrow_compare"><span id="al_collo_1_2" class="eq_2"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_al_collo_2_2" class="eqrow_compare"><span id="al_collo_2_2" class="eq_2"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_sul_corpo_2" class="eqrow_compare"><span id="sul_corpo_2" class="eq_2"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_in_testa_2" class="eqrow_compare"><span id="in_testa_2" class="eq_2"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_sulle_gambe_2" class="eqrow_compare"><span id="sulle_gambe_2" class="eq_2"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_ai_piedi_2" class="eqrow_compare"><span id="ai_piedi_2" class="eq_2"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_sulle_mani_2" class="eqrow_compare"><span id="sulle_mani_2" class="eq_2"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_sulle_braccia_2" class="eqrow_compare"><span id="sulle_braccia_2" class="eq_2"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_come_scudo_2" class="eqrow_compare"><span id="come_scudo_2" class="eq_2"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_attorno_al_corpo_2" class="eqrow_compare"><span id="attorno_al_corpo_2" class="eq_2"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_alla_vita_2" class="eqrow_compare"><span id="alla_vita_2" class="eq_2"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_polso_destro_2" class="eqrow_compare"><span id="polso_destro_2" class="eq_2"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_polso_sinistro_2" class="eqrow_compare"><span id="polso_sinistro_2" class="eq_2"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_impugnato_2" class="eqrow_compare"><span id="impugnato_2" class="eq_2"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_afferrato_2" class="eqrow_compare"><span id="afferrato_2" class="eq_2"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_sulla_schiena_2" class="eqrow_compare"><span id="sulla_schiena_2" class="eq_2"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_orecchio_destro_2" class="eqrow_compare"><span id="orecchio_destro_2" class="eq_2"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_orecchio_sinistro_2" class="eqrow_compare"><span id="orecchio_sinistro_2" class="eq_2"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_sul_viso_2" class="eqrow_compare"><span id="sul_viso_2" class="eq_2"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_incoccato_2" class="eqrow_compare"><span id="incoccato_2" class="eq_2"></span></div></li>
                      <li class="list-group-item list"><div id="cmp_come_aura_2" class="eqrow_compare"><span id="come_aura_2" class="eq_2"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                    </ul>
                    <!-- ATTACCHI -->
                    <h5 class="card-title" style="white-space: pre"> </h5>
                    <ul class="list-group list-group-flush" style="text-align: left">
                      <li class="list-group-item list"><div class="compare_info"><span id="num_attacks_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="crit_chance_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="crit_molt_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="arma_princ_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="arma_sec_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                    </ul>
                    <!-- STATISTICHE -->
                    <h5 class="card-title" style="white-space: pre"> </h5>
                    <ul id="listaStats_2" class="list-group list-group-flush" style="text-align: right">
                      <li class="list-group-item list"><div class="compare_info"><span id="razza_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="hp_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="mana_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="energia_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="danno_fisico_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="potere_magico_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="forza_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="intelligenza_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="saggezza_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="destrezza_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="costituzione_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="carisma_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                    </ul>
                    <!-- RESISTENZE -->
                    <h5 class="card-title" style="white-space: pre"> </h5>
                    <ul class="list-group list-group-flush" style="text-align: right">
                      <li class="list-group-item list"><div class="compare_info"><span id="ass_fisico_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="ass_magico_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_impatto_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_perforazione_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_taglio_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_trauma_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_fuoco_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_freddo_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_elettricita_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_acido_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_energia_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_natura_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_psichico_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_lumen_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_umbra_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                      <li class="list-group-item list"><div class="compare_info"><span id="res_caos_2" class="number_value_2"></span></div></li>
                      <li class="list-group-item list separatore"></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-auto" style="width: 20rem; margin-right: 25px;">
                <div class="card" style="width: 20rem; border: 0px; background: linear-gradient(black, transparent 70%);">
                  <div class="card-body" style="z-index: 1; max-height: calc(100dvh - 70px);">
                    <!-- PG -->
                    <select id="selPlayer2" onchange="ShowPlayer('selPlayer2','_2')"></select>                     
                    <h3 id="playerName_2" class="card-title" style="text-shadow: 2px 2px 4px black; margin-top: 15px; cursor: pointer;"></h3>
                    <h5 id="className_2" class="card-title"></h5>
                    <h3 id="avg_eq_level_2" class="card-title" style="position: absolute; color: #00FE1E; top: 65px; right: 20px; text-shadow: 1px 1px 2px black;"></h3>
                    <div style="height: 430px; width: auto; margin-top: -80px; margin-bottom: 95px; align-content: center;" >
                      <img id="classImg_2" class="card-img-top" style="scale: 70%"/>
                    </div>
                    <div class="chart_dmg">
                      <canvas id="chart_dmg" style="width: 300px; height:300px"></canvas>
                    </div>
                  </div>
                </div>
          </div>
      </div>
    </div>
    
  </main>  

  <script>
        var json_p1;
        var json_p2;
        var optgroupState_p1;
        var optgroupState_p2;
        var act_name_p1 = "";
        var act_name_p2 = "";
        var chart_stat;
        var chart_dmg;

        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var input_p1 = urlParams.get('p1');
        var input_p2 = urlParams.get('p2');

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

        document.addEventListener("DOMContentLoaded", function () {
            Chart.defaults.font.family = "'DejaVu Sans Mono', monospace";
            Chart.defaults.color = "#fff";
            if(input_p1) input_p1 = input_p1.toString().replace(/"/g,"");
            if(input_p2) input_p2 = input_p2.toString().replace(/"/g,"");
            FetchPlayers();
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
          var actual_class = "";
          var class_group_1;
          var class_group_2;

          var def1 = document.createElement("option");
          var def2 = document.createElement("option");
          document.getElementById("selPlayer1").appendChild(def1);
          document.getElementById("selPlayer2").appendChild(def2);

          data.forEach( 
              element => {
                  if (actual_class != element.classe) {
                    actual_class = element.classe;
                    class_group_1 = document.createElement("optgroup");
                    class_group_2 = document.createElement("optgroup");
                    $(class_group_1).attr("label", element.classe);
                    $(class_group_2).attr("label", element.classe);
                    document.getElementById("selPlayer1").appendChild(class_group_1);
                    document.getElementById("selPlayer2").appendChild(class_group_2);
                  }

                  var option1 = document.createElement("option");
                  option1.classList.add("pg_name");
                  option1.innerText = element.nome;
                  $(option1).css("cursor", "pointer");

                  var option2 = document.createElement("option");
                  option2.classList.add("pg_name");
                  option2.innerText = element.nome;
                  $(option2).css("cursor", "pointer");

                  class_group_1.appendChild(option1);
                  class_group_2.appendChild(option2);
              }
            )

          optgroupState_p1 = {};
          optgroupState_p2 = {};

          InitializeStep2("selPlayer1", optgroupState_p1);
          InitializeStep2("selPlayer2", optgroupState_p2);

          $("body").on('click', '.select2-container--open .select2-results__group', function() {
            $(this).siblings().toggle();
            let id = $(this).closest('.select2-results__options').attr('id');
            let index = $('.select2-results__group').index(this);
            if (id == "select2-selPlayer1-results") {
              optgroupState_p1[id][index] = !optgroupState_p1[id][index];
            } else {
              optgroupState_p2[id][index] = !optgroupState_p2[id][index];
            }
          })

          if (input_p1 != undefined) {
            $('#selPlayer1').val(input_p1);
            $('#selPlayer1').trigger('change');
          };
          if (input_p2 != undefined) {
            $('#selPlayer2').val(input_p2);
            $('#selPlayer2').trigger('change');
          }
        }

        function InitializeStep2 (select, optgroupState) {
            $("#"+select).select2({
              placeholder: "Seleziona un pg",
              language: "it"
            });

            $('#'+select).on('select2:open', function() {
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

        function ShowPlayer (selId, suffix) {
          var nome = $('#'+selId).find(":selected").text();
          var opt;
          if (suffix == "_1") {
            $('#selPlayer2 option').removeAttr('disabled');
            $('#selPlayer2 option').css("cursor", "pointer");
            opt = $('#selPlayer2 option').filter(function () { return $(this).text() == nome; });
            act_name_p1 = nome;
          } else {
            $('#selPlayer1 option').removeAttr('disabled');
            $('#selPlayer1 option').css("cursor", "pointer");
            opt = $('#selPlayer1 option').filter(function () { return $(this).text() == nome; });
            act_name_p2 = nome;
          }
          $(opt[0]).attr("disabled", true);
          $(opt[0]).css("cursor", "default");
          FetchPlayerDetails(nome, suffix);
        }

        function GoToPlayer () {
          var url = location.origin+location.pathname;
          url=url.replaceAll("compare.php","");
          url=url+'players.php?name="'+this.innerText+'"';
          window.location.href = url;
        }

        function FetchPlayerDetails (nome, suffix) {
          fetch('php/load_player_details_by_name.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json'
              },
              body: '{"nome" : "' + nome + '"}'
          })
          .then(response => response.json())
          .then(data => LoadPlayerDetails(data, suffix))
          .catch(error => console.log("Errore in caricamento: " + error));
        }

        function LoadPlayerDetails (data, suffix) {
          $('.dynamic-generated'+suffix).remove();

          var json = JSON.parse(data.json);
          if (suffix == "_1") {
            json_p1 = json;
          } else {
            json_p2 = json;
          }

          <?php if ($isLoggedIn && $user['user_type'] == "1") {?>
            console.log(json);
          <?php } ?>

          setText("playerName"+suffix, json.player.nome);
          $("#playerName"+suffix).click(GoToPlayer);
          setText("avg_eq_level"+suffix, json.player.avg_eq_level);

          if(json.player.classe != undefined) {
              if(json.player.main_class != undefined) {
                setText("className"+suffix, json.player.classe + ' (' + json.player.main_class + ')');
              } else {
                setText("className"+suffix, json.player.classe);
              }
          }

          setPlayerImg(json, data.custom_image_path, "classImg"+suffix);

          setText("oggettiLimitatiMin"+suffix, json.player.oggLimitati);
          setText("oggettiLimitatiMax"+suffix, json.player.oggLimitatiMax);

          if (json.player.oggLimitati != undefined) {
            $("#oggettiLimitati"+suffix).show();
          } else {
            $("#oggettiLimitati"+suffix).hide();
          }

          if (json_p1 != undefined && json_p2 != undefined) {
            $(".number_value_1").removeClass("highValue");
            $(".number_value_2").removeClass("highValue");            
            // EQUIPAGGIAMENTO
            $('.eq-dynamic-generated').remove();            
            updateEquip("come luce");
            updateEquip("mano destra");
            updateEquip("mano sinistra");
            updateEquip("al collo 1");
            updateEquip("al collo 2");
            updateEquip("sul corpo");
            updateEquip("in testa");
            updateEquip("sulle gambe");
            updateEquip("ai piedi");
            updateEquip("sulle mani");
            updateEquip("sulle braccia");
            updateEquip("come scudo");
            updateEquip("attorno al corpo");
            updateEquip("alla vita");
            updateEquip("polso destro");
            updateEquip("polso sinistro");
            updateEquip("impugnato");
            updateEquip("afferrato");
            updateEquip("sulla schiena");
            updateEquip("orecchio destro");
            updateEquip("orecchio sinistro");
            updateEquip("sul viso");
            updateEquip("incoccato");
            updateEquip("come aura");
            // ATTACCHI
            updateAttacks();
            // STATISTICHE
            updateStatList();
            // RESISTENZE
            updateRes();
            // Creo il grafico Stat
            if (chart_stat) chart_stat.destroy();
            chart_stat = CreaChartStat('chart_stat', json_p1, json_p2, true);
            if (chart_dmg) chart_dmg.destroy();
            chart_dmg = CreaChartDmg('chart_dmg', json_p1, json_p2);
            // VISUALIZZO IL DIV PADRE
            $("#scheda_players").removeClass("divHidden");
          }
        }

        function updateEquip(slot) {
          if (Object.keys(json_p1.equipment).length > 0) {
            $("#"+slot.replaceAll(" ","_")+"_1").html(getEq(json_p1.equipment[slot],"_1"));
          }
          if (Object.keys(json_p2.equipment).length > 0) {
            $("#"+slot.replaceAll(" ","_")+"_2").html(getEq(json_p2.equipment[slot],"_2"));
          }
          if ((Object.keys(json_p1.equipment).length > 0) &&  (Object.keys(json_p2.equipment).length > 0)) {
            updatePowerCompare (slot);
          }
        }

        function updatePowerCompare(slot) {
          var idx_p1 = 0;
          var idx_p2 = 0;
          var idx_orig_p1 = 0;
          var idx_orig_p2 = 0;          
          var array_p1 = [];
          var array_p2 = [];
          var array_finale = [];
          var power;
          var valore1="";
          var valore2="";
          var idx;
          var slotId = slot.toString().replaceAll(" ","_");

          if (json_p1.equipment[slot].powers != undefined && json_p1.equipment[slot].powers.length > 0) {
            array_p1 = json_p1.equipment[slot].powers;
          }

          if (json_p2.equipment[slot].powers != undefined && json_p2.equipment[slot].powers.length > 0) {
            array_p2 = json_p2.equipment[slot].powers;
          }

          // AC
          valore1 = " ";
          valore2 = " ";
          if (json_p1.equipment[slot].ac != undefined) valore1 = json_p1.equipment[slot].ac;
          if (json_p2.equipment[slot].ac != undefined) valore2 = json_p2.equipment[slot].ac;
          if (valore1 != " " || valore2 != " ") array_finale.push ({power: "Ac", valore1: valore1, valore2: valore2});

          //DICE
          valore1 = " ";
          valore2 = " ";
          if (json_p1.equipment[slot].dice != undefined) valore1 = json_p1.equipment[slot].dice;
          if (json_p2.equipment[slot].dice != undefined) valore2 = json_p2.equipment[slot].dice;
          if (valore1 != " " || valore2 != " ") array_finale.push ({power: "Dice", valore1: valore1, valore2: valore2});

          while (true) {
            if (idx_p1 >= array_p1.length && idx_p2 >= array_p2.length) break;
            power = "";
            idx_orig_p1 = idx_p1;
            idx_orig_p2 = idx_p2;

            if (array_p1[idx_p1] == undefined && array_p2[idx_p2] != undefined) {
              power = array_p2[idx_p2].power;
              idx_p2++;
            } else if (array_p1[idx_p1] != undefined && array_p2[idx_p2] == undefined) {
              power = array_p1[idx_p1].power;
              idx_p1++;
            } else if (array_p1[idx_p1].power == array_p2[idx_p2].power) {
              power = array_p1[idx_p1].power;
              idx_p1++;
              idx_p2++;
            } else if (array_p1[idx_p1].power < array_p2[idx_p2].power) {
              power = array_p1[idx_p1].power;
              idx_p1++;
            } else {
              power = array_p2[idx_p2].power;
              idx_p2++;
            }

            valore1 = " ";
            valore2 = " ";

            if (array_p1[idx_orig_p1] != undefined && array_p1[idx_orig_p1].power != undefined && array_p1[idx_orig_p1].power == power) {
              valore1 = array_p1[idx_orig_p1].value;
            }
            if (array_p2[idx_orig_p2] != undefined && array_p2[idx_orig_p2].power != undefined && array_p2[idx_orig_p2].power == power) {
              valore2 = array_p2[idx_orig_p2].value;
            }

            idx = array_finale.findIndex((element) => element.power == power);
            if (idx >= 0) {
              if (array_finale[idx].valore1 == " ") {
                array_finale[idx].valore1 = valore1;
              }
              if (array_finale[idx].valore2 == " ") {
                array_finale[idx].valore2 = valore2;
              }
            } else {
              array_finale.push ({power: power, valore1: valore1, valore2: valore2});
            }
          }

          array_finale.reverse().forEach (
            element => {
              var li_label = document.createElement("li");
              var span_label = document.createElement("span");
              li_label.classList.add("list-group-item", "list", slotId+"_compare_div", "eq_power_compare", "eq-dynamic-generated", "dynamic-generated");
              $(li_label).attr("slot_compare",slotId+"_compare_div");
              span_label.classList.add("compare_label");
              span_label.innerText = element.power;
              li_label.appendChild(span_label);
              //document.getElementById(slotId+"list_label").appendChild(li_label);
              $("#cmp_"+slotId).parent().after(li_label);
            
              var li_v_1 = document.createElement("li");
              var div_v_1 = document.createElement("div");
              var span_v_1 = document.createElement("span");
              li_v_1.classList.add("list-group-item", "list", slotId+"_compare_div", "eq_power_compare", "eq-dynamic-generated", "dynamic-generated");
              div_v_1.classList.add("compare_info");
              span_v_1.classList.add("number_value_1");
              if (element.power == "Potere Speciale") {
                span_v_1.innerText = findSpecialPower(element.valore1)
              } else if (element.power == "Incantesimo su Arma") {
                span_v_1.innerText = findWeaponSpell(element.valore1)
              } else {
                span_v_1.innerText = element.valore1;
              }
              li_v_1.appendChild(div_v_1);
              div_v_1.appendChild(span_v_1);
              //document.getElementById(slotId+"list_p1").appendChild(li_v_1);
              $("#cmp_"+slotId+"_1").parent().after(li_v_1);

              var li_v_2 = document.createElement("li");
              var div_v_2 = document.createElement("div");
              var span_v_2 = document.createElement("span");
              li_v_2.classList.add("list-group-item", "list", slotId+"_compare_div", "eq_power_compare", "eq-dynamic-generated", "dynamic-generated");
              div_v_2.classList.add("compare_info");
              span_v_2.classList.add("number_value_2");
              if (element.power == "Potere Speciale") {
                span_v_2.innerText = findSpecialPower(element.valore2)
              } else if (element.power == "Incantesimo su Arma") {
                span_v_2.innerText = findWeaponSpell(element.valore2)
              } else {
                span_v_2.innerText = element.valore2;
              }
              li_v_2.appendChild(div_v_2);
              div_v_2.appendChild(span_v_2);
              //document.getElementById(slotId+"list_p2").appendChild(li_v_2);
              $("#cmp_"+slotId+"_2").parent().after(li_v_2);

              if (element.power != "Potere Speciale" && element.power != "Incantesimo su Arma") {
                if (element.power == "Dice") {
                  var dice1 = element.valore1.toString().split("d");
                  var dice2 = element.valore2.toString().split("d");
                  var val1 = ((parseFloat(isNull(dice1[0],'0')) * parseFloat(isNull(dice1[1],'0')) + parseFloat(isNull(dice1[0],'0')))/2);
                  var val2 = ((parseFloat(isNull(dice2[0],'0')) * parseFloat(isNull(dice2[1],'0')) + parseFloat(isNull(dice2[0],'0')))/2);
                  if (val1 > val2) span_v_1.classList.add("highValue");
                  if (val1 < val2) span_v_2.classList.add("highValue");
                } else {
                    if (parseFloat(isNull(element.valore1,'0')) > parseFloat(isNull(element.valore2,'0'))) span_v_1.classList.add("highValue");
                    if (parseFloat(isNull(element.valore1,'0')) < parseFloat(isNull(element.valore2,'0'))) span_v_2.classList.add("highValue");
                }
              }
            }
          )

          $("#cmp_"+slotId).css('custor', 'normal');
          $("#cmp_"+slotId).unbind('click');

          if (array_finale.length > 0) {
            // Aggiungo l'evento
            $("#cmp_"+slotId).click(function () {
              var myclass = '.'+this.id.toString().replaceAll("cmp_", "")+"_compare_div";
              $(".eq-dynamic-generated:not("+myclass+")").hide();
              $(myclass).toggle();
            });
            // Aggiungo l'evento
            $(".eq_power_compare[slot_compare='"+slotId+"_compare_div']").click(function () {
              var myclass = '.'+$(this).attr("slot_compare");
              $(".eq-dynamic-generated:not("+myclass+")").hide();
              $(myclass).toggle();
            });            
            $("#cmp_"+slotId).css('cursor', 'pointer');
            $(".eq_power_compare[slot_compare='"+slotId+"_compare_div']").css('cursor', 'pointer');
            $("."+slotId+"_compare_div").hide();
          }
        }

        function updateStatList () {
          var idx_p1 = 0;
          var idx_p2 = 0;
          var idx_orig_p1 = 0;
          var idx_orig_p2 = 0;          
          var array_p1 = [];
          var array_p2 = [];
          var array_finale = [];
          var nome;
          var valore1="";
          var valore2="";
          var idx;

          $('.stat-dynamic-generated').remove();

          // Statistiche P1
          setText("razza_1", json_p1.player.razza);
          setText("hp_1", json_p1.player.hp);
          setText("mana_1", json_p1.player.mana);
          setText("energia_1", json_p1.player.energia);

          setText("danno_fisico_1", json_p1.player.dannoFisico);
          setText("potere_magico_1", json_p1.player.potereMagico);          
          
          setText("forza_1", json_p1.player.forza);
          setText("intelligenza_1", json_p1.player.intelligenza);
          setText("saggezza_1", json_p1.player.saggezza);
          setText("destrezza_1", json_p1.player.destrezza);
          setText("costituzione_1", json_p1.player.costituzione);
          setText("carisma_1", json_p1.player.carisma);
          // Statistiche P2
          setText("razza_2", json_p2.player.razza);
          setText("hp_2", json_p2.player.hp);
          setText("mana_2", json_p2.player.mana);
          setText("energia_2", json_p2.player.energia);

          setText("danno_fisico_2", json_p2.player.dannoFisico);
          setText("potere_magico_2", json_p2.player.potereMagico);          

          setText("forza_2", json_p2.player.forza);
          setText("intelligenza_2", json_p2.player.intelligenza);
          setText("saggezza_2", json_p2.player.saggezza);
          setText("destrezza_2", json_p2.player.destrezza);
          setText("costituzione_2", json_p2.player.costituzione);
          setText("carisma_2", json_p2.player.carisma);
          // hilight valore maggiore p1
          if (parseFloat(isNull($("#hp_1").text(),'0'))               > parseFloat(isNull($("#hp_2").text(),'0'))               ) $("#hp_1").addClass("highValue");
          if (parseFloat(isNull($("#mana_1").text(),'0'))             > parseFloat(isNull($("#mana_2").text(),'0'))             ) $("#mana_1").addClass("highValue");
          if (parseFloat(isNull($("#energia_1").text(),'0'))          > parseFloat(isNull($("#energia_2").text(),'0'))          ) $("#energia_1").addClass("highValue");
          if (parseFloat(isNull($("#danno_fisico_1").text(),'0'))     > parseFloat(isNull($("#danno_fisico_2").text(),'0'))     ) $("#danno_fisico_1").addClass("highValue");
          if (parseFloat(isNull($("#potere_magico_1").text(),'0'))    > parseFloat(isNull($("#potere_magico_2").text(),'0'))    ) $("#potere_magico_1").addClass("highValue");
          if (parseFloat(isNull($("#forza_1").text(),'0'))            > parseFloat(isNull($("#forza_2").text(),'0'))            ) $("#forza_1").addClass("highValue");
          if (parseFloat(isNull($("#intelligenza_1").text(),'0'))     > parseFloat(isNull($("#intelligenza_2").text(),'0'))     ) $("#intelligenza_1").addClass("highValue");
          if (parseFloat(isNull($("#saggezza_1").text(),'0'))         > parseFloat(isNull($("#saggezza_2").text(),'0'))         ) $("#saggezza_1").addClass("highValue");
          if (parseFloat(isNull($("#destrezza_1").text(),'0'))        > parseFloat(isNull($("#destrezza_2").text(),'0'))        ) $("#destrezza_1").addClass("highValue");
          if (parseFloat(isNull($("#costituzione_1").text(),'0'))     > parseFloat(isNull($("#costituzione_2").text(),'0'))     ) $("#costituzione_1").addClass("highValue");
          if (parseFloat(isNull($("#carisma_1").text(),'0'))          > parseFloat(isNull($("#carisma_2").text(),'0'))          ) $("#carisma_1").addClass("highValue");
          // hilight valore maggiore p2
          if (parseFloat(isNull($("#hp_2").text(),'0'))               > parseFloat(isNull($("#hp_1").text(),'0'))               ) $("#hp_2").addClass("highValue");
          if (parseFloat(isNull($("#mana_2").text(),'0'))             > parseFloat(isNull($("#mana_1").text(),'0'))             ) $("#mana_2").addClass("highValue");
          if (parseFloat(isNull($("#energia_2").text(),'0'))          > parseFloat(isNull($("#energia_1").text(),'0'))          ) $("#energia_2").addClass("highValue");
          if (parseFloat(isNull($("#danno_fisico_2").text(),'0'))     > parseFloat(isNull($("#danno_fisico_1").text(),'0'))     ) $("#danno_fisico_2").addClass("highValue");
          if (parseFloat(isNull($("#potere_magico_2").text(),'0'))    > parseFloat(isNull($("#potere_magico_1").text(),'0'))    ) $("#potere_magico_2").addClass("highValue");
          if (parseFloat(isNull($("#forza_2").text(),'0'))            > parseFloat(isNull($("#forza_1").text(),'0'))            ) $("#forza_2").addClass("highValue");
          if (parseFloat(isNull($("#intelligenza_2").text(),'0'))     > parseFloat(isNull($("#intelligenza_1").text(),'0'))     ) $("#intelligenza_2").addClass("highValue");
          if (parseFloat(isNull($("#saggezza_2").text(),'0'))         > parseFloat(isNull($("#saggezza_1").text(),'0'))         ) $("#saggezza_2").addClass("highValue");
          if (parseFloat(isNull($("#destrezza_2").text(),'0'))        > parseFloat(isNull($("#destrezza_1").text(),'0'))        ) $("#destrezza_2").addClass("highValue");
          if (parseFloat(isNull($("#costituzione_2").text(),'0'))     > parseFloat(isNull($("#costituzione_1").text(),'0'))     ) $("#costituzione_2").addClass("highValue");
          if (parseFloat(isNull($("#carisma_2").text(),'0'))          > parseFloat(isNull($("#carisma_1").text(),'0'))          ) $("#carisma_2").addClass("highValue");

          if (json_p1.statistiche != undefined && json_p1.statistiche.length > 0) {
            array_p1 = json_p1.statistiche;
          }

          if (json_p2.statistiche != undefined && json_p2.statistiche.length > 0) {
            array_p2 = json_p2.statistiche;
          }

          while (true) {
            if (idx_p1 >= array_p1.length && idx_p2 >= array_p2.length) break;
            if (array_p1[idx_p1] != undefined && array_p1[idx_p1].nome.startsWith("Resistenza")) {
              idx_p1++;
              continue;
            }
            if (array_p2[idx_p2] != undefined && array_p2[idx_p2].nome.startsWith("Resistenza")) {
              idx_p2++;
              continue;
            }
            nome = "";
            idx_orig_p1 = idx_p1;
            idx_orig_p2 = idx_p2;

            if (array_p1[idx_p1] == undefined && array_p2[idx_p2] != undefined) {
              nome = array_p2[idx_p2].nome;
              idx_p2++;
            } else if (array_p1[idx_p1] != undefined && array_p2[idx_p2] == undefined) {
              nome = array_p1[idx_p1].nome;
              idx_p1++;
            } else if (array_p1[idx_p1].nome == array_p2[idx_p2].nome) {
              nome = array_p1[idx_p1].nome;
              idx_p1++;
              idx_p2++;
            } else if (array_p1[idx_p1].nome < array_p2[idx_p2].nome) {
              nome = array_p1[idx_p1].nome;
              idx_p1++;
            } else {
              nome = array_p2[idx_p2].nome;
              idx_p2++;
            }

            valore1 = " ";
            valore2 = " ";

            if (array_p1[idx_orig_p1] != undefined && array_p1[idx_orig_p1].nome != undefined && array_p1[idx_orig_p1].nome == nome) {
              valore1 = array_p1[idx_orig_p1].valore;
            }
            if (array_p2[idx_orig_p2] != undefined && array_p2[idx_orig_p2].nome != undefined && array_p2[idx_orig_p2].nome == nome) {
              valore2 = array_p2[idx_orig_p2].valore;
            }

            idx = array_finale.findIndex((element) => element.nome == nome);
            if (idx >= 0) {
              if (array_finale[idx].valore1 == " ") {
                array_finale[idx].valore1 = valore1;
              }
              if (array_finale[idx].valore2 == " ") {
                array_finale[idx].valore2 = valore2;
              }
            } else {
              array_finale.push ({nome: nome, valore1: valore1, valore2: valore2});
            }
          }

          array_finale.forEach (
            element => {
              var li_label = document.createElement("li");
              var span_label = document.createElement("span");

              li_label.classList.add("list-group-item", "list", "stat-dynamic-generated", "dynamic-generated");
              span_label.classList.add("compare_label");
              $(span_label).attr("stat", element.nome);

              span_label.innerText = element.nome;

              li_label.appendChild(span_label);

              document.getElementById("listaStatsLabel").appendChild(li_label);
            
              var li_v_1 = document.createElement("li");
              var div_v_1 = document.createElement("div");
              var span_v_1 = document.createElement("span");

              li_v_1.classList.add("list-group-item", "list", "stat-dynamic-generated", "dynamic-generated");
              div_v_1.classList.add("compare_info");
              span_v_1.classList.add("number_value_1");

              span_v_1.innerText = element.valore1;

              li_v_1.appendChild(div_v_1);
              div_v_1.appendChild(span_v_1);

              document.getElementById("listaStats_1").appendChild(li_v_1);

              var li_v_2 = document.createElement("li");
              var div_v_2 = document.createElement("div");
              var span_v_2 = document.createElement("span");

              li_v_2.classList.add("list-group-item", "list", "stat-dynamic-generated", "dynamic-generated");
              div_v_2.classList.add("compare_info");
              span_v_2.classList.add("number_value_2");

              span_v_2.innerText = element.valore2;

              li_v_2.appendChild(div_v_2);
              div_v_2.appendChild(span_v_2);
           
              document.getElementById("listaStats_2").appendChild(li_v_2);

              if (parseFloat(isNull(element.valore1,'0')) > parseFloat(isNull(element.valore2,'0'))) span_v_1.classList.add("highValue");
              if (parseFloat(isNull(element.valore1,'0')) < parseFloat(isNull(element.valore2,'0'))) span_v_2.classList.add("highValue");
            }
          )

          // Alla fine aggiunto un separatore
          var li = document.createElement("li");
          li.classList.add("list-group-item", "list", "separatore", "stat-dynamic-generated", "dynamic-generated");
          document.getElementById("listaStatsLabel").appendChild(li);

          // Alla fine aggiunto un separatore _P1
          var li_p1 = document.createElement("li");
          li_p1.classList.add("list-group-item", "list", "separatore", "stat-dynamic-generated", "dynamic-generated");
          document.getElementById("listaStats_1").appendChild(li_p1);
          
          // Alla fine aggiunto un separatore _P2
          var li_p2 = document.createElement("li");
          li_p2.classList.add("list-group-item", "list", "separatore", "stat-dynamic-generated", "dynamic-generated");
          document.getElementById("listaStats_2").appendChild(li_p2);
        }

        function updateRes() {
          // RESISTENZE - P1
          setText("ass_fisico_1", json_p1.player.assorbimento_fisico,"%");
          setText("ass_magico_1", json_p1.player.assorbimento_magico,"%");
          setText("res_impatto_1", getResistenza(json_p1.resistenze, "Impatto"));
          setText("res_perforazione_1", getResistenza(json_p1.resistenze, "Perforazione"));
          setText("res_taglio_1", getResistenza(json_p1.resistenze, "Taglio"));
          setText("res_trauma_1", getResistenza(json_p1.resistenze, "Trauma"));
          setText("res_fuoco_1", getResistenza(json_p1.resistenze, "Fuoco"));
          setText("res_freddo_1", getResistenza(json_p1.resistenze, "Freddo"));
          setText("res_elettricita_1", getResistenza(json_p1.resistenze, "Elettricita"));
          setText("res_acido_1", getResistenza(json_p1.resistenze, "Acido"));
          setText("res_energia_1", getResistenza(json_p1.resistenze, "Energia"));
          setText("res_natura_1", getResistenza(json_p1.resistenze, "Natura"));
          setText("res_psichico_1", getResistenza(json_p1.resistenze, "Psichico"));
          setText("res_lumen_1", getResistenza(json_p1.resistenze, "Lumen"));
          setText("res_umbra_1", getResistenza(json_p1.resistenze, "Umbra"));
          setText("res_caos_1", getResistenza(json_p1.resistenze, "Caos"));
          // RESISTENZE - P2
          setText("ass_fisico_2", json_p2.player.assorbimento_fisico,"%");
          setText("ass_magico_2", json_p2.player.assorbimento_magico,"%");
          setText("res_impatto_2", getResistenza(json_p2.resistenze, "Impatto"));
          setText("res_perforazione_2", getResistenza(json_p2.resistenze, "Perforazione"));
          setText("res_taglio_2", getResistenza(json_p2.resistenze, "Taglio"));
          setText("res_trauma_2", getResistenza(json_p2.resistenze, "Trauma"));
          setText("res_fuoco_2", getResistenza(json_p2.resistenze, "Fuoco"));
          setText("res_freddo_2", getResistenza(json_p2.resistenze, "Freddo"));
          setText("res_elettricita_2", getResistenza(json_p2.resistenze, "Elettricita"));
          setText("res_acido_2", getResistenza(json_p2.resistenze, "Acido"));
          setText("res_energia_2", getResistenza(json_p2.resistenze, "Energia"));
          setText("res_natura_2", getResistenza(json_p2.resistenze, "Natura"));
          setText("res_psichico_2", getResistenza(json_p2.resistenze, "Psichico"));
          setText("res_lumen_2", getResistenza(json_p2.resistenze, "Lumen"));
          setText("res_umbra_2", getResistenza(json_p2.resistenze, "Umbra"));
          setText("res_caos_2", getResistenza(json_p2.resistenze, "Caos"));  
          // Le resistenze le devo splittare per togliere la percentuale
          if (parseFloat(isNull($("#ass_fisico_1").text(),'0'))                     > parseFloat(isNull($("#ass_fisico_2").text(),'0'))                     ) $("#ass_fisico_1").addClass("highValue");
          if (parseFloat(isNull($("#ass_magico_1").text(),'0'))                     > parseFloat(isNull($("#ass_magico_2").text(),'0'))                     ) $("#ass_magico_1").addClass("highValue");
          if (parseFloat(isNull($("#res_impatto_1").text().split(" ")[0],'0'))      > parseFloat(isNull($("#res_impatto_2").text().split(" ")[0],'0'))      ) $("#res_impatto_1").addClass("highValue");
          if (parseFloat(isNull($("#res_perforazione_1").text().split(" ")[0],'0')) > parseFloat(isNull($("#res_perforazione_2").text().split(" ")[0],'0')) ) $("#res_perforazione_1").addClass("highValue");
          if (parseFloat(isNull($("#res_taglio_1").text().split(" ")[0],'0'))       > parseFloat(isNull($("#res_taglio_2").text().split(" ")[0],'0'))       ) $("#res_taglio_1").addClass("highValue");
          if (parseFloat(isNull($("#res_trauma_1").text().split(" ")[0],'0'))       > parseFloat(isNull($("#res_trauma_2").text().split(" ")[0],'0'))       ) $("#res_trauma_1").addClass("highValue");
          if (parseFloat(isNull($("#res_fuoco_1").text().split(" ")[0],'0'))        > parseFloat(isNull($("#res_fuoco_2").text().split(" ")[0],'0'))        ) $("#res_fuoco_1").addClass("highValue");
          if (parseFloat(isNull($("#res_freddo_1").text().split(" ")[0],'0'))       > parseFloat(isNull($("#res_freddo_2").text().split(" ")[0],'0'))       ) $("#res_freddo_1").addClass("highValue");
          if (parseFloat(isNull($("#res_elettricita_1").text().split(" ")[0],'0'))  > parseFloat(isNull($("#res_elettricita_2").text().split(" ")[0],'0'))  ) $("#res_elettricita_1").addClass("highValue");
          if (parseFloat(isNull($("#res_acido_1").text().split(" ")[0],'0'))        > parseFloat(isNull($("#res_acido_2").text().split(" ")[0],'0'))        ) $("#res_acido_1").addClass("highValue");
          if (parseFloat(isNull($("#res_energia_1").text().split(" ")[0],'0'))      > parseFloat(isNull($("#res_energia_2").text().split(" ")[0],'0'))      ) $("#res_energia_1").addClass("highValue");
          if (parseFloat(isNull($("#res_natura_1").text().split(" ")[0],'0'))       > parseFloat(isNull($("#res_natura_2").text().split(" ")[0],'0'))       ) $("#res_natura_1").addClass("highValue");
          if (parseFloat(isNull($("#res_psichico_1").text().split(" ")[0],'0'))     > parseFloat(isNull($("#res_psichico_2").text().split(" ")[0],'0'))     ) $("#res_psichico_1").addClass("highValue");
          if (parseFloat(isNull($("#res_lumen_1").text().split(" ")[0],'0'))        > parseFloat(isNull($("#res_lumen_2").text().split(" ")[0],'0'))        ) $("#res_lumen_1").addClass("highValue");
          if (parseFloat(isNull($("#res_umbra_1").text().split(" ")[0],'0'))        > parseFloat(isNull($("#res_umbra_2").text().split(" ")[0],'0'))        ) $("#res_umbra_1").addClass("highValue");
          if (parseFloat(isNull($("#res_caos_1").text().split(" ")[0],'0'))         > parseFloat(isNull($("#res_caos_2").text().split(" ")[0],'0'))         ) $("#res_caos_1").addClass("highValue");
          // Le resistenze le devo splittare per togliere la percentuale
          if (parseFloat(isNull($("#ass_fisico_2").text(),'0'))                     > parseFloat(isNull($("#ass_fisico_1").text(),'0'))                     ) $("#ass_fisico_2").addClass("highValue");
          if (parseFloat(isNull($("#ass_magico_2").text(),'0'))                     > parseFloat(isNull($("#ass_magico_1").text(),'0'))                     ) $("#ass_magico_2").addClass("highValue");
          if (parseFloat(isNull($("#res_impatto_2").text().split(" ")[0],'0'))      > parseFloat(isNull($("#res_impatto_1").text().split(" ")[0],'0'))      ) $("#res_impatto_2").addClass("highValue");
          if (parseFloat(isNull($("#res_perforazione_2").text().split(" ")[0],'0')) > parseFloat(isNull($("#res_perforazione_1").text().split(" ")[0],'0')) ) $("#res_perforazione_2").addClass("highValue");
          if (parseFloat(isNull($("#res_taglio_2").text().split(" ")[0],'0'))       > parseFloat(isNull($("#res_taglio_1").text().split(" ")[0],'0'))       ) $("#res_taglio_2").addClass("highValue");
          if (parseFloat(isNull($("#res_trauma_2").text().split(" ")[0],'0'))       > parseFloat(isNull($("#res_trauma_1").text().split(" ")[0],'0'))       ) $("#res_trauma_2").addClass("highValue");
          if (parseFloat(isNull($("#res_fuoco_2").text().split(" ")[0],'0'))        > parseFloat(isNull($("#res_fuoco_1").text().split(" ")[0],'0'))        ) $("#res_fuoco_2").addClass("highValue");
          if (parseFloat(isNull($("#res_freddo_2").text().split(" ")[0],'0'))       > parseFloat(isNull($("#res_freddo_1").text().split(" ")[0],'0'))       ) $("#res_freddo_2").addClass("highValue");
          if (parseFloat(isNull($("#res_elettricita_2").text().split(" ")[0],'0'))  > parseFloat(isNull($("#res_elettricita_1").text().split(" ")[0],'0'))  ) $("#res_elettricita_2").addClass("highValue");
          if (parseFloat(isNull($("#res_acido_2").text().split(" ")[0],'0'))        > parseFloat(isNull($("#res_acido_1").text().split(" ")[0],'0'))        ) $("#res_acido_2").addClass("highValue");
          if (parseFloat(isNull($("#res_energia_2").text().split(" ")[0],'0'))      > parseFloat(isNull($("#res_energia_1").text().split(" ")[0],'0'))      ) $("#res_energia_2").addClass("highValue");
          if (parseFloat(isNull($("#res_natura_2").text().split(" ")[0],'0'))       > parseFloat(isNull($("#res_natura_1").text().split(" ")[0],'0'))       ) $("#res_natura_2").addClass("highValue");
          if (parseFloat(isNull($("#res_psichico_2").text().split(" ")[0],'0'))     > parseFloat(isNull($("#res_psichico_1").text().split(" ")[0],'0'))     ) $("#res_psichico_2").addClass("highValue");
          if (parseFloat(isNull($("#res_lumen_2").text().split(" ")[0],'0'))        > parseFloat(isNull($("#res_lumen_1").text().split(" ")[0],'0'))        ) $("#res_lumen_2").addClass("highValue");
          if (parseFloat(isNull($("#res_umbra_2").text().split(" ")[0],'0'))        > parseFloat(isNull($("#res_umbra_1").text().split(" ")[0],'0'))        ) $("#res_umbra_2").addClass("highValue");
          if (parseFloat(isNull($("#res_caos_2").text().split(" ")[0],'0'))         > parseFloat(isNull($("#res_caos_1").text().split(" ")[0],'0'))         ) $("#res_caos_2").addClass("highValue");          
      
        }

        function updateAttacks () {
          // ATTACCHI P1
          setText("crit_chance_1", json_p1.player.critico_chance,"%");
          setText("crit_molt_1", json_p1.player.critico_moltiplicatore,"%");
          setText("num_attacks_1", json_p1.player.num_attacchi);
          setText("arma_princ_1"," ");
          setText("arma_sec_1"," ");
          // ATTACCHI P2
          setText("crit_chance_2", json_p2.player.critico_chance,"%");
          setText("crit_molt_2", json_p2.player.critico_moltiplicatore,"%");
          setText("num_attacks_2", json_p2.player.num_attacchi);
          setText("arma_princ_2"," ");
          setText("arma_sec_2"," ");

          if (json_p1.attacks != undefined && json_p1.attacks.length > 0) {
              var media_princ = 0;
              var media_sec = 0;
              json_p1.attacks.forEach(
                    element => {
                      if ((element.tipologia != undefined && element.tipologia == "Secondaria") || (element.tipologia == undefined && element.perc != undefined)) {
                        media_sec += parseFloat(element.media);
                      } else {
                        media_princ += parseFloat(element.media);
                      }
                    }
              )
              if (media_princ > 0) setText("arma_princ_1",media_princ);
              if (media_sec > 0) setText("arma_sec_1",media_sec);
          }
          
          if (json_p2.attacks != undefined && json_p2.attacks.length > 0) {
              var media_princ = 0;
              var media_sec = 0;
              json_p2.attacks.forEach(
                    element => {
                      if ((element.tipologia != undefined && element.tipologia == "Secondaria") || (element.tipologia == undefined && element.perc != undefined)) {
                        media_sec += parseFloat(element.media);
                      } else {
                        media_princ += parseFloat(element.media);
                      }
                    }
              )
              if (media_princ > 0) setText("arma_princ_2",media_princ);
              if (media_sec > 0) setText("arma_sec_2",media_sec);
          } 

          if (parseFloat(isNull($("#num_attacks_1").text(),'0'))      > parseFloat(isNull($("#num_attacks_2").text(),'0'))      ) $("#num_attacks_1").addClass("highValue");
          if (parseFloat(isNull($("#crit_chance_1").text(),'0'))      > parseFloat(isNull($("#crit_chance_2").text(),'0'))      ) $("#crit_chance_1").addClass("highValue");
          if (parseFloat(isNull($("#crit_molt_1").text(),'0'))        > parseFloat(isNull($("#crit_molt_2").text(),'0'))        ) $("#crit_molt_1").addClass("highValue");
          if (parseFloat(isNull($("#arma_princ_1").text(),'0'))       > parseFloat(isNull($("#arma_princ_2").text(),'0'))       ) $("#arma_princ_1").addClass("highValue");
          if (parseFloat(isNull($("#arma_sec_1").text(),'0'))         > parseFloat(isNull($("#arma_sec_2").text(),'0'))         ) $("#arma_sec_1").addClass("highValue");

          if (parseFloat(isNull($("#num_attacks_2").text(),'0'))      > parseFloat(isNull($("#num_attacks_1").text(),'0'))      ) $("#num_attacks_2").addClass("highValue");
          if (parseFloat(isNull($("#crit_chance_2").text(),'0'))      > parseFloat(isNull($("#crit_chance_1").text(),'0'))      ) $("#crit_chance_2").addClass("highValue");
          if (parseFloat(isNull($("#crit_molt_2").text(),'0'))        > parseFloat(isNull($("#crit_molt_1").text(),'0'))        ) $("#crit_molt_2").addClass("highValue");
          if (parseFloat(isNull($("#arma_princ_2").text(),'0'))       > parseFloat(isNull($("#arma_princ_1").text(),'0'))       ) $("#arma_princ_2").addClass("highValue");
          if (parseFloat(isNull($("#arma_sec_2").text(),'0'))         > parseFloat(isNull($("#arma_sec_1").text(),'0'))         ) $("#arma_sec_2").addClass("highValue");
        }

</script>

</body>

</html>
