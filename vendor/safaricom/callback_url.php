<?php
  require("vendor/autoload.php");
  include("config.php");
  $mpesa= new \Safaricom\Mpesa\Mpesa();
  
  $response=$mpesa->getDataFromCallback();
  
  $callbackData = json_decode($response);
  $resultCode=$callbackData->Body->stkCallback->ResultCode;
  $resultDesc=$callbackData->Body->stkCallback->ResultDesc;
  $merchantRequestID=$callbackData->Body->stkCallback->MerchantRequestID;
  $checkoutRequestID=$callbackData->Body->stkCallback->CheckoutRequestID;

  $amount=$callbackData->Body->stkCallback->CallbackMetadata->Item[0]->Value;
  $mpesaReceiptNo=$callbackData->Body->stkCallback->CallbackMetadata->Item[1]->Value;
  $balance=$callbackData->Body->stkCallback->CallbackMetadata->Item[2]->Value;
  $transactionDate=$callbackData->Body->stkCallback->CallbackMetadata->Item[3]->Value;
  $phoneNumber=$callbackData->Body->stkCallback->CallbackMetadata->Item[4]->Value;
  
  //insert to db
   $insert = "INSERT INTO stk_payments(resultCode, checkoutRequestID, amount, mpesaReceiptNo, balance, transactionDate, phoneNumber) VALUES ('$resultCode', '$checkoutRequestID', '$amount', '$mpesaReceiptNo', '$balance', '$transactionDate', '$phoneNumber')";
   $result = mysqli_query($conn, $insert);
  
  if($result){
      $Transaction = fopen('Transaction.json', "a");
        fwrite($Transaction, json_encode($response));
        fclose($Transaction);
  }else{
         $errorLog = fopen("error.txt", 'a');
        fwrite($errorLog, mysqli_error($conn));
        fclose($errorLog);

        $logFailed = fopen('failedTransaction.txt', "a");
        fwrite($logFailed, json_encode($response));
        fclose($logFailed);
    }
 
?>