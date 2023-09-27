<?php
session_start();
$_SESSION['klijent'] = $_POST['klijent'];
$_SESSION['vremeUnosa'] = time();
$_SESSION['brojPosiljke'] = $_POST['brojPosiljke'];
$_SESSION['kurir'] = $_POST['kurir'];
include 'header.php';

$n = 25;
function getSuffix($n)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $randomString = '';

  for ($i = 0; $i < $n; $i++) {
    $index = rand(0, strlen($characters) - 1);
    $randomString .= $characters[$index];
  }
  return $randomString;
}

$qr = trim(getSuffix($n));
$_SESSION['qrCode'] = $qr;
?>

  <script>
    $(document).ready(function(){

      $('#add_barcode').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
          e.preventDefault();
          return false;
        }
      });

      var i = 1;
      $("#add_bc").focus(function(){
        i++;
        $("#table").prepend('<tr id="row'+i+'"><td><input class="form-control" type="text" placeholder="Unesi barkod" id="barcode" name="barcode[]" value=""></td><td><button type="button" name="remove_bc" class="btn btn-danger remove_bc" id="'+i+'" title="Ukloni"><img src="images/x-icon.svg" alt="x icon"></button><td></tr>');
        $('#barcode').val($("#try").val());
        $('#try').val('').focus();
        $('#first').hide()
      });

      $(document).on('click','.remove_bc', function(){
        var button_id = $(this).attr("id");
        $("#row"+button_id+"").remove();
      });

      $('#try').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
          $("#add_bc").focus();
        }
      });

      $("#try").blur(function(){
        var broj = $("#try").val();
        var brojTrim = broj.replace(/[^a-zA-Z0-9]/g, '');
        $("#try").val(brojTrim);
      });

      $("#home").addClass("active");
    });
  </script>
</head>
<body>

<div class="container-fluid">
  <?php
  include 'navigation.php';
  ?>
  <div class="container-fluid mt-5 text-center">
    <h2>Evidencija izlazne pošte</h2>
  </div>
  <div class="container mt-5">
    <form method="post" name="add_barcode" id="add_barcode" action="status.php">
    <div class="row">
      <div class="col-lg-9">
        <div class="row mb-3">
          <div class="col-lg-4"></div>
          <div class="col-lg-4">
            <div class="form-group">
                <label for="Broj pošiljke">Broj pošiljke:</label>
                <input type="text" class="form-control"  value=" <?php echo $_POST['brojPosiljke'];?>" name="brojposiljke" disabled>
                <input type="text" class="form-control"  value=" <?= $_SESSION['qrCode'] ?>" name="qrCode" disabled>
            </div>
          </div>
          <div class="col-lg-4"></div>
        </div>
        <div class="row mb-3">
          <div class="col-lg-4"></div>
          <div class="col-lg-4">
            <div class="form-group">
                <label for="VremeUnosa">Vreme unosa:</label>
                <input type="text" class="form-control" id="vremeUnosa" value=" <?php echo (date('Y-m-d', $_SESSION['vremeUnosa'])) ?>" name="vremeUnosa" disabled>
            </div>
          </div>
          <div class="col-lg-4"></div>
        </div>
      <div class="row mb-3">
          <div class="col-lg-4"></div>
          <div class="col-lg-4">
            <div class="form-group">
                <label for="klijent">Primalac:</label>
                <input type="text" class="form-control" id="klijent" value=" <?php echo $_SESSION['klijent'] ?>" name="klijent" disabled>
            </div>
          </div>
          <div class="col-lg-4"></div>

        </div>
        <div class="row">
          <div class="col-lg-4"></div>
          <div class="col-lg-4">
            <div class="form-group">
              <label for="barkod">Barkod:</label>
              <input class="form-control" type="text" placeholder="Unesi Barkod" id="try" name="try" value="" autocomplete="off" autofocus>
            </div>
          </div>
          <div class="col-lg-4"><button type="button" name="add_bc" class="btn btn-success add_bc mt-4" id="add_bc">Dodaj</button></div>
        </div>

        <div class="row">
          <div class="col-lg-4 mt-5"></div>
          <div class="col-lg-4 mt-5">
            <button type="submit" name="submit" id="submit" class="btn btn-primary">Pošalji</button>
          </div>
          <div class="col-lg-4 mt-5"></div>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="form-group">
          <label for="brojPosiljke">Spisak pošiljaka:</label>
          <table id="table">
            <tr id="first">
              <td><input class="form-control" type="text"  id="barcode" name="barcode[]" value="" disabled placeholder="Lista je prazna"></td>
            </tr>
          </table>
        </div>
      </div>

    </div>
    </form>
    <?php
      $_SESSION['brojPosiljke'] = $_POST['brojPosiljke'];
      // $_SESSION['QRkodPosiljke'] = $_POST['qrCode'];
     ?>
  </div>
</div>
</body>
</html>
