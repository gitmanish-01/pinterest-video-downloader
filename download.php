<?php
require_once 'includes/download_handler.php';
header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => '',
    'data' => null,
    'debug' => null
];

// Get URL from POST or GET
$url = $_POST['url'] ?? $_GET['url'] ?? '';

if (empty($url)) {
    $response['message'] = 'Please provide a Pinterest URL';
    echo json_encode($response);
    exit;
}

// Validate URL
if (!filter_var($url, FILTER_VALIDATE_URL)) {
    $response['message'] = 'Invalid URL format';
    echo json_encode($response);
    exit;
}

// Check if it's a Pinterest URL
if (strpos($url, 'pinterest.com') === false && strpos($url, 'pin.it') === false) {
    $response['message'] = 'Please provide a valid Pinterest URL';
    echo json_encode($response);
    exit;
}

try {
    $result = downloadPinterestContent($url);
    
    if ($result['success']) {
        $response['success'] = true;
        $response['data'] = [
            'url' => $result['url'],
            'type' => $result['type']
        ];
        $response['message'] = 'Content extracted successfully';
    } else {
        $response['message'] = $result['error'];
    }
    
    // Include debug information if debug mode is enabled
    if (isset($config['api']['debug_mode']) && $config['api']['debug_mode']) {
        $response['debug'] = $result['debug'];
    }
    
} catch (Exception $e) {
    $response['message'] = 'An error occurred while processing your request';
    if (isset($config['api']['debug_mode']) && $config['api']['debug_mode']) {
        $response['debug'] = ['error' => $e->getMessage()];
    }
}

echo json_encode($response, JSON_PRETTY_PRINT);
?>
