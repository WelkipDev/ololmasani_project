<?php
$consumerKey = '8BAA96jhQC4HfOFw6f2Ue6OJDnPIWDSy7HCILA1DKA9icfpP';
$consumerSecret = 'C5TPHZD7GiT2lK5mgIGhnDgGnfwZPyw9ZSLneZWYbM4KAnwjPTL6nlK8HQTVIooN';

// Generate access token
function generateAccessToken($consumerKey, $consumerSecret) {
    $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    $credentials = base64_encode($consumerKey . ':' . $consumerSecret);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . $credentials]);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    curl_close($curl);

    // Log the raw response for debugging
    file_put_contents('access_token.log', $response);

    $result = json_decode($response);

    if (isset($result->access_token)) {
        return $result->access_token;
    } else {
        echo json_encode(['error' => 'Failed to generate access token.', 'details' => $response]);
        exit;
    }
}

// Initiate STK Push
function initiateSTKPush($accessToken, $phoneNumber, $amount) {
    $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

    $data = [
        'BusinessShortCode' => '174379', // Replace with your Paybill or Till Number
        'Password' => base64_encode('174379' . 'bfb279f9aa9bdbcf158e97dd71a467cd' . date('YmdHis')), // Replace with your Passkey
        'Timestamp' => date('YmdHis'),
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $amount,
        'PartyA' => $phoneNumber, // Customer's phone number
        'PartyB' => '174379', // Replace with your Paybill or Till Number
        'PhoneNumber' => $phoneNumber,
        'CallBackURL' => 'https://randomstring.ngrok.io/callback.php', // Replace with your Ngrok URL
        'AccountReference' => 'Loan Repayment',
        'TransactionDesc' => 'Loan Repayment'
    ];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json'
    ]);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    curl_close($curl);

    // Log the response for debugging
    file_put_contents('stk_push.log', $response);

    return json_decode($response);
}

// Main logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get phone number and amount from the POST data
    $phoneNumber = $_POST['phone'] ?? null;
    $amount = $_POST['amount'] ?? null;

    // Check if phone number and amount are provided
    if (!$phoneNumber || !$amount) {
        echo json_encode(['error' => 'Phone number and amount are required.']);
        exit;
    }

    // Validate and format the phone number
    $phoneNumber = formatPhoneNumber($phoneNumber);
    if (!$phoneNumber) {
        echo json_encode(['error' => 'Invalid phone number format.']);
        exit;
    }

    $accessToken = generateAccessToken($consumerKey, $consumerSecret);
    file_put_contents('access_token_used.log', $accessToken);
    $response = initiateSTKPush($accessToken, $phoneNumber, $amount);

    echo json_encode($response);
}

// Function to validate and format the phone number
function formatPhoneNumber($phone) {
    // Remove any non-numeric characters
    $phone = preg_replace('/\D/', '', $phone);

    // Check if the phone number starts with '0' and replace it with '254'
    if (substr($phone, 0, 1) === '0') {
        $phone = '254' . substr($phone, 1);
    }

    // Ensure the phone number is in the correct length (12 digits for Kenyan numbers)
    if (strlen($phone) === 12 && substr($phone, 0, 3) === '254') {
        return $phone;
    }

    // Return false if the phone number is invalid
    return false;
}

// Get the JSON payload from M-Pesa
$data = file_get_contents('php://input');
$decodedData = json_decode($data, true);

// Log the callback data for debugging
file_put_contents('mpesa_callback.log', print_r($decodedData, true));

// Process the payment (e.g., update database)
if (isset($decodedData['Body']['stkCallback']['ResultCode'])) {
    $resultCode = $decodedData['Body']['stkCallback']['ResultCode'];
    $resultDesc = $decodedData['Body']['stkCallback']['ResultDesc'];

    if ($resultCode == 0) {
        // Payment was successful
        file_put_contents('mpesa_success.log', print_r($decodedData, true));
    } else {
        // Payment failed
        file_put_contents('mpesa_failure.log', print_r($decodedData, true));
    }
}
?>

