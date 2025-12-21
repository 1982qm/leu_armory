<!DOCTYPE HTML>
<html lang="it" data-bs-theme="dark">

<?php require("user_config.php"); 
      $isLogged = isLoggedIn();
      if($isLogged) {
        $user=$isLogged;
        updateExpire($user['id']);
      } else {
        header('location:login.php');
      }
?>

<head>
  <meta charset="utf-8">
  <link href="css/select2.min.css" rel="stylesheet" />
  <link href="css/styles.css" rel="stylesheet" />
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/datatables.min.css" rel="stylesheet">
  <link href="css/dataTables.bootstrap5.css" rel="stylesheet">
  <link href="css/content.css" rel="stylesheet" />
  <link href="css/login.css" rel="stylesheet" />
</head>

<script src="lib/jquery-3.5.1.min.js"></script>
<script src="lib/fontawesome.all.js"></script>
<script src="lib/md5.js"></script>
<script src="lib/bootstrap.bundle.min.js"></script>
<script src="lib/select2.min.js"></script>
<script src="lib/select2.it.min.js"></script>
<script src="lib/datatables.min.js"></script>

<script src="js/manageDT.js"></script>

<body>
  <main>
    <div id="content" class="container-fluid px-4" style="top: 30px;position: relative;">
      <div class="card bg-dark text-white mb-4" style="opacity: 95%;">
          <div class="card-header d-flex align-items-center">
              <i class="fas fa-table me-1"></i>
              <span id="datatableTitle" style="padding-left: 15px;">Items</span>
              <a class="ms-auto p-2" href="#" data-bs-toggle="collapse" data-bs-target="#gridContainer"
                  aria-expanded="true" aria-controls="gridContainer">
                  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
              </a>
          </div>
          <div id="gridContainer" class="collapse show">
              <div class="card-body">
                  <table id="datatableItem" class="table table-striped hover compact">
                      <thead>
                          <tr>
                              <th>Nome</th>
                              <th>Livello</th>
                          </tr>
                      </thead>
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
    </div>

    <div id="item" class="container-fluid px-4" style="top: 30px;position: relative;">
      <div class="card bg-dark text-white mb-4" style="opacity: 95%;">
          <div id="itemContainer" class="collapse show">
              <div class="card-body">
              </div>
          </div>
      </div>
    </div>    

  </main>  

  <script>

        $(document).ready(function () {
            CreateDataTable($("#datatableItem"), undefined, undefined, undefined);
            FetchPlayers();
        })

        function FetchPlayers () {
          fetch('php/load_items.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json'
              }
          })
          .then(response => response.json())
          .then(data => LoadItems(data))
          .catch(error => console.log("Errore in caricamento: " + error));
        }

        function LoadItems (data) {
          LoadDataTable($("#datatableItem"),
                        data,
                        function (element) {
                            return [element.name, element.level];
                        },
                        undefined
          );
        }

</script>
</body>

</html>
