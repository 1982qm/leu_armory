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

  function changeImg(elem, img) {
    $("#"+elem).attr("src",img);
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
           style="padding:0px; margin:0px 10px;">
           Players
          </a>
        <a class="link" 
           href="javascript:LoadPage('compare.php')"
           draggable="false"
           style="padding:0px; margin:0px 10px;">
           Confronta
          </a>
        <a class="link" 
           href="login.php?logout=y"
           draggable="false"
           style="padding:0px; margin:0px 10px;">
           Logout <?php if ($isLoggedIn) { echo $user['user_name']; } ?>
          </a>
      </div>
    </div>
    <iframe name="frame" id="frame" style="border:0px; top: 0; left: 0; bottom: 0px; right: 0; width: 100%; height: calc(100vh - 55px);" src="players.php" >
</body>

</html>