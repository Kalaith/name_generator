<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'auth.php';
validateApiKey();

$options = [
    'gender' => [
        ['value' => 'any', 'label' => 'Any'],
        ['value' => 'male', 'label' => 'Male'],
        ['value' => 'female', 'label' => 'Female'],
    ],
    'culture' => [
        // Base cultures
        ['value' => 'any', 'label' => 'Any'],
        ['value' => 'western', 'label' => 'Western (General)'],
        ['value' => 'nordic', 'label' => 'Nordic (General)'],
        ['value' => 'eastern', 'label' => 'Eastern (General)'],
        // Fantasy cultures
        ['value' => 'elven', 'label' => 'Elven'],
        ['value' => 'orcish', 'label' => 'Orcish'],
        ['value' => 'dwarven', 'label' => 'Dwarven'],
        ['value' => 'draconic', 'label' => 'Draconic'],
    ],
    'dialect' => [
        // General option
        ['value' => 'any', 'label' => 'Any / Default', 'cultures' => ['all']],
        
        // Western dialects
        ['value' => 'british', 'label' => 'British', 'cultures' => ['western']],
        ['value' => 'american', 'label' => 'American', 'cultures' => ['western']],
        ['value' => 'french', 'label' => 'French', 'cultures' => ['western']],
        ['value' => 'german', 'label' => 'German', 'cultures' => ['western']],
        ['value' => 'italian', 'label' => 'Italian', 'cultures' => ['western']],
        ['value' => 'spanish', 'label' => 'Spanish', 'cultures' => ['western']],
        ['value' => 'irish', 'label' => 'Irish/Celtic', 'cultures' => ['western']],
        
        // Nordic dialects
        ['value' => 'swedish', 'label' => 'Swedish', 'cultures' => ['nordic']],
        ['value' => 'norwegian', 'label' => 'Norwegian', 'cultures' => ['nordic']],
        ['value' => 'danish', 'label' => 'Danish', 'cultures' => ['nordic']],
        ['value' => 'icelandic', 'label' => 'Icelandic', 'cultures' => ['nordic']],
        ['value' => 'finnish', 'label' => 'Finnish', 'cultures' => ['nordic']],
        
        // Eastern dialects
        ['value' => 'japanese', 'label' => 'Japanese', 'cultures' => ['eastern']],
        ['value' => 'chinese', 'label' => 'Chinese', 'cultures' => ['eastern']],
        ['value' => 'korean', 'label' => 'Korean', 'cultures' => ['eastern']],
        ['value' => 'vietnamese', 'label' => 'Vietnamese', 'cultures' => ['eastern']],
        ['value' => 'indian', 'label' => 'Indian', 'cultures' => ['eastern']],
        ['value' => 'arabic', 'label' => 'Arabic', 'cultures' => ['eastern']],
        
        // Elven dialects
        ['value' => 'high_elven', 'label' => 'High Elven', 'cultures' => ['elven']],
        ['value' => 'wood_elven', 'label' => 'Wood Elven', 'cultures' => ['elven']],
        ['value' => 'dark_elven', 'label' => 'Dark Elven', 'cultures' => ['elven']],
        ['value' => 'sea_elven', 'label' => 'Sea Elven', 'cultures' => ['elven']],
        
        // Orcish dialects
        ['value' => 'mountain_orc', 'label' => 'Mountain Orc', 'cultures' => ['orcish']],
        ['value' => 'plains_orc', 'label' => 'Plains Orc', 'cultures' => ['orcish']],
        ['value' => 'half_orc', 'label' => 'Half-Orc', 'cultures' => ['orcish']],
        
        // Dwarven dialects
        ['value' => 'mountain_dwarf', 'label' => 'Mountain Dwarf', 'cultures' => ['dwarven']],
        ['value' => 'hill_dwarf', 'label' => 'Hill Dwarf', 'cultures' => ['dwarven']],
        ['value' => 'deep_dwarf', 'label' => 'Deep Dwarf', 'cultures' => ['dwarven']],
        
        // Draconic dialects
        ['value' => 'chromatic', 'label' => 'Chromatic Dragon', 'cultures' => ['draconic']],
        ['value' => 'metallic', 'label' => 'Metallic Dragon', 'cultures' => ['draconic']],
        ['value' => 'ancient', 'label' => 'Ancient Wyrm', 'cultures' => ['draconic']],
    ],
    'method' => [
        ['value' => 'markov_chain', 'label' => 'Markov Chain'],
        ['value' => 'syllable_based', 'label' => 'Syllable Based'],
        ['value' => 'phonetic_pattern', 'label' => 'Phonetic Pattern'],
        ['value' => 'historical_pattern', 'label' => 'Historical Pattern'],
        ['value' => 'fantasy_generated', 'label' => 'Fantasy Generated'],
    ],
    'type' => [
        ['value' => 'full_name', 'label' => 'Full Name'],
        ['value' => 'first_only', 'label' => 'First Only'],
        ['value' => 'last_only', 'label' => 'Last Only'],
        ['value' => 'nickname', 'label' => 'Nickname'],
        ['value' => 'formal', 'label' => 'Formal'],
    ],
    'period' => [
        ['value' => 'modern', 'label' => 'Modern'],
        ['value' => 'medieval', 'label' => 'Medieval'],
        ['value' => 'ancient', 'label' => 'Ancient'],
    ],
    
    // Places tab options
    'genre' => [
        ['value' => 'fantasy', 'label' => 'Fantasy'],
        ['value' => 'modern', 'label' => 'Modern'],
        ['value' => 'scifi', 'label' => 'Sci-Fi'],
        ['value' => 'historical', 'label' => 'Historical'],
    ],
    'location_type' => [
        ['value' => 'water', 'label' => 'Water Feature'],
        ['value' => 'land', 'label' => 'Land Feature'],
        ['value' => 'forest', 'label' => 'Forest'],
        ['value' => 'mystical', 'label' => 'Mystical Location'],
        ['value' => 'settlement', 'label' => 'Settlement'],
        ['value' => 'urban', 'label' => 'Urban'],
    ],
    'tone' => [
        ['value' => 'mystical', 'label' => 'Mystical'],
        ['value' => 'dark', 'label' => 'Dark'],
        ['value' => 'heroic', 'label' => 'Heroic'],
        ['value' => 'neutral', 'label' => 'Neutral'],
        ['value' => 'romantic', 'label' => 'Romantic'],
        ['value' => 'adventurous', 'label' => 'Adventurous'],
        ['value' => 'magical', 'label' => 'Magical'],
        ['value' => 'professional', 'label' => 'Professional'],
    ],
    'climate' => [
        ['value' => 'cold', 'label' => 'Cold'],
        ['value' => 'hot', 'label' => 'Hot'],
        ['value' => 'temperate', 'label' => 'Temperate'],
        ['value' => 'tropical', 'label' => 'Tropical'],
        ['value' => 'arid', 'label' => 'Arid'],
    ],
    'size' => [
        ['value' => 'tiny', 'label' => 'Tiny'],
        ['value' => 'small', 'label' => 'Small'],
        ['value' => 'medium', 'label' => 'Medium'],
        ['value' => 'large', 'label' => 'Large'],
        ['value' => 'huge', 'label' => 'Huge'],
    ],
    
    // Events tab options
    'theme' => [
        ['value' => 'technology', 'label' => 'Technology'],
        ['value' => 'arts', 'label' => 'Arts & Culture'],
        ['value' => 'business', 'label' => 'Business'],
        ['value' => 'science', 'label' => 'Science'],
        ['value' => 'health', 'label' => 'Health & Wellness'],
        ['value' => 'education', 'label' => 'Education'],
        ['value' => 'entertainment', 'label' => 'Entertainment'],
        ['value' => 'sports', 'label' => 'Sports'],
    ],
    'event_type' => [
        ['value' => 'conference', 'label' => 'Conference'],
        ['value' => 'festival', 'label' => 'Festival'],
        ['value' => 'workshop', 'label' => 'Workshop'],
        ['value' => 'summit', 'label' => 'Summit'],
        ['value' => 'expo', 'label' => 'Expo'],
        ['value' => 'gala', 'label' => 'Gala'],
        ['value' => 'retreat', 'label' => 'Retreat'],
        ['value' => 'forum', 'label' => 'Forum'],
    ],
    
    // Titles tab options
    'title_type' => [
        ['value' => 'book', 'label' => 'Book Title'],
        ['value' => 'movie', 'label' => 'Movie Title'],
        ['value' => 'game', 'label' => 'Game Title'],
        ['value' => 'song', 'label' => 'Song Title'],
        ['value' => 'story', 'label' => 'Story Title'],
        ['value' => 'chapter', 'label' => 'Chapter Title'],
        ['value' => 'quest', 'label' => 'Quest/Mission'],
        ['value' => 'character', 'label' => 'Character Title'],
    ],
    'setting' => [
        ['value' => 'medieval', 'label' => 'Medieval'],
        ['value' => 'magical', 'label' => 'Magical'],
        ['value' => 'dark', 'label' => 'Dark'],
        ['value' => 'forest', 'label' => 'Forest'],
        ['value' => 'urban', 'label' => 'Urban'],
        ['value' => 'tech', 'label' => 'Tech'],
        ['value' => 'corporate', 'label' => 'Corporate'],
        ['value' => 'thriller', 'label' => 'Thriller'],
    ],
    'race' => [
        ['value' => 'human', 'label' => 'Human'],
        ['value' => 'elf', 'label' => 'Elf'],
        ['value' => 'dwarf', 'label' => 'Dwarf'],
        ['value' => 'orc', 'label' => 'Orc'],
        ['value' => 'halfling', 'label' => 'Halfling'],
        ['value' => 'dragonborn', 'label' => 'Dragonborn'],
    ],
    'species' => [
        ['value' => 'humanoid', 'label' => 'Humanoid'],
        ['value' => 'feline', 'label' => 'Feline'],
        ['value' => 'canine', 'label' => 'Canine'],
        ['value' => 'avian', 'label' => 'Avian'],
        ['value' => 'reptilian', 'label' => 'Reptilian'],
        ['value' => 'aquatic', 'label' => 'Aquatic'],
        ['value' => 'insectoid', 'label' => 'Insectoid'],
    ],
];

$field = $_GET['field'] ?? null;
if (!$field || !isset($options[$field])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid or missing field parameter']);
    exit;
}

echo json_encode($options[$field]);