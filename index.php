<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<?php

session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: indexlog.php');
  exit;
}

include_once('connection.php');

// if(isset($_SESSION['name']) && isset($_SESSION['username'] )){

// }
$_SESSION['name'];
$_SESSION['username'];

//ahmed naceur last modif 18/07/2023
require_once "PHPExcel/Classes/PHPExcel.php";
require __DIR__ . '/personneMorale.php';
require __DIR__ . '/personnePhysique.php';
$path = "uploads/todo.xlsx";




if (isset($_POST["submit"])) {






  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
  } else {

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

     
      $reader = PHPExcel_IOFactory::createReaderForFile($target_file);
      $excel_Obj = $reader->load($target_file);
      $worksheet = $excel_Obj->getSheet('0');
      $lastRow = $worksheet->getHighestRow();
      $colomncount = $worksheet->getHighestDataColumn();
      $colomncount_number = PHPExcel_Cell::columnIndexFromString($colomncount);
      $datesys = date("Y-m-d H:i:s");
      $xml = new SimpleXMLElement("<report/>");
      $xml->rentity_id = "3";
      $xml->submission_code = $_POST["subbmission_id"];
      $catg_cli = $_POST["catg_cli"];

      $xml->report_code = $_POST["Report_code"];
      $xml->entity_reference = $_POST["Report_code"] . $datesys;
      $xml->report_date = date("Y-m-d\\TH:i:s");
      $xml->currency_code_local = "TND";
      $xml->reporting_user_code = "RIADH-TEST";

       $firstRow=0;
      for ($row =0; $row <= $lastRow; $row++) {
        $dataExcel = array();
        for ($col = 0; $col <= $colomncount_number; $col++) {
        if($worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($col) . $row)->getValue()!=""){
          $firstRow=$row+1;
          $row=$lastRow;
          break;
        }  
        }
      }
      
      for ($row = $firstRow; $row <= $lastRow; $row++) {
        $dataExcel = array();
        
        for ($col = 0; $col <= $colomncount_number; $col++) {
          
            array_push($dataExcel, $worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($col) . $row)->getValue());
           array_map('trim', $dataExcel);
            

          
        }
        
        if (count(array_filter($dataExcel)) != 0) { 

        
          if($dataExcel[1]!=''){
          try {
            
           
            if($catg_cli == 'pp'){$agentName= $dataExcel[10];
              $transactionlocation=$dataExcel[14];
            }else{
              $transactionlocation=$dataExcel[18];
              $agentName=$dataExcel[36] ;
            }

              $transaction = $xml->addChild('transaction');
              //transaction 
              $transaction->addChild("transactionnumber", $dataExcel[1] . '/' . $dataExcel[8] . date("Y-m-d\\TH:i:s"));
              $transaction->addChild("internal_ref_number", $dataExcel[8] . $dataExcel[1]);

              $transaction->addChild("agent_name", $agentName);
              $transaction->addChild("transaction_location", $transactionlocation);
              $transaction->addChild("transaction_description", $dataExcel[4]);
              //echo "$key' value = $dataExcel[3] <br><br>";
              // die();
              if($catg_cli == 'pp'){$DateTransc=$dataExcel[4];}else{
                $DateTransc=$dataExcel[4] ;
              }
              $datetras = ($DateTransc- 25569) * 86400;
              $transaction->addChild("date_transaction", gmdate("Y-m-d\\TH:i:s", $datetras));
              $transaction->addChild("transaction_type_code", "OGUIC");
              // $transaction->addChild("transmode_code", "B200"); //
              if($catg_cli == 'pp'){$transcodeVerfi=$dataExcel[8];}else{
                $transcodeVerfi=$dataExcel[8] ;
              }
              
              switch ($dataExcel[7]) {
                case "703":
                  $transmodecode = "A";
                  break;
                case "759":
                  $transmodecode = "B";
                  break;
                case "758":
                  $transmodecode = "C";
                  break;
                case "369":
                  $transmodecode = "B301";
                  break;
                case "802":
                  $transmodecode = "B308";
                  break;
                case "802":
                  $transmodecode = "B309";
                  break;
                case "802":
                  $transmodecode = "B310";
                  break;
                case "998":
                  $transmodecode = "B314";
                  break;
                case "704":
                  $transmodecode = "B315";
                  break;
                case "738":
                  $transmodecode = "B316";
                  break;
                case "999":
                  $transmodecode = "B317";
                  break;
                case "738":
                  $transmodecode = "B331";
                  break;
                case "714":
                  $transmodecode = "B333";
                  break;
                case "714":
                  $transmodecode = "B318";
                  break;
                case "716":
                  $transmodecode = "B319";
                  break;
                case "738":
                  $transmodecode = "B320";
                  break;
                case "716":
                  $transmodecode = "B321";
                  break;
                case "243":
                  $transmodecode = "B323";
                  break;
                case "716":
                  $transmodecode = "B325";
                  break;
                case "716":
                  $transmodecode = "B327";
                  break;
                case "716":
                  $transmodecode = "B328";
                  break;
                case "629":
                  $transmodecode = "B329";
                  break;
                case "716":
                  $transmodecode = "B330";
                  break;
                case "716":
                  $transmodecode = "B337";
                  break;

                case "716":
                  $transmodecode = "B337";
                  break;
                case "736":
                  $transmodecode = "B338";
                  break;
                case "669":
                  $transmodecode = "B339";
                  break;
                case "803":
                  $transmodecode = "B341";
                  break;
                case "803":
                  $transmodecode = "B342";
                  break;
                case "803":
                  $transmodecode = "B343";
                  break;
                case "803":
                  $transmodecode = "B344";
                  break;
                case "803":
                  $transmodecode = "B345";
                  break;
                case "803":
                  $transmodecode = "B346";
                  break;
                case "803":
                  $transmodecode = "B347";
                  break;
                case "202":
                  $transmodecode = "B349";
                  break;
                case "225":
                  $transmodecode = "B354";
                  break;
                case "225":
                  $transmodecode = "B355";
                  break;
                case "225":
                  $transmodecode = "B356";
                  break;
                case "225":
                  $transmodecode = "B357";
                  break;
                case "202":
                  $transmodecode = "B120";
                  break;
                case "202":
                  $transmodecode = "B360";
                  break;
                case "202":
                  $transmodecode = "B122";
                  break;
                case "713":
                  $transmodecode = "B361";
                  break;
                case "636":
                  $transmodecode = "B131";
                  break;
                case "802":
                  $transmodecode = "B363";
                  break;
                case "130":
                  $transmodecode = "B368";
                  break;
                case "130":
                  $transmodecode = "B369";
                  break;
                case "999":
                  $transmodecode = "B107";
                  break;
                case "999":
                  $transmodecode = "B373";
                  break;
                case "207":
                  $transmodecode = "B124";
                  break;
                case "207":
                  $transmodecode = "B126";
                  break;
                case "225":
                  $transmodecode = "B132";
                  break;
                case "631":
                  $transmodecode = "B138";
                  break;
                case "631":
                  $transmodecode = "B377";
                  break;
                case "631":
                  $transmodecode = "B108";
                  break;
                case "631":
                  $transmodecode = "B378";
                  break;
                case "802":
                  $transmodecode = "B380";
                  break;
                case "802":
                  $transmodecode = "B381";
                  break;
                case "690":
                  $transmodecode = "S702";
                  break;
                case "773":
                  $transmodecode = "B129";
                  break;
                case "389":
                  $transmodecode = "B384";
                  break;
                case "639":
                  $transmodecode = "B386";
                  break;
                case "801":
                  $transmodecode = "B387";
                  break;
                case "713":
                  $transmodecode = "B389";
                  break;
                case "710":
                  $transmodecode = "B390";
                  break;
                case "998":
                  $transmodecode = "B391";
                  break;
                case "375":
                  $transmodecode = "B123";
                  break;
                case "373":
                  $transmodecode = "B116";
                  break;
                case "351":
                  $transmodecode = "B200";
                  break;
                case "619":
                  $transmodecode = "B392";
                  break;
                case "370":
                  $transmodecode = "B403";
                  break;
                case "352":
                  $transmodecode = "B114";
                  break;
                case "374":
                  $transmodecode = "B115";
                  break;
                case "773":
                  $transmodecode = "B117";
                  break;
                case "773":
                  $transmodecode = "B395";
                  break;
                case "787":
                  $transmodecode = "B136";
                  break;
                case "773":
                  $transmodecode = "B396";
                  break;
                case "782":
                  $transmodecode = "B397";
                  break;
                case "773":
                  $transmodecode = "B398";
                  break;
                case "776":
                  $transmodecode = "B399";
                  break;
                case "784":
                  $transmodecode = "B400";
                  break;
                case "783":
                  $transmodecode = "B401";
                  break;
                case "777":
                  $transmodecode = "B402";
                  break;
                default:
                  $transmodecode = "B200";
                  break;
              }

              $transaction->addChild("transmode_code", $transmodecode);

              $transaction->addChild("transmode_comment", $dataExcel[5]);
              if($catg_cli =='pm'){
                $amountTrans=$dataExcel[19];
              }else {$amountTrans=$dataExcel[24];}
              $transaction->addChild("amount_local",$amountTrans );
              $transaction->addChild("transaction_status", "C"); //$dataExcel[48]

              // detetct if pp or pm type persone 


              if ($catg_cli == 'pp') {

                personnePhysique( $dataExcel,$transmodecode,$transaction);

                


              } elseif ($catg_cli == 'pm') {
                
     
                personneMorale( $dataExcel,$transmodecode,$transaction);

               }

            
          }
        

          //catch exception
          catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
          }
          //echo "</tr>";
        }
      }

      }
    
      $report_indicators = $xml->addChild('report_indicators');
      $report_indicators->addChild("indicator", $_POST["report_indicators"]);

      echo '<pre>';
      print_r($dataExcel);
      echo '</pre>';

      //echo "</table>";
      ob_end_clean();
      header_remove();

      header("Content-type: text/xml");
      header('Content-Disposition: attachment; filename="XMLFILE.xml"');
      echo $xml->asXML();
      exit();
    } else {

      echo '<script type="text/javascript">';
      echo 'setTimeout(function () { Swal.fire("ERROR","Merci d inserer un fichier excel !","error");';
      echo '}, 0);</script>';




    }

  }
}
?>




<!DOCTYPE html>
<html>
<style>
  .back {
    border-radius: 5px;
    background-color: #f2f2f2;
    margin: auto;
    width: 70%;
    border: 1px solid green;
    padding: 10px;
  }

  /* Clear floats after the columns */
  .row::after {
    content: "";
    display: table;
    clear: both;
  }

  .col-40 {
    float: left;
    width: 40%;
    margin-top: 6px;
  }

  .col-60 {
    float: left;
    width: 60%;
    margin-top: 6px;
  }

  option {
    white-space: nowrap;
  }

  /* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
  @media screen and (max-width: 600px) {

    .col-40,
    .col-60,
    input[type=submit] {
      width: 100%;
      margin-top: 0;
    }
  }
</style>

<head>
  <title>UBCI </title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>

<body>
  <!-- Sidebar (hidden by default) -->
  <nav class="w3-sidebar w3-bar-block w3-card w3-animate-right" style="display:none;right:0;z-index:2;" id="mySidebar">
    <a href="javascript:void(0)" onclick="close_menu()" class="w3-bar-item w3-button">Fermer Menu</a>
    <a href="modifierCompte.php" onclick="close_menu()" class="w3-bar-item w3-button">Modifier compte</a>
    <a href="logout.php" onclick="close_menu()" class="w3-bar-item w3-button">Log Out</a>
  </nav>


  <!-- Navbar (sit on top) -->
  <div class="w3-top">
    <div class="w3-bar w3-white w3-wide w3-padding w3-card">
      <a href="#home" class="w3-bar-item w3-button"><b></b> </a>
      <!-- Float links to the right. Hide them on small screens -->
      <div class="w3-right w3-hide-small">
        <a href="#projects" class="w3-bar-item w3-button"><b>
            <div onclick="open_menu()">☰</div>
          </b></a>
        <!--  <a href="#about" class="w3-bar-item w3-button">About</a> -->
        <!--  <a href="#contact" class="w3-bar-item w3-button">Contact</a> -->
      </div>
    </div>
  </div>

  <!-- Header -->
  <header class="w3-display-container w3-content w3-wide" style="max-width:1500px;" id="home">
    <br>
    <br>
    <br>
    <img class="w3-image" src="ubcinewlogo.png" alt="Architecture" width="320" height="220">
    <div class="w3-display-middle w3-margin-top w3-center">
    <div class="container">
<h3>Welcome,  <span><?php echo htmlspecialchars($_SESSION['name']); ?></span></h3>


</div>
    </div>
  </header>

  <!-- Page content -->
  <div class="w3-content w3-padding" style="max-width:1564px">

    <!-- Project Section 
  <div class="w3-container w3-padding-32" id="projects">
    <h3 class="w3-border-bottom w3-border-light-grey w3-padding-16">Projects</h3>
  </div>

  <div class="w3-row-padding">
    <div class="w3-col l3 m6 w3-margin-bottom">
      <div class="w3-display-container">
        <div class="w3-display-topleft w3-black w3-padding">Summer House</div>
        <img src="/w3images/house5.jpg" alt="House" style="width:100%">
      </div>
    </div>
    <div class="w3-col l3 m6 w3-margin-bottom">
      <div class="w3-display-container">
        <div class="w3-display-topleft w3-black w3-padding">Brick House</div>
        <img src="/w3images/house2.jpg" alt="House" style="width:100%">
      </div>
    </div>
    <div class="w3-col l3 m6 w3-margin-bottom">
      <div class="w3-display-container">
        <div class="w3-display-topleft w3-black w3-padding">Renovated</div>
        <img src="/w3images/house3.jpg" alt="House" style="width:100%">
      </div>
    </div>
    <div class="w3-col l3 m6 w3-margin-bottom">
      <div class="w3-display-container">
        <div class="w3-display-topleft w3-black w3-padding">Barn House</div>
        <img src="/w3images/house4.jpg" alt="House" style="width:100%">
      </div>
    </div>
  </div>

  <div class="w3-row-padding">
    <div class="w3-col l3 m6 w3-margin-bottom">
      <div class="w3-display-container">
        <div class="w3-display-topleft w3-black w3-padding">Summer House</div>
        <img src="/w3images/house2.jpg" alt="House" style="width:99%">
      </div>
    </div>
    <div class="w3-col l3 m6 w3-margin-bottom">
      <div class="w3-display-container">
        <div class="w3-display-topleft w3-black w3-padding">Brick House</div>
        <img src="/w3images/house5.jpg" alt="House" style="width:99%">
      </div>
    </div>
    <div class="w3-col l3 m6 w3-margin-bottom">
      <div class="w3-display-container">
        <div class="w3-display-topleft w3-black w3-padding">Renovated</div>
        <img src="/w3images/house4.jpg" alt="House" style="width:99%">
      </div>
    </div>
    <div class="w3-col l3 m6 w3-margin-bottom">
      <div class="w3-display-container">
        <div class="w3-display-topleft w3-black w3-padding">Barn House</div>
        <img src="/w3images/house3.jpg" alt="House" style="width:99%">
      </div>
    </div>
  </div>
-->
    <!-- About Section 
  <div class="w3-container w3-padding-32" id="about">
    <h3 class="w3-border-bottom w3-border-light-grey w3-padding-16">About</h3>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint
      occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
      laboris nisi ut aliquip ex ea commodo consequat.
    </p>
  </div>

  <div class="w3-row-padding w3-grayscale">
    <div class="w3-col l3 m6 w3-margin-bottom">
      <img src="/w3images/team2.jpg" alt="John" style="width:100%">
      <h3>John Doe</h3>
      <p class="w3-opacity">CEO & Founder</p>
      <p>Phasellus eget enim eu lectus faucibus vestibulum. Suspendisse sodales pellentesque elementum.</p>
      <p><button class="w3-button w3-light-grey w3-block">Contact</button></p>
    </div>
    <div class="w3-col l3 m6 w3-margin-bottom">
      <img src="/w3images/team1.jpg" alt="Jane" style="width:100%">
      <h3>Jane Doe</h3>
      <p class="w3-opacity">Architect</p>
      <p>Phasellus eget enim eu lectus faucibus vestibulum. Suspendisse sodales pellentesque elementum.</p>
      <p><button class="w3-button w3-light-grey w3-block">Contact</button></p>
    </div>
    <div class="w3-col l3 m6 w3-margin-bottom">
      <img src="/w3images/team3.jpg" alt="Mike" style="width:100%">
      <h3>Mike Ross</h3>
      <p class="w3-opacity">Architect</p>
      <p>Phasellus eget enim eu lectus faucibus vestibulum. Suspendisse sodales pellentesque elementum.</p>
      <p><button class="w3-button w3-light-grey w3-block">Contact</button></p>
    </div>
    <div class="w3-col l3 m6 w3-margin-bottom">
      <img src="/w3images/team4.jpg" alt="Dan" style="width:100%">
      <h3>Dan Star</h3>
      <p class="w3-opacity">Architect</p>
      <p>Phasellus eget enim eu lectus faucibus vestibulum. Suspendisse sodales pellentesque elementum.</p>
      <p><button class="w3-button w3-light-grey w3-block">Contact</button></p>
    </div>
  </div>
-->
    <!-- Contact Section -->
    <div class="w3-container w3-padding-32" id="contact">
      <div class="back">
        <h3 class="w3-border-bottom w3-border-light-grey w3-padding-16">Formulaire CTAF</h3>

        <form action="index.php" method="post" enctype="multipart/form-data">

          <!-- <h3> submission type master:</h3>-->




          <div class="row">
            <div class="col-40">
              <label for="catg_cli-select">catégories de clients:</label>
            </div>
            <div class="col-60">
              <select class="w3-select" name="catg_cli" id="catg_cli-select">
                <option value="">Choisir:</option>
                <option value="pp">Personne Physique</option>
                <option value="pm">Personne Morale</option>

              </select>
            </div>
          </div>



          <div class="row">
            <div class="col-40">
              <label for="sub-select">Type de soumission de la déclaration/rapport:</label>
            </div>
            <div class="col-60">
              <select class="w3-select" name="subbmission_id" id="sub-select">
                <option value="">Choisir:</option>
                <option value="E">Elctronique</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-40">
              <label for="Report_code-select">Type du rapport (STR, SAR, TFR, …):</label>
            </div>
            <div class="col-60">
              <select class="w3-select" name="Report_code" id="Report_code-select">
                <option value="">Choisir:</option>


                <option value="TAR"> Déclaration d'activité liée au financement de terrorisme</option>
                <option value="SAR"> Déclaration d'activité suspecte </option>
                <option value="TFR"> Déclaration de financement de terrorisme</option>
                <option value="STR"> Déclaration de transaction suspecte </option>
                <option value="AIFT"> Information complémentaires avec transaction </option>
                <option value="AIF"> Informations complémentaires sans transaction</option>
                <option value="RSIGT"> Réponse à un signalement avec transaction </option>
                <option value="RSIG"> Réponse à un signalement sans transaction </option>
                <option value="ORDRT"> Réponse à une demande d'information avec transaction </option>
                <option value="ORDRe"> Réponse à une demande d'information sans transaction</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-40">
              <label for="report_indicators-select">Liste des indicateurs (crimes sous-jacents, mode
                opératoire…):</label>
            </div>
            <div class="col-60">
              <select style="height: 74px; max-width: auto;overflow:hidden; white-space: pre-wrap;" class="w3-select"
                name="report_indicators" id="report_indicators-select">
                <option value="">Choisir:</option>
                <option value='0101ID'> Absence de déclaration d importation de devise</option>
                <option value='CP0001'> Abus de biens sociaux</option>
                <option value='CP0002'> Abus de confiance</option>
                <option value='CP0003'> Abus de marché</option>
                <option value='0801ICF'> Accès au coffre suscitant des interrogations par leur fréquence </option>
                <option value='0401IOCA'> Achat d un nombre important de Jetons de Jeux en devise et/ou en petites
                  coupures
                </option>
                <option value='CASINO0401'> Achat d un nombre important de Jetons de Jeux en devise et/ou en petites
                  coupures</option>
                <option value='BIJ0302'> Achat d’une quantitié excessive de bijoux sans aucune justification </option>
                <option value='BIJ0301'> Achat de Bijoux précieux et de manière régulière qui ne correspond au profit du
                  client</option>
                <option value='CASINO0402'> Achat important de jetons de jeux ne refletant pas l’assise financiere du
                  client
                </option>
                <option value='IBI05'> Alimentation du compte titre à partir d’un compte d’autrui</option>
                <option value='CP0004'> Association et organisation de malfaiteurs</option>
                <option value='ASI11'> Assuré différent du souscripteur pour des raisons non justifiées</option>
                <option value='1002AD'> Autres</option>
                <option value='1002AD'> Autres pieces jointes </option>
                <option value='ASI08'> Avance sur police</option>
                <option value='0006C'> Banqueroute frauduleuse</option>
                <!--<option value='PI002'> Blanchiment d'argent et Crime financier</option>-->
                <option value='ASI17'> Client demandant le transfert des indemnités à une tierce personne sans rapport
                  avec
                  l’opération d’assurance</option>
                <option class="options" value='ASI10'> Client indifférent quant aux primes et aux conditions
                  contractuelles</option>
                <option class="options" value='ASI16'> Client insistant sur la confidentialité des transactions</option>
                <option class="options" value='GR007'> Clients originaires de régions connues pour leur haut niveau de
                  corruption ou<br>
                  d’activités illégal comme le trafic de drogue et la contrebande d’armes..</option>
                <option value='0802ICF'> Coffre détenu par des non-titulaires de compte à la banque ou l agence
                  concernée
                </option>
                <option value='0803ICF'> Coffre ouvert à des personnes morales</option>
                <option value='CF0539'> Compte sans ou à faible mouvement activé par des opérations de transfert ou de
                  virement sans motif clair.</option>
                <option value='0007C'> Contrebande</option>
                <option value='0008C'> Contrefaçon et piratage de produits</option>
                <option value='CP0008'> Cybercriminalité</option>
                <option value='1007AD'> Déclaration Complémentaire</option>
                <option value='0010C'> Délits d initiés et manipulation de marchés</option>
                <option value='1004AD'> Demande de coopération nationale</option>
                <option value='IBI04'> Demande de retrait des fonds en espèces / chèque non barré suite à une opération
                  en
                  bourse sans un motif convaincant</option>
                <option value='0403IOCA'> Demande du client que les gains lui soit restituer sous forme de certificat de
                  gains ou de cheque au nom d une tierce personne</option>
                <option value='IBI08'> Demander un financement de la part d’un FCPR sans que l’activité de l’entreprise
                  à
                  financer soit claire</option>
                <option value='0511IOF'> Dénouement correcte de crédit documentaire malgré la présence de documents
                  erronés
                </option>
                <option value='0522IOF'> Dépôt en espèce immédiatement suivi par l émission de chéques ou de transferts
                  sur
                  un autre compte dans un autre établissement de crédit ou à l étranger </option>
                <option value='0524IOF'> Dépots répétés dans plusieurs agences sans raison apparente</option>
                <option value='1006AD'> Dossier juridique</option>
                <option value='0518IOF'> Echange de billets de banque en dianrs ou en devises présentant un caractère
                  anormal en termes de montant, de fractionnement et de fréquence</option>
                <option value='0520IOF'> Echange de billets mutilés ou maculés, en dinars ou en devises pour des
                  montants
                  élevés</option>
                <option value='0519IOF'> Echange de petites coupures de billets de banque contre des coupures de montant
                  supérieur</option>
                <option value='0533IOF'> Emission de chèques au profit de bénéficiaires domiciliés à l’étranger pour des
                  montants significiatifs et/ou sans rapport avec l’activité économique du client</option>
                <option value='0541IOF'> Emission de mandats en lien avec un soupçon de blanchiement d’argent</option>
                <option value='0606IFT'> Emission de mandats en lien avec un soupçon de financement du terrorisme
                </option>
                <option value='0011C'> Enlèvement, séquestration et prise d otage</option>
                <option value='0012C'> Escroquerie et/ou Extorsion</option>
                <option value='IBI09'> Etre récalcitrant quand à la justification de l’emploi des fonds obtenus de la
                  part
                  d’un FCPR</option>
                <option value='0013C'> Exploitation sexuelle sur être humain</option>
                <option value='CP0013'> Faux et usage de faux</option>
                <option value='0509IOF'> Financement d’exportation de biens non produits localement</option>
                <option value='0510IOF'> Financement de biens importés ou exportés dont les prix sont sous-estimés ou
                  surestimés par rapport aux prix du marché</option>
                <option value='PI001'> Fraude et TBML (Trade Based Money Laundering)</option>
                <option value='0516IOF'> Garantie de rachat accoardée par le fournisseur du matériel financé</option>
                <option value='0508IOF'> Garanties accordées par des personnalités défavorablement connues ou par des
                  tiers
                  inconnues et/ou n’ayant pas de raisons évidentes de les fournir</option>
                <option value='0507IOF'> Garanties fournies sans rapport évident avec le patriomoine du débiteur
                </option>
                <option value='InfS'> Information Spontanée </option>
                <option value='CP0014'> Infractions de changes</option>
                <option value='CP0015'> Infractions Douanières</option>
                <option value='CP0016'> Infractions fiscales</option>
                <option value='0019C'> Infractions pénales contre l environnement</option>
                <option value='AD1001'> KYC documentation </option>
                <option value='0303IOBJ'> L’engagement du client d’acheter à n’importe quel prix des bijoux précieux.
                </option>
                <option value='ASI18'> La souscription du contrat est effectuéé auprès d’un intermédiaire dans le
                  ressort
                  duquel le souscripteur n’a ni domicile / siège, ni une activité significative, ni aucune attache
                  particulière</option>
                <option value='IBI06'> Le bénéficiaire effectif n’est pas claire ou facile à identifier (personne
                  physique
                  ou morale)</option>
                <option value='ASI19'> Le client change à plusieurs reprises de domicile/ siège </option>
                <option value='ASI14'> Le client demande à faire certifier ou garantir que des fonds ont été placés
                  auprès
                  de l’assureur autrement que par les documents que l’assureur remet périodiquement à l’assuré ou au
                  souscripteur</option>
                <option value='IBI01'> Le client demande ou insiste que le produit de la vente de ses titres en bourse
                  soit
                  virer vers le compte d’une autre personne</option>
                <option value='ASI12'> Le client est très préoccupé par son droit à renoncer ou racheter rapidement le
                  contrat et par montant qu’il pourra récupérer : il ne se préoccupe pas des conséquences finacières ou
                  fiscales. </option>
                <option value='ASI15'> Le client indique que les fonds proviennent de gains au jeu </option>
                <option value='ASI02'> Le montant des primes n’est pas en adéquation avec la situation financière
                  apparente
                  du client</option>
                <option value='ASI13'> Le souscripteur est assisté par une ou plusieurs personnes et ne dispose
                  visiblement
                  pas de son entière liberté de consentement.</option>
                <option value='GR004'> Les clients qui ont des difficultés à décrire leur activité ou qui manquent
                  d’informations concernant son activité</option>
                <option value='GR006'> Les clients qui sont extrêmement intéressés à se renseigner sur les systèmes
                  d’identification des opérations suspectes et sur la procédure de déclaration de soupçon</option>
                <option value='GR002'> Les documetns justifiants l’opération sont à apparence fictive.</option>
                <option value='IBI10'> Manque d’éléments d’identification du client (personne physique ou morale)
                </option>
                <option value='0020C'> Meurtres et blessures corporelles graves</option>
                <option value='CF0525'> Mise à dispositions de fonds</option>
                <option value='0102ID'> Opération d’importation ou d’exportation de marchandises sans déclaration
                  douaniere
                </option>
                <option value='0513IOF'> Opération de rachat d’un matériel récupéré dont le montant proposé est
                  nettement
                  supérieur à la valeur du marché et/ou dont le règlement en espèrce en tout ou en partie est important
                </option>
                <option value='0501IOF'> Opération financiere liée à une activitée illicite (Traffic d’arme,
                  Stupéfiiant,
                  Contrebande…)</option>
                <option value='GR001'> Opération incohérente avec les données d’identification du client</option>
                <option value='0512IOF'> Opérations de lease back sans motif économique ou présentant des incertitudes
                  sur
                  la facturation d’origine</option>
                <option value='0602IFT'> Opérations financières d une PP listée sur la liste nationale</option>
                <option value='0603IFT'> Opérations financières d une PP listée sur les listes onusiennes</option>
                <option value='0601IFT'> Opérations financières réalisées par une association suspectée de liens avec le
                  terrorisme ou le financement du terrorisme.</option>
                <option value='0604IFT'> Opérations financières réalisées par une Association, organisation ou PP se
                  trouvant dans des régions/zones de conflits.</option>
                <option value='IBI03'> Opérations sur un compte titres sans motifs économiques apparents</option>
                <option value='ASI07'> Origine des fonds non justifiée suivie d’un rachat précoce</option>
                <option value='0506IOF'> Origine inexplicable d’un remboursement anticipé partiel ou total d’un crédit
                </option>
                <option value='ASI05'> Paiement des primes d’assurance provenant de plusieurs comptes et changeant d’une
                  fois à l’autre</option>
                <option value='ASI03'> Paiement des primes d’assurance effectué par un tiers : PP ou PM</option>
                <option value='ASI04'> Paiement des primes effectué à partir d’un compte ouvert à un nom différent de
                  celui
                  du souscripteur </option>
                <option value='0517IOF'> Participation recurrente d’une meme personne à la vente aux encheres des biens
                  récupérés</option>
                <option value='0527IOF'> Prélèvement sur des comptes pour des montants élevés ou répétés ouverts par des
                  personnes politiques exposées</option>
                <option value='GR003'> Présentation de faux documents d’identité</option>
                <option value='CF0503'> Présentation et/ou usage de faux (Factures, Swifts, Chèques,…)</option>
                <option value='0021C'> Prolifération des armes de distruction massive</option>
                <option value='0514IOF'> Rachat anticipé rapide du bien financé après la mise en place du contrat de
                  leasing
                </option>
                <option value='ASI06'> Rachat précoce d’un contrat d’assurance entraînant des pertes.</option>
                <option value='0538IOF'> Réception d’un transfert de fonds sans indication du nom, de l’adresse ou de
                  numéro
                  de compte du donneur d’ordre, et sans que ces informations aient pu etre obtenus de la banque du
                  donneur
                  d’ordre</option>
                <option value='0540IOF'> Reception de mandats en lien avec un soupçon de blanchiement d’argent</option>
                <option value='0505IOF'> Reglement d’échéances par un tiers qui semble sans lien évident (parental ou
                  professionnel) avec le client</option>
                <option value='0701IIM'> Reglement en espece d’achat de biens immobiliers de luxe </option>
                <option value='0515IOF'> Règlement important du premier loyer sur proposition du preneur</option>
                <option value='CF0532'> Remise à l’encaissement de chèques tirés sur des banques implantées dans des
                  paradis
                  fiscaux ou des centres off-shores</option>
                <option value='CF0530'> Remise Chèque de montant significatif sans rappport avec l’activité économique
                  du
                  client </option>
                <option value='0531IOF'> Remise fréquente et/ou pour un montant élevé de chèques à l’encaissement tirés
                  sur
                  des banques étrangères et sans rapport avec l’activitié économique du client</option>
                <option value='REPSIG'> Réponse à un signalement </option>
                <option value='1005AD'> Réponse à une demande de coopération nationale</option>
                <option value='1003AD'> Réponse sur demande d information </option>
                <option value='0529IOF'> Retrait en espèce juste après l’approvisionnement du compte</option>
                <option value='CF0526'> Retraits en espèces fréquents ou de montants élevés apparaissant sans relation
                  avec
                  l’activité connue du client titulaire du compte, excédant de loin le chiffre d’affaires d’une société
                  ou
                  les revenues d’un particulier.</option>
                <option value='CF0502'> Retraits ou Versements en especes supérieurs à 500 DT réalisés par une
                  Association
                  ou un Parti Politique </option>
                <option value='CF0528'> Retraits répétés dans plusieurs agences</option>
                <option value='ASI01'> Souscription d’un contrat prévoyant le paiement périodique de primes d’un montant
                  élevé, l’argent venant d’un compte étranger</option>
                <option value='IBI07'> Souscription des parts de FCPR pour des montants élevés sans être regardant sur
                  la
                  rentabilité</option>
                <option value='ASI09'> Substitution d’un bénéficiaire par un autre sans lien avec le souscripteur
                </option>
                <option value='0023C'> Terrorisme et/ou financement du terrorisme</option>
                <option value='0024C'> Trafic illicite de biens volés</option>
                <option value='0025C'> Trafic illicite de patrimoine culturel</option>
                <option value='0026C'> Trafic illicite de stupéfiant et de substances psychotropes</option>
                <option value='0027C'> Trafic illicite des migrants</option>
                <option value='0028C'> Traite des êtres humains</option>
                <option value='CF0541'> Transactions financieres avec une contrepartie dans des paradis fiscaux ou des
                  pays
                  à risques</option>
                <option value='0534IOF'> Transfert de fonds inhabituels ou sans justification économique apparante en
                  provenance ou à destination de pays étrangers.</option>
                <option value='0537IOF'> Transferts fractionnés ou émis à partir de plusieurs agences</option>
                <option value='CF0535'> Transferts reçu d’un client présentant des caractéristiques anormales ou
                  inhabituelles au regard du profil du client</option>
                <option value='0536IOF'> Trransfert reçus ou émis d’un pays où le client ne possède aucune activité
                  connue.
                </option>
                <option value='CF0504'> Usage d’un montage juridique pour dissimuler l’identité du Bénéficiaire Effectif
                </option>
                <option value='CF0542'> Utilisation d’un compte de passage </option>
                <option value='0103ID'> Utilisation de fausses déclarations à l’importation</option>
                <option value='CF0540'> Utilisation de procuration pour réaliser des transactions commerciales</option>
                <option value='0605IFT'> Utilisation des mandats minutes</option>
                <option value='CF0543'> Utilisation du compte personnel pour réaliser des transactions commerciales
                </option>
                <option value='0404IOCA'> Vente de Jetons de Jeux en échange de grandes coupures</option>
                <option value='CF0523'> Versement déplacé de montants élevés ou répétés effectués par le titulaire d’un
                  compte ou par un tiers dans une agence autre que celle du titulaire du compte</option>
                <option value='CF0521'> Versement en espèces pour des montants élevés ou répétés et sans lien avec la
                  situation économique ou personnelle</option>
                <option value='IBI02'> Versement et retrait de fonds sur un compte titres dans un délai très court
                </option>
                <option value='0030C'> Vol</option>

              </select>
            </div>
          </div>



          <div class="row">
            <div class="col-40">
              <label for="sub-select">Votre fichier Excel :</label>
            </div>
            <div class="col-60">
              <input class="w3-input w3-border" type="file" name="fileToUpload" id="fileToUpload" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, 
application/vnd.ms-excel,text/comma-separated-values, text/csv, application/csv">
            </div>
          </div>





          <br>
          <br>
          <br>
          <input class="w3-btn w3-teal" type="submit" value="Envoyer" name="submit">






          <!--<input class="w3-input w3-border" type="text" placeholder="Name" required name="Name">
      <input class="w3-input w3-section w3-border" type="text" placeholder="Email" required name="Email">
      <input class="w3-input w3-section w3-border" type="text" placeholder="Subject" required name="Subject">
      <input class="w3-input w3-section w3-border" type="text" placeholder="Comment" required name="Comment">
      <button class="w3-button w3-black w3-section" type="submit">
        <i class="fa fa-paper-plane"></i> SEND MESSAGE
      </button> -->
        </form>
      </div>
    </div>

    <!-- Image of location/map 
<div class="w3-container">
  <img src="/w3images/map.jpg" class="w3-image" style="width:100%">
</div>-->

    <!-- End page content -->
  </div>


  <!-- Footer -->
  <footer class="w3-center w3-black w3-padding-16">
    <p>Created by <a href="" title="UBCI" target="_blank" class="w3-hover-text-green">UBCI</a></p>
  </footer>

</body>

</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
  function open_menu() {
    document.getElementById("mySidebar").style.display = "block";
  }

  function close_menu() {
    document.getElementById("mySidebar").style.display = "none";
  }

  /*
   $(document).ready(function(){
    Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Something went wrong!',
  footer: '<a href="">Why do I have this issue?</a>'
 })
 });
      document.getElementById('file-input').addEventListener('change', readSingleFile, false);
     function readSingleFile(e) {
        var file = e.target.files[0];
        if (!file) {
            return;
        }
        var form_data = new FormData();                  // Creating object of FormData class
    form_data.append("file", file)              // Appending parameter named file with properties of file_field to form_data
    form_data.append("user_id", 123)                 // Adding extra parameters to form_data
    $.ajax({
                url: "index.php",
                dataType: 'script',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         // Setting the data attribute of ajax with file_data
                type: 'post'
       });
  
    }
     var reader = new FileReader();
        reader.onload = function(e) {
            var contents = e.target.result;
            console.log(e);
            displayContents(contents);
         };
        reader.readAsText(file);
        }
  
         function displayContents(contents) {
         var element = document.getElementById('file-content');
         element.textContent = contents;
         }
  
         function displayParsed(contents) {
         const element = document.getElementById('file-parsed');
         const json = contents.split(',');
         element.textContent = JSON.stringify(json);
         }
         */
</script>