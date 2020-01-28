<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$piano = $_POST['piano'];
$peso = $_POST['peso'];
$hingresso = $_POST['hingresso'];
$wingresso = $_POST['wingresso'];

$_SESSION['piano'] = $piano;
$_SESSION['peso'] = $peso;
$_SESSION['hingresso'] = $hingresso;
$_SESSION['wingresso'] = $wingresso;

$_SESSION['citta'] = $_POST['citta']; 
$_SESSION['indirizzo'] = $_POST['indirizzo'];

$_SESSION['oreandataritorno'] = 3; // ora andata/ritorno calcolo destinazione con Google???

if(isset($_POST['checkbox-1-1'])):
  $checkbox1 = $_POST['checkbox-1-1']; 
endif;
if(isset($_POST['checkbox-1-2'])):
  $checkbox2 = $_POST['checkbox-1-2']; 
endif;
if(isset($_POST['checkbox-1-3'])):
  $checkbox3 = $_POST['checkbox-1-3']; 
endif;
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
        <h1 class="page-title">Prenotazione servizio Traslochi Loschi . STEP 2</h1>
      </div>

      <div class="col-lg-12 col-xs-12">

        <h2>Scegli il mezzo</h2>

        <p>
        <?php 
        echo "Piano: ".$_SESSION['piano']." | "; 
        echo "Peso: ".$peso." | ";
        echo "H. ingresso: ".$hingresso."m | ";
        echo "W. ingresso: ".$wingresso."m | ";
        echo "Calcolo orario andata/ritorno: +".$_SESSION['oreandataritorno']." ore ";
        ?>

        <ul class="flex-container">
          <li class="flex-item">
            <div class="imgMezzo">Elevatore Nissan TS0001</div>
            <ul class="datiMezzo">
                <li>fino a 12 piani</li>
                <li>Peso fino a 300Kg</li>
                <li>Altezza ingresso fino a 2,9m</li>
                <li>Larghezza ingresso fino a 1,96m</li>
                <li>Portata carrello: 300kg</li>
            </ul>
            <a href="item-calendario.php?code=xyz" class="btNextSmall" >Seleziona mezzo</a>
          </li>
          <li class="flex-item">
            <div class="imgMezzo">Elevatore Pick-up TS0002</div>
            <ul class="datiMezzo">
                <li>fino a 8 piani</li>
                <li>Peso fino a 300Kg</li>
                <li>Altezza ingresso fino a 2,9m</li>
                <li>Larghezza ingresso fino a 1,96m</li>
                <li>Portata carrello: 300kg</li>
            </ul>
            <a href="item-calendario.php?code=xyz" class="btNextSmall" >Seleziona mezzo</a>
          </li>
          <li class="flex-item">
            <div class="imgMezzo">Elevatore Trainato TS0003</div>
            <ul class="datiMezzo">
                <li>fino a 5 piani</li>
                <li>Peso fino a 300Kg</li>
                <li>Altezza ingresso fino a 2,9m</li>
                <li>Larghezza ingresso fino a 1,96m</li>
                <li>Portata carrello: 300kg</li>
            </ul>
            <a href="item-calendario.php?code=xyz" class="btNextSmall" >Seleziona mezzo</a>
          </li>
        </ul>

      </div> <!-- /col-lg-12 -->

      <div class="col-lg-12 col-xs-12">

        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Mezzo</th>
              <th scope="col">Piano</th>
              <th scope="col">Peso</th>
              <th scope="col">Altezza ingresso</th>
              <th scope="col">Larghezza ingresso</th>
              <th scope="col">Portata</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">Elevatore Nissan<br/>TS0001</th>
              <td>fino a 12 piani</td>
              <td>da 0 a 300Kg</td>
              <td>fino a 2,9m</td>
              <td>fino a 1,96m</td>
              <td>300kg</td>
              <td><a href="item-calendario.php?code=ts0001" class="btNextSmall" >Seleziona mezzo</a></td>
            </tr>
            <tr>
              <th scope="row">Elevatore Pick-up<br/>TS0002</th>
              <td>fino a 8 piani</td>
              <td>da 0 a 400kg</td>
              <td>fino a 2,9m</td>
              <td>fino a 1,96m</td>
              <td>400kg</td>
              <td><a href="item-calendario.php?code=ts0002" class="btNextSmall" >Seleziona mezzo</a></td>
            </tr>
            <tr>
              <th scope="row">Elevatore Trainato<br/>TS0003</th>
              <td>fino a 5 piani</td>
              <td>da 0 a 200Kg</td>
              <td>fino a 2,9m</td>
              <td>fino a 1,96m</td>
              <td>200kg</td>
              <td><a href="item-calendario.php?code=ts0003" class="btNextSmall" >Seleziona mezzo</a></td>
            </tr>
          </tbody>
        </table>

      </div> <!-- /col-lg-12 -->

    </div> <!-- /row -->

    <div class="row">    
      <div class="col-lg-12">
        <div class="stepButton">
          <button type="button" class="btBack" id="bt-back" >Torna indietro</button>
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

      /* Go back */
      $('#bt-back').on('click', function(){
        window.history.go(-1);
      });

    });

  </script>

</body>
</html>





