<?php
if (isset($_GET['query'])) {
    $query = $_GET['query'];

    // Your OpenAI API key (replace with your actual key)
    $apiKey = 'your-openai-api-key';
    $url = 'https://api.openai.com/v1/completions';

    // Prepare the request payload
    $data = [
        'model' => 'text-davinci-003',  // or another model
        'prompt' => $query,
        'max_tokens' => 150,
        'temperature' => 0.7,
    ];

    // Set up cURL to send the request
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Get the response from OpenAI
    $response = curl_exec($ch);
    curl_close($ch);

    // Decode the response
    $responseData = json_decode($response, true);
    $answer = $responseData['choices'][0]['text'] ?? 'No answer found';

    // Return the answer to the frontend
    echo json_encode(['answer' => $answer]);
}
?>
