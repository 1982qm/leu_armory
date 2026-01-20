<!DOCTYPE html>
<html lang="it">

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
    <link href="css/content.css?1.0" rel="stylesheet" />
</head>

<script src="lib/jquery-3.5.1.min.js"></script>
<script src="lib/bootstrap.bundle.min.js"></script>

<script>
  function LoadPage(url) {
    $('#frame').attr('src', url)
  }
</script>

<body>
    <div class="navbar navbar-inverse" role="navigation">
      <div class="navbar-header">
        <div class="logo">
          <img src="img\\logo.png" style="position: absolute; top: 15px; left: 10px; width: 100px;">
        </div>
      </div>
      <?php $isLoggedIn=isLoggedIn(); if ($isLoggedIn) { $user = $isLoggedIn; }?>
      <div>
        <a class="link"
           href="javascript:LoadPage('players.php')"
           draggable="false"
           style="padding:5px; margin: 0px;"
           onmouseover="$('#playerImg').hide();$('#playerImg_dark').show();"
           onmouseout ="$('#playerImg').show();$('#playerImg_dark').hide();"
           >
           <img id="playerImg" src="img\\players.svg" width="32px" height="32px" style="margin: 0px"/>
           <img id="playerImg_dark" src="img\\players_dark.svg" width="32px" height="32px" style="margin: 0px; display:none"/>
           Players
        </a>
        <a class="link" 
           href="javascript:LoadPage('compare.php')"
           draggable="false"
           style="padding:5px; margin: 0px;"
           onmouseover="$('#compareImg').hide();$('#compareImg_dark').show();"
           onmouseout ="$('#compareImg').show();$('#compareImg_dark').hide();"
           >
           <img id="compareImg" src="img\\compare.svg" width="24px" height="24px" style="margin: 0px"/>
           <img id="compareImg_dark" src="img\\compare_dark.svg" width="24px" height="24px" style="margin: 0px; display:none"/>
           Confronta
        </a>          
        <?php if ($isLoggedIn && $user['user_type'] == "1") {?>
          <a class="link" 
             href="javascript:LoadPage('bonus.php')"
             draggable="false"
             style="padding:5px; margin: 0px;"
             onmouseover="$('#bonusImg').hide();$('#bonusImg_dark').show();"
             onmouseout ="$('#bonusImg').show();$('#bonusImg_dark').hide();"
             >
             <img id="bonusImg" src="img\\bonus.svg" width="32px" height="32px" style="margin: 0px"/>
             <img id="bonusImg_dark" src="img\\bonus_dark.svg" width="32px" height="32px" style="margin: 0px; display:none"/>
             Bonus
          </a>        
          <a class="link" 
             href="javascript:LoadPage('percorsi.php')"
             draggable="false"
             style="padding:5px; margin: 0px;"
             onmouseover="$('#percorsiImg').hide();$('#percorsiImg_dark').show();"
             onmouseout ="$('#percorsiImg').show();$('#percorsiImg_dark').hide();"
             >
             <img id="percorsiImg" src="img\\percorsi.svg" width="32px" height="32px" style="margin: 0px"/>
             <img id="percorsiImg_dark" src="img\\percorsi_dark.svg" width="32px" height="32px" style="margin: 0px; display:none"/>
             Percorsi
          </a>        
          <a class="link" 
             href="javascript:LoadPage('items.php')"
             draggable="false"
             style="padding:5px; margin: 0px;"
             onmouseover="$('#itemsImg').hide();$('#itemsImg_dark').show();"
             onmouseout ="$('#itemsImg').show();$('#itemsImg_dark').hide();"
             >
             <img id="itemsImg" src="img\\items.svg" width="32px" height="32px" style="margin: 0px"/>
             <img id="itemsImg_dark" src="img\\items_dark.svg" width="32px" height="32px" style="margin: 0px; display:none"/>
             Oggetti
          </a>
          <a class="link" 
             href="javascript:LoadPage('admin.php')"
             draggable="false"
             style="padding:5px; margin: 0px;"
             onmouseover="$('#adminImg').hide();$('#adminImg_dark').show();"
             onmouseout ="$('#adminImg').show();$('#adminImg_dark').hide();"
             >
             <img id="adminImg" src="img\\admin.svg" width="32px" height="32px" style="margin: 0px" />
             <img id="adminImg_dark" src="img\\admin_dark.svg" width="32px" height="32px" style="margin: 0px; display:none"/>
             Admin
          </a>
        <?php } ?>
        <?php if ($isLoggedIn && $user['user_type'] != "2") {?>
          <a class="link" 
             href="javascript:LoadPage('builder.php')"
             draggable="false"
             style="padding:5px; margin: 0px;"
             onmouseover="$('#builderImg').hide();$('#builderImg_dark').show();"
             onmouseout ="$('#builderImg').show();$('#builderImg_dark').hide();"
             >
             <img id="builderImg" src="img\\builder.svg" width="32px" height="32px" style="margin: 0px" />
             <img id="builderImg_dark" src="img\\builder_dark.svg" width="32px" height="32px" style="margin: 0px; display:none"/>
             Builder
          </a>
          <a class="link" 
             href="javascript:LoadPage('pwd.php')"
             draggable="false"
             style="padding:5px; margin: 0px;"
             onmouseover="$('#pwdImg').hide();$('#pwdImg_dark').show();"
             onmouseout ="$('#pwdImg').show();$('#pwdImg_dark').hide();"
             >
             <img id="pwdImg" src="img\\pwd.svg" width="32px" height="32px" style="margin: 0px" />
             <img id="pwdImg_dark" src="img\\pwd_dark.svg" width="32px" height="32px" style="margin: 0px; display:none"/>
             Cambia Password
          </a>          
        <?php } ?>
        <a class="link" 
           href="login.php?logout=y"
           draggable="false"
           style="padding:5px; margin: 0px; margin-right: 10px;"
           onmouseover="$('#logoutImg').hide();$('#logoutImg_dark').show();"
           onmouseout ="$('#logoutImg').show();$('#logoutImg_dark').hide();"
           >
           <img id="logoutImg" src="img\\logout.svg" width="24px" height="24px" style="margin: 0px"/>
           <img id="logoutImg_dark" src="img\\logout_dark.svg" width="24px" height="24px" style="margin: 0px; display:none"/>
           Logout <?php if ($isLoggedIn) { echo $user['user_name']; } ?>
        </a>
      </div>
    </div>
    <iframe name="frame" id="frame" style="border:0px; top: 0; left: 0; bottom: 0px; right: 0; width: 100%; height: calc(100dvh - 55px);" src="players.php" >

</body>

</html>