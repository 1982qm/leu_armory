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
           onmouseover="$('#playerImg').attr('src','img\\players_dark.svg')"
           onmouseout ="$('#playerImg').attr('src','img\\players.svg')"
           >
           <img id="playerImg" src="img\\players.svg" width="32px" height="32px" style="margin: 0px"/>
           Players
          </a>
        <a class="link" 
           href="javascript:LoadPage('compare.php')"
           draggable="false"
           style="padding:5px; margin: 0px;"
           onmouseover="$('#compareImg').attr('src','img\\compare_dark.svg')"
           onmouseout ="$('#compareImg').attr('src','img\\compare.svg')"
           >
           <img id="compareImg" src="img\\compare.svg" width="24px" height="24px" style="margin: 0px"/>
           Confronta
          </a>          
        <?php if ($isLoggedIn && $user['user_type'] == "1") {?>
          <a class="link" 
            href="javascript:LoadPage('items.php')"
            draggable="false"
            style="padding:5px; margin: 0px;"
            onmouseover="$('#itemsImg').attr('src','img\\items_dark.svg')"
            onmouseout ="$('#itemsImg').attr('src','img\\items.svg')"
           >
           <img id="itemsImg" src="img\\items.svg" width="32px" height="32px" style="margin: 0px"/>
           Oggetti
          </a>
          <a class="link" 
            href="javascript:LoadPage('builder.php')"
            draggable="false"
            style="padding:5px; margin: 0px;"
            onmouseover="$('#builderImg').attr('src','img\\builder_dark.svg')"
            onmouseout ="$('#builderImg').attr('src','img\\builder.svg')"
            >
            <img id="builderImg" src="img\\builder.svg" width="32px" height="32px" style="margin: 0px" />
            Builder
            </a>
          <a class="link" 
            href="javascript:LoadPage('admin.php')"
            draggable="false"
            style="padding:5px; margin: 0px;"
            onmouseover="$('#adminImg').attr('src','img\\admin_dark.svg')"
            onmouseout ="$('#adminImg').attr('src','img\\admin.svg')"
            >
            <img id="adminImg" src="img\\admin.svg" width="32px" height="32px" style="margin: 0px" />
            Admin
            </a>
        <?php } ?>
        <?php if ($isLoggedIn && $user['user_type'] != "2") {?>
          <a class="link" 
            href="javascript:LoadPage('pwd.php')"
            draggable="false"
            style="padding:5px; margin: 0px;"
            onmouseover="$('#pwdImg').attr('src','img\\pwd_dark.svg')"
            onmouseout ="$('#pwdImg').attr('src','img\\pwd.svg')"
            >
            <img id="pwdImg" src="img\\pwd.svg" width="32px" height="32px" style="margin: 0px" />
            Cambia Password
            </a>          
        <?php } ?>
        <a class="link" 
           href="login.php?logout=y"
           draggable="false"
           style="padding:5px; margin: 0px; margin-right: 10px;"
           onmouseover="$('#logoutImg').attr('src','img\\logout_dark.svg')"
           onmouseout ="$('#logoutImg').attr('src','img\\logout.svg')"
           >
           <img id="logoutImg" src="img\\logout.svg" width="24px" height="24px" style="margin: 0px"/>
           Logout <?php if ($isLoggedIn) { echo $user['user_name']; } ?>
          </a>
      </div>
    </div>
    <iframe name="frame" id="frame" style="border:0px; top: 0; left: 0; bottom: 0px; right: 0; width: 100%; height: calc(100dvh - 55px);" src="players.php" >
    
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
          "/armory/img/players.svg",
          "/armory/img/players_dark.svg",
          "/armory/img/builder.svg",
          "/armory/img/builder_dark.svg",
          "/armory/img/logout.svg",
          "/armory/img/logout_dark.svg",
          "/armory/img/items.svg",
          "/armory/img/items_dark.svg",
          "/armory/img/compare.svg",
          "/armory/img/compare_dark.svg",
          "/armory/img/admin.svg",
          "/armory/img/admin_dark.svg",
          "/armory/img/logo.svg",
          "/armory/img/background.jpg"
        )
    </script>

</body>

</html>