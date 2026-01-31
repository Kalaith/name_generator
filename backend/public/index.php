<?php
// disable error reporting for production, enable for debugging if needed
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Base path for backend scripts relative to this file
// The PHP scripts (options.php, generate_name.php, etc.) are one level up from public/
$backendDir = realpath(__DIR__ . '/..');

if (!$backendDir) {
    http_response_code(500);
    die("Backend directory configuration error.");
}

// Get the request URI
$requestUri = $_SERVER['REQUEST_URI'];

// Remove query string if present
if (false !== $pos = strpos($requestUri, '?')) {
    $requestUri = substr($requestUri, 0, $pos);
}

// Extract the script name from the URI
// Expected format: /name_generator/api/options.php -> options.php
// We need to be careful about the base path.
// The .htaccess rules reroute /api/(*.) to this script.
// Let's rely on finding the last part of the path.

$pathParts = explode('/', trim($requestUri, '/'));
$scriptName = end($pathParts);

// Security check: Allow only specific files or alphanumeric filenames ending in .php
// This prevents directory traversal attacks.
$allowedScripts = [
    'generate_name.php',
    'generate_place.php',
    'generate_title.php',
    'generate_event.php',
    'generate_batch.php',
    'options.php',
    'diag.php'
];

if (!in_array($scriptName, $allowedScripts)) {
    http_response_code(404);
    echo json_encode(['error' => 'Endpoint not found or forbidden', 'debug_script' => $scriptName]);
    exit;
}

$targetFile = $backendDir . '/' . $scriptName;

if (file_exists($targetFile)) {
    // Important: Change directory to backend so relative requires (like auth.php) work
    chdir($backendDir);
    require $targetFile;
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Backend script not found']);
}
?>
