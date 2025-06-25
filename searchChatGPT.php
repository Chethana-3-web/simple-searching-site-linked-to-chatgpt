<?php
if (isset($_GET['query']) && !empty($_GET['query'])) {
    $query = $_GET['query'];

    // Your OpenAI API key (replace with your actual key)
    $apiKey = 'your-openai-api-key';  // Replace with your OpenAI key
    $url = 'https://api.openai.com/v1/completions';

    // Prepare the request payload
    $data = [
        'model' => 'text-davinci-003',  // or another model
        'prompt' => "Please answer the following web development question: " . $query,
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

    // Error handling for cURL
    if (curl_errno($ch)) {
        echo json_encode(['answer' => 'cURL Error: ' . curl_error($ch)]);
        curl_close($ch);
        exit;
    }

    curl_close($ch);

    // Log the raw response for debugging (optional)
    error_log("OpenAI Response: " . $response);

    // Decode the response
    $responseData = json_decode($response, true);

    // Check for a valid response
    if (isset($responseData['choices'][0]['text'])) {
        $answer = $responseData['choices'][0]['text'];
    } else {
        $answer = 'No valid answer found in the response.';
        error_log("Response Error: " . json_encode($responseData)); // Log the response for debugging
    }

    // Return the answer to the frontend
    echo json_encode(['answer' => trim($answer)]);
} else {
    echo json_encode(['answer' => 'No query provided']);
}
?>
