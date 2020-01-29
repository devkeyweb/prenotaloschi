<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();


$_SESSION['event-spostamento-time'] = $_POST['event-spostamento-time'];
$_SESSION['event-start-time']  = $_POST['event-start-time'];
$_SESSION['event-end-time']  = $_POST['event-end-time'];
$_SESSION['event-operativita-time']  = $_POST['event-operativita-time'];
$_SESSION['event-totale-time']  = $_POST['event-totale-time'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="robots" content="noindex, nofollow">

  <!-- bootstrap css -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- custom css -->
  <link rel="stylesheet" href="css/style.css" />

</head>

<body>

  <div id="loading">loading...</div>

  <?php include "header.php"; ?>

  <!-- Page Content -->
  <form action="#" method="post" name="selection-form" id="selection-form" >

  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h1 class="page-title">Prenotazione servizio Traslochi Loschi  . STEP 4</h1>
      </div>

      <div class="col-lg-6 col-xs-12">
        <h2>Riepilogo dati servizio</h2>

        <table class="sidebarSummary">
          <tr>
            <td class="label">Piano da raggiungere: </td>
            <td class="content"><?php echo $_SESSION['piano']; ?></td>
          </tr>
          <tr>
            <td class="label">Peso da movimentare: </td>
            <td class="content"><?php echo $_SESSION['peso']; ?></td>
          </tr>
          <tr>
            <td class="label">Altezza ingresso: </td>
            <td class="content"><?php echo $_SESSION['hingresso']; ?></td>
          </tr>
          <tr>
            <td class="label">Larghezza ingresso: </td>
            <td class="content"><?php echo $_SESSION['wingresso']; ?></td>
          </tr>
          <tr>
            <td class="label">Indirizzo: </td>
            <td class="content"><?php echo $_SESSION['indirizzo']; ?></td>
          </tr>
          <tr>
            <td class="label">Citta: </td>
            <td class="content"><?php echo $_SESSION['citta']; ?></td>
          </tr>
          <tr>
            <td class="label">Inizio attività</td>
            <td class="content">
              <?php
              $date_start = new DateTime($_SESSION['event-start-time']);
              echo $date_start->format('d-m-Y H:i');
              ?>
            </td>
          </tr>
          <tr>
            <td class="label">Fine attività</td>
            <td class="content">
              <?php
              $date_end = new DateTime($_SESSION['event-end-time']);
              echo $date_end->format('d-m-Y H:i');
              ?>
            </td>
          </tr>
          <tr>
            <td class="label">Tempo necessario per andata/ritorno: </td>
            <td class="content"><?php echo $_SESSION['event-spostamento-time']; ?></td>
          </tr>
          <tr>
            <td class="label">Tempo operatività: </td>
            <td class="content"><?php echo $_SESSION['event-operativita-time']; ?></td>
          </tr>
          <tr>
            <td class="label">Tempo totale: </td>
            <td class="content"><?php echo $_SESSION['event-totale-time']; ?></td>
          </tr>
          <tr>
            <td class="label">Costo totale servizio: </td>
            <td class="content">
              <?php $tot = $_SESSION['event-totale-time']*90; 
              echo $tot." €<br/>";
              ?><small>Comprensivo di 2 operatori</small></td>
          </tr>
        </table>
        
      </div> <!-- /col-lg-4 -->

      <div class="col-lg-6 col-xs-12">

        <h2>Dati anagrafici</h2>
        <div class="form-group">
          <h3>Nome *</h3>
          <input type="text" id="nome" name="nome" autocomplete="off" ></input>
        </div>
        <div class="form-group">
          <h3>Cognome *</h3>
          <input type="text" id="cognome" name="cognome"  autocomplete="off"  ></input>
        </div>
        <div class="form-group">
          <h3>Azienda</h3>
          <input type="text" id="company" name="company"  autocomplete="off"  ></input>
        </div>
        <div class="form-group">
          <h3>Email *</h3>
          <input type="text" id="email" name="email"  autocomplete="off"  ></input>
        </div>
        <div class="form-group">
          <h3>Telefono *</h3>
          <input type="text" id="tel" name="tel"  autocomplete="off"  ></input>
        </div>                        

        <div class="form-group">
            <input type="checkbox" class="form-checkbox" name="checkPrivacy" id="checkPrivacy" >
            <strong>Dichiaro di aver letto l'<a href="#">Informativa</a> sul trattamento dei dati personali (Art. 13 del D.lgs. 196/2003)</strong>
        </div>

      </div> <!-- /col-lg-4 -->

    </div> <!-- /row -->

    <div class="row">    
      <div class="col-lg-12">
        <div class="stepButton">
          <button type="button" class="btBack" id="bt-back" >Torna indietro</button>
          <button type="button" class="btNext" id="submit-btn-top" >Conferma prenotazione</button>
         </div>
      </div>

    </div> <!-- /row -->
  </div> <!-- /container -->

  </form>

  <?php include "footer.php"; ?>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script>
    $( document ).ready(function() {
      'use strict';

      $('#loading').hide();

      //$('#response_input_area_top').html("");

      var dataString;

      /* FORM TOP CLICK */
      $('#submit-btn-top').on('click', function(){

        var boolValidation = 0;
        var msgValidation  = new Array();

        /* var nameRequest= $('#nameTop').val();
        nameRequest = $.trim(nameRequest);
        var emailRequest = $('#emailTop').val();
        emailRequest = $.trim(emailRequest); */

        var authPrivacy = 0;
        //if(document.getElementById("checkPrivacy").checked == true){ authPrivacy = 1; }  // checkbox privacy
        if(authPrivacy != 1){
          boolValidation++;
          msgValidation.push("Autorizzazione privacy obbligatoria!");
        } 

        var vincoliCheck = 0;
        if(document.getElementById("checkbox-1-1").checked == true){ 
          vincoliCheck += 1; }  // checkbox vincolo 1-1
        if(document.getElementById("checkbox-1-2").checked == true){ 
          vincoliCheck += 1; }  // checkbox vincolo 1-2
        if(document.getElementById("checkbox-1-3").checked == true){ 
          vincoliCheck += 1; }  // checkbox vincolo 1-3

        

        /* if( nameRequest.length === 0 ) {
          boolValidation++;
          msgValidation.push("Campo nome obbligatorio!");
          if(!$("#nameTop").hasClass('is-invalid')) {
            $("#nameTop").addClass("is-invalid");
          }
        } else {
          if(!$("#nameTop").hasClass('is-valid')) {
            $("#nameTop").addClass("is-valid");
          }
        }

        if( emailRequest.length === 0 ) {
          boolValidation++;
          msgValidation.push("Campo email obbligatorio!");
          if(!$("#emailTop").hasClass('is-invalid')) {
            $("#emailTop").addClass("is-invalid");
          }
        } else {
          if(ValidateEmail(emailRequest)) {
            if(!$("#emailTop").hasClass('is-valid')) {
              $("#emailTop").addClass("is-valid");
            }
          } else {
            boolValidation++;
            msgValidation.push("Campo email non valido!");
            if(!$("#emailTop").hasClass('is-invalid')) {
              $("#emailTop").addClass("is-invalid");
            }
          }
        } */


        if(vincoliCheck > 0){ // sono stati selezionati vincoli
          console.log("sono stati selezionati vincoli");
          document.getElementById("selection-form").action = "rent-request.php";
          document.getElementById("selection-form").submit();
        } else { // NON sono stati selezionati vincoli
          // $('.response_input_area_top').html("<i class=\"fa fa-warning\" style=\"color: #c50a0a; font-weight: bold; font-size: 24px;\"></i><br/><span style=\"color: #c50a0a; font-weight: bold; font-size: 14px;\">"+msgValidation.join()+"</span>");
          console.log("NON sono stati selezionati vincoli");
          document.getElementById("selection-form").action = "item-selection.php";
          document.getElementById("selection-form").submit();
        }

      });

    });

  </script>

</body>
</html>





