<?php
if (isset($_GET['query'])) {
    $query = urlencode($_GET['query']);
    $url = "https://en.wikipedia.org/w/api.php?action=query&list=search&srsearch=" . $query . "&utf8=&format=json";

    // Initialize a cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);
    $results = [];

    // Extract search results from the API response
    if (isset($data['query']['search'])) {
        foreach ($data['query']['search'] as $item) {
            $results[] = [
                'title' => $item['title'],
                'snippet' => strip_tags($item['snippet']),
                'url' => "https://en.wikipedia.org/wiki/" . urlencode($item['title'])
            ];
        }
    }

    echo json_encode($results);
}
?>
