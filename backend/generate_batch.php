<?php
header('Content-Type: application/json');
require_once 'auth.php';
validateApiKey();

$count = intval($_GET['count'] ?? 1);
$count = max(1, min(20, $count)); // Clamp between 1 and 20
$types = isset($_GET['types']) ? (array)$_GET['types'] : ['people'];

// Include the generators for people names
require_once 'generators.php';

// Initialize the NameGenerators class
$generators = new NameGenerators();

$results = [];

foreach ($types as $type) {
    switch ($type) {
        case 'people':
            $names = [];
            for ($i = 0; $i < $count; $i++) {
                $gender = (rand(0, 1) === 0) ? 'male' : 'female';
                $firstName = $generators->generateMarkovName('western', $gender);
                $lastName = $generators->generateMarkovName('western', 'surname');
                $names[] = $firstName . ' ' . $lastName;
            }
            $results[$type] = $names;
            break;
            
        case 'places':
            // Inline place generation
            $placeElements = ['Crystal', 'Iron', 'Storm', 'Shadow', 'Silver', 'Gold', 'Fire', 'Ice', 'Thunder', 'Moon', 'Star', 'Wind', 'Stone', 'Ember'];
            $placeFeatures = ['Falls', 'Keep', 'Haven', 'Hold', 'Valley', 'Peak', 'Ridge', 'Ford', 'Grove', 'Watch', 'Gate', 'Tower', 'Bridge', 'Harbor'];
            $locations = [];
            for ($i = 0; $i < $count; $i++) {
                $element = $placeElements[array_rand($placeElements)];
                $feature = $placeFeatures[array_rand($placeFeatures)];
                $locations[] = $element . ' ' . $feature;
            }
            $results[$type] = $locations;
            break;
            
        case 'events':
            $eventPrefixes = ['Summit of', 'Festival of', 'Conference on', 'Gathering of', 'Assembly of', 
                           'Symposium on', 'Gala of', 'Celebration of', 'Forum for', 'Convention of'];
            $eventTopics = ['Innovation', 'Harmony', 'Excellence', 'Discovery', 'Creativity', 
                          'Leadership', 'Technology', 'Arts', 'Science', 'Culture', 'Progress', 'Unity'];
            $names = [];
            for ($i = 0; $i < $count; $i++) {
                $prefix = $eventPrefixes[array_rand($eventPrefixes)];
                $topic = $eventTopics[array_rand($eventTopics)];
                $names[] = $prefix . ' ' . $topic;
            }
            $results[$type] = $names;
            break;
            
        case 'titles':
            // Inline title generation
            $titlePrefixes = ['The', 'Chronicles of', 'Tales of', 'Legend of', 'Song of', 'Saga of', 'Rise of', 'Fall of'];
            $titleElements = ['Shadow', 'Light', 'Storm', 'Fire', 'Ice', 'Dragon', 'Phoenix', 'Crystal', 'Iron', 'Gold'];
            $titleSuffixes = ['King', 'Queen', 'Warrior', 'Mage', 'Knight', 'Lord', 'Champion', 'Hunter', 'Seeker', 'Keeper'];
            $titles = [];
            for ($i = 0; $i < $count; $i++) {
                $prefix = $titlePrefixes[array_rand($titlePrefixes)];
                $element = $titleElements[array_rand($titleElements)];
                $suffix = $titleSuffixes[array_rand($titleSuffixes)];
                $titles[] = $prefix . ' ' . $element . ' ' . $suffix;
            }
            $results[$type] = $titles;
            break;
            
        default:
            $results[$type] = [];
    }
}

echo json_encode($results); 