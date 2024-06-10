<?php
function personnePhysique( $dataExcel,$transmodecode,$transaction){ //function parameters, two variables.
    
     
  $datenaissance = ($dataExcel[13] - 25569) * 86400;
  $name = explode(" ", $dataExcel[19]);

  $passport_numberxCIN=$dataExcel[22];
$passport_country=$dataExcel[15];
$birth_place=$dataExcel[15];
$nationality1=$dataExcel[18];
$institution_code=$dataExcel[16];
$branch=$dataExcel[1];
$currency_code=$dataExcel[56];
$country_of_birth = $dataExcel[15];
$soldeComptable= $dataExcel[29] ;
$foreign_currency_code=$dataExcel[56];
$foreign_amount=$dataExcel[24];


  $t_from_my_client = $transaction->addChild('t_from_my_client');
  $t_from_my_client->addChild("from_funds_code", "K");
  $from_foreign_currency = $t_from_my_client->addChild('from_foreign_currency');
  $from_foreign_currency->addChild("foreign_currency_code",$foreign_currency_code ); // $dataExcel[40]
  $from_foreign_currency->addChild("foreign_amount",$foreign_amount );
  $from_foreign_currency->addChild("foreign_exchange_rate", "1"); //$dataExcel[39]


  $t_conductor = $t_from_my_client->addChild('t_conductor');
  //t conductor
  if ($dataExcel[12] == "2") {
    $t_conductor->addChild("gender", 'F');

  } else {
    $t_conductor->addChild("gender", 'M');

  }

  $t_conductor->addChild("first_name", $name[0]);
  $t_conductor->addChild("last_name", $name[1]);


  $t_conductor->addChild("birthdate", gmdate("Y-m-d\\TH:i:s", $datenaissance));
  $t_conductor->addChild("birth_place", $passport_country);
  $t_conductor->addChild("country_of_birth",$birth_place );
  //previous name 
  $previous_names = $t_conductor->addChild('previous_names');
  $previous_name = $previous_names->addChild('previous_name');



 
  $previous_name->addChild("first_name", $name[0]);
  $previous_name->addChild("last_name", $name[1]);

  $t_conductor->addChild("passport_number", $passport_numberxCIN);
  $t_conductor->addChild("passport_country", "TN"); //$dataExcel[15]
  $t_conductor->addChild("nationality1", $nationality1);
  $t_conductor->addChild("residence", "TN"); //$dataExcel[16]
  $t_conductor->addChild("addresses");
  $t_conductor->addChild("email", 'ahtest@gmail.com');
  $t_conductor->addChild("occupation", 'secteur activite');




  if ($transmodecode == "B116" || $transmodecode == "B200" || $transmodecode == "B114" || $transmodecode == "B115") {
    //t from person
    $from_person = $t_from_my_client->addChild('from_person');
    if ($dataExcel[12] == 2) {
      $from_person->addChild("gender", 'F');

    } else {
      $from_person->addChild("gender", 'M');

    }
     $from_person->addChild("first_name", $name[0]);
    $from_person->addChild("last_name", $name[1]);
    $from_person->addChild("birthdate", gmdate("Y-m-d\\TH:i:s", $datenaissance));
    $from_person->addChild("birth_place", $birth_place);
    $from_person->addChild("nationality1", $nationality1);
    $from_person->addChild("residence", "TN"); //$dataExcel[16]
    $from_person->addChild("addresses");
    $from_person->addChild("occupation", 'secteur activite');

  } else {
    //from_account 

    $from_account = $t_from_my_client->addChild('from_account');
    // $from_account->addChild("first_name", $name[0]);

    $from_account->addChild("institution_name", 'UBCI');
    $from_account->addChild("institution_code", $institution_code);
    $from_account->addChild("institution_country", 'TN');
    $from_account->addChild("non_bank_institution", '1');
    $from_account->addChild("branch", $branch);

    //echo substr($dataExcel[0], -3).'reeee'.sprintf("%02d", $dataExcel[32]);
    $RIB =  $dataExcel[15].substr($dataExcel[0], -3).'00'.$dataExcel[1].$dataExcel[2].$dataExcel[33].sprintf("%02d", $dataExcel[32]);
    $from_account->addChild("account",$RIB);
    $from_account->addChild("currency_code", $currency_code );
    $from_account->addChild("account_name", $dataExcel[6]);
    $from_account->addChild("client_number", $dataExcel[0] . $dataExcel[1]);



    switch ($dataExcel[7]) {
      case "020":
        $accountType = "A";
        break;
      case "025":
        $accountType = "A";
        break;
      case "709":
        $accountType = "8CAT";
        break;
      case "706":
        $accountType = "38CAP";
        break;
      case "1":
        $accountType = "C";
        break;
      case "001":
        $accountType = "1CHQ";
        break;
      case "ras":
        $accountType = "2CCP";
        break;
      case "001":
        $accountType = "CPTC";
        break;
      case "707":
        $accountType = "36ATT";
        break;
      case "054":
        $accountType = "4CEP";
        break;
      case "055":
        $accountType = "4CEP";
        break;
      case "761":
        $accountType = "30CBT";
        break;
      case "ras":
        $accountType = "31CP";
        break;
      case "ras":
        $accountType = "6CPG";
        break;
      case "010":
        $accountType = "33CPD";
        break;
      case "700":
        $accountType = "25LYD";
        break;
      case "700":
        $accountType = "26LYC";
        break;
      case "700":
        $accountType = "24LYT";
        break;
      case "55":
        $accountType = "42EGL";
        break;
      case "ras":
        $accountType = "43GM";
        break;
      case "700":
        $accountType = "42CED";
        break;
      case "700":
        $accountType = "23TRE";
        break;
      case "700":
        $accountType = "43CET";
        break;
      case "007":
        $accountType = "7CIND";
        break;
      case "705":
        $accountType = "34INR";
        break;
      case "ras":
        $accountType = "32CI";
        break;
      case "702":
        $accountType = "16CNI";
        break;
      case "770":
        $accountType = "10PRD";
        break;
      case "770":
        $accountType = "11PRC";
        break;
      case "702":
        $accountType = "12PSD";
        break;
      case "702":
        $accountType = "13PSC";
        break;
      case "703":
        $accountType = "14CPR";
        break;
      case "ras":
        $accountType = "15CRS";
        break;
      case "703":
        $accountType = "17DCD";
        break;
      case "700":
        $accountType = "27S41";
        break;
      case "700":
        $accountType = "28S41";
        break;
      case "704":
        $accountType = "18BED";
        break;
      case "704":
        $accountType = "19BEC";
        break;
      case "ras":
        $accountType = "20CSD";
        break;
      case "ras":
        $accountType = "29SED";
        break;
      case "700":
        $accountType = "U";
        break;
      case "700":
        $accountType = "21SD";
        break;
      case "700":
        $accountType = "22SDC";
        break;
      case "703":
        $accountType = "B";
        break;
      case "340":
        $accountType = "40TGL";
        break;
      case "F10":
        $accountType = "41TGM";
        break;
      case "ras":
        $accountType = "39CAP";
        break;
      case "ras":
        $accountType = "37ATT";
        break;
      case "ras":
        $accountType = "35INR";
        break;

      default:
        $accountType = "CPTC";
        break;
    }



    $from_account->addChild("account_type", $accountType);

 
    $related_persons = $from_account->addChild('related_persons');
    $account_related_person = $related_persons->addChild('account_related_person');
    $t_person = $account_related_person->addChild('t_person');

    if ($dataExcel[12] == 2) {
      $t_person->addChild("gender", 'F');

    } else {
      $t_person->addChild("gender", 'M');

    }
     $t_person->addChild("first_name", $name[0]);
    $t_person->addChild("last_name", $name[1]);


    $t_person->addChild("birthdate", gmdate("Y-m-d\\TH:i:s", $datenaissance));
    $t_person->addChild("birth_place", $birth_place);
    $t_person->addChild("country_of_birth", $country_of_birth);
    $t_person->addChild("nationality1", $nationality1);
    if ($dataExcel[16] == '1') {
      $residence = "TN";
    } else {
      $residence = "EU";
    }

    $t_person->addChild("residence", $residence);
    $t_person->addChild("addresses");
    $t_person->addChild("occupation", "JOB");


    $account_related_person->addChild("role", "TICPT");



    $from_account->addChild("opened", "2021-03-25T00:00:00");
    $from_account->addChild("balance", $soldeComptable);
    $from_account->addChild("date_balance", "2021-03-25T00:00:00");
    $from_account->addChild("status_code", "A");







  }
  $t_from_my_client->addChild("from_country", "TN"); //$dataExcel[39]
  //t to
  $t_to = $transaction->addChild('t_to');
  $t_to->addChild("to_funds_code", "O"); // $dataExcel[36]
  $to_foreign_currency = $t_to->addChild('to_foreign_currency');
  $to_foreign_currency->addChild("foreign_currency_code", "TND"); // $dataExcel[39]
  $to_foreign_currency->addChild("foreign_amount", $foreign_amount);
  $to_foreign_currency->addChild("foreign_exchange_rate", "1"); //$dataExcel[41]
  $to_person = $t_to->addChild('to_person');
   $to_person->addChild("first_name", $name[0]);
  $to_person->addChild("last_name", $name[1]);

  $to_person->addChild("addresses");
  $t_to->addChild("to_country", "TN"); //$dataExcel[50]



    

  //returns the second argument passed into the function
}