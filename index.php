<?php session_start();
include 'header.php';
?>

<script>
  $(document).ready(function() {
    $("#klijent").keyup(function() {
      var klijent = $("#klijent").val();
      $.post("list.php", {
        suggestion: klijent
      }, function(data, status) {
        $("#klijenti").html(data);
      });
    });

    $("#submit").click(function() {
      if ($("#brojPosiljke").val() == '' && $("#klijent").val() == '') {
        alert("Klijent je obavezno polje!");
      } else if ($("#brojPosiljke").val() == '' && $("#klijent").val() != '') {
        $("#brojPosiljke").val("<?php include 'id-gen.php';?>");
        $("#kurir").val("1");
      } else if ($("#brojPosiljke").val() != '' && $("#klijent").val() == '') {
        alert("Klijent je obavezno polje!");
      }
    });

    $("#brojPosiljke").blur(function() {
      var broj = $("#brojPosiljke").val();
      var brojTrim = broj.replace(/[^a-zA-Z0-9]/g, '');
      $("#brojPosiljke").val(brojTrim);
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
      <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
          <form action="stavke.php" method="post" id="first">
            <div class="form-group">
              <label for="klijent">Klijent:</label>
              <input class="form-control" list="klijenti" name="klijent" id="klijent" autocomplete="off" required>
              <datalist id="klijenti">
              </datalist>
            </div>
        </div>
        <div class="col-lg-4 mt-4">
        </div>
      </div>

      <div class="row">
        <div class="col-lg-4 mt-4"></div>
        <div class="col-lg-4">
          <div class="form-group mt-3">
            <label for="brojPosiljke">Broj pošiljke:</label>
            <input class="form-control" type="text" placeholder="Barkod pošiljke" id="brojPosiljke" name="brojPosiljke" value="">
            <input class="form-control" type="hidden" placeholder="kurir" id="kurir" name="kurir" value="0" >
          </div>
        </div>
        <div class="col-lg-4"></div>
      </div>

      <div class="row">
        <div class="col-lg-4 mt-5"></div>
        <div class="col-lg-4 mt-5">
          <button type="submit" name="submit" id="submit" class="btn btn-primary">Pošalji</button>
        </div>
        <div class="col-lg-4 mt-5"></div>
      </div>
      </form>

    </div>
  </div>

</body>
</html>
