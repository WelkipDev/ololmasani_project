<?php
// Get the JSON payload from M-Pesa
$data = file_get_contents('php://input');
$decodedData = json_decode($data, true);

// Log the response (for debugging)
file_put_contents('mpesa_callback.log', print_r($decodedData, true));

// Process the payment (e.g., update database)
if (isset($decodedData['Body']['stkCallback']['ResultCode']) && $decodedData['Body']['stkCallback']['ResultCode'] === 0) {
    $amount = $decodedData['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
    $phoneNumber = $decodedData['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];

    // Update your database with the payment details
    // Example: savePayment($phoneNumber, $amount);
}
?>