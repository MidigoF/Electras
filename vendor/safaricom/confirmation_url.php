<?php 
    include 'config.php';
    header("Content-type: application/json");

    $response = '{
        "ResultCode": 0,
        "ResultDesc": "Confirmation received successfully"
    }';

    //DATA
    $mpesaResponse = file_get_contents('php://input');

    //log the response
    $logFile = "M_PESA.txt";
    $jsonMpesaResponse = json_decode($mpesaResponse, true);

    // $transaction = array(
    //     ":TransactionType" => $jsonMpesaResponse['TransactionType'],
    //     ":TransID" => $jsonMpesaResponse['TransID'],
    //     ":TransTime" => $jsonMpesaResponse['TransTime'],
    //     ":TransAmount" => $jsonMpesaResponse['TransAmount'],
    //     ":BusinessShortCode" => $jsonMpesaResponse['BusinessShortCode'],
    //     ":BillRefNumber" => $jsonMpesaResponse['BillRefNumber'],
    //     ":InvoiceNumber" => $jsonMpesaResponse['InvoiceNumber'],
    //     ":OrgAccountBalance" => $jsonMpesaResponse['OrgAccountBalance'],
    //     ":ThirdPartyTransID" => $jsonMpesaResponse['ThirdPartyTransID'],
    //     ":MSISDN" => $jsonMpesaResponse['MSISDN'],
    //     ":FirstName" => $jsonMpesaResponse['FirstName'],
    //     ":MiddleName" => $jsonMpesaResponse['MiddleName'],
    //     ":LastName" => $jsonMpesaResponse['LastName']
    // );

    $TransactionType = $jsonMpesaResponse['TransactionType'];
    $TransID = $jsonMpesaResponse['TransID'];
    $TransTime = $jsonMpesaResponse['TransTime'];
    $TransAmount = $jsonMpesaResponse['TransAmount'];
    $BusinessShortCode = $jsonMpesaResponse['BusinessShortCode'];
    $BillRefNumber = $jsonMpesaResponse['BillRefNumber'];
    $InvoiceNumber = $jsonMpesaResponse['InvoiceNumber'];
    $OrgAccountBalance = $jsonMpesaResponse['OrgAccountBalance'];
    $ThirdPartyTransID = $jsonMpesaResponse['ThirdPartyTransID'];
    $MSISDN = $jsonMpesaResponse['MSISDN'];
    $FirstName = $jsonMpesaResponse['FirstName'];
    $MiddleName = $jsonMpesaResponse['MiddleName'];
    $LastName = $jsonMpesaResponse['LastName'];

    //insert to db
    $insert = "INSERT INTO mobile_payments(TransactionType, TransID, TransTime, TransAmount, BusinessShortCode, BillRefNumber, InvoiceNumber, OrgAccountBalance, ThirdPartyTransID, MSISDN, FirstName, MiddleName, LastName) VALUES('$TransactionType', '$TransID', '$TransTime', '$TransAmount', '$BusinessShortCode', '$BillRefNumber', '$InvoiceNumber', '$OrgAccountBalance', '$ThirdPartyTransID', '$MSISDN', '$FirstName', '$MiddleName', '$LastName')";

    $result = mysqli_query($conn, $insert);

    if($result){
        $Transaction = fopen('Transaction.txt', "a");
        fwrite($Transaction, json_encode($jsonMpesaResponse));
        fclose($Transaction);
    }else{
         $errorLog = fopen("error.txt", 'a');
        fwrite($errorLog, $e.getMessage);
        fclose($errorLog);

        $logFailed = fopen('failedTransaction.txt', "a");
        fwrite($logFailed, json_encode($jsonMpesaResponse));
        fclose($logFailed);
    }

    

    //write to file
     $log = fopen($logFile, "a");

     fwrite($log, $mpesaResponse);
     fclose($log);

      echo $response;

?>