<?php
$apiKey = 'YOUR_OPENAI_API_KEY'; // Thay bằng key thật

function callGPT($prompt) {
    global $apiKey;

    $postData = [
        "model" => "gpt-4",
        "messages" => [
            ["role" => "system", "content" => "Bạn là trợ lý AI thông minh."],
            ["role" => "user", "content" => $prompt]
        ],
        "temperature" => 0.7
    ];

    $ch = curl_init('https://api.openai.com/v1/chat/completions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey,
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);
    return $result['choices'][0]['message']['content'] ?? 'Lỗi phản hồi';
}

// Ví dụ sử dụng
$user_input = $_GET['q'] ?? 'Xin chào';
echo "<strong>Bạn:</strong> $user_input<br>";
echo "<strong>AI:</strong> " . callGPT($user_input);
