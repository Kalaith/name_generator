<?php

// Name Generator API
header('Content-Type: application/json');

require_once 'auth.php';
validateApiKey();

require_once 'generators.php';

// Initialize the NameGenerators class
$generators = new NameGenerators();

// Get parameters from the request
$method = $_GET['method'] ?? 'markov_chain';
$culture = $_GET['culture'] ?? 'western';
$gender = $_GET['gender'] ?? 'male';
$count = intval($_GET['count'] ?? 1);
$period = $_GET['period'] ?? 'medieval'; // for historical
$dialect = $_GET['dialect'] ?? null; // regional dialect

$names = [];
for ($i = 0; $i < $count; $i++) {
    $actualGender = $gender;
    if ($gender === 'any') {
        $actualGender = (rand(0, 1) === 0) ? 'male' : 'female';
    }
    switch ($method) {
        case 'markov_chain':
            $names[] = $generators->generateMarkovName($culture, $actualGender);
            break;
        case 'syllable_based':
            $names[] = $generators->generateSyllableName($culture);
            break;
        case 'phonetic_pattern':
            $names[] = $generators->generatePhoneticName($culture, $actualGender, $dialect);
            break;
        case 'historical_pattern':
            $names[] = $generators->generateHistoricalName($culture, $period, $actualGender);
            break;
        case 'fantasy_generated':
            $names[] = $generators->generateSyllableName('fantasy');
            break;
        default:
            echo json_encode(['error' => 'Invalid method']);
            exit;
    }
}

// Return names as JSON
echo json_encode(['names' => $names]);

?>
