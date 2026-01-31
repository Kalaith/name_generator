<?php

require_once 'api_config.php';

function validateApiKey() {
    $apiKey = null;

    // Check for API key in headers (preferred)
    $headers = getallheaders();
    // Handle case-insensitivity of headers
    $headers = array_change_key_case($headers, CASE_LOWER);
    
    if (isset($headers['x-api-key'])) {
        $apiKey = $headers['x-api-key'];
    } 
    // Fallback to query parameter (useful for simple testing)
    elseif (isset($_GET['key'])) {
        $apiKey = $_GET['key'];
    }

    if (!$apiKey || $apiKey !== API_KEY) {
        header('HTTP/1.1 401 Unauthorized');
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Invalid or missing API Key']);
        exit;
    }
}

// Polyfill for getallheaders() if it's missing (e.g. Nginx/FPM)
if (!function_exists('getallheaders')) {
    function getallheaders() {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}
?>
