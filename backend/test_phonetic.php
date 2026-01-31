<?php
require 'PhoneticEngine.php';
$e = new PhoneticEngine();

echo "=== Regional Dialects Test ===\n\n";

$tests = [
    // Western dialects
    ['culture' => 'western', 'dialect' => 'british', 'gender' => 'male'],
    ['culture' => 'western', 'dialect' => 'french', 'gender' => 'female'],
    ['culture' => 'western', 'dialect' => 'german', 'gender' => 'male'],
    ['culture' => 'western', 'dialect' => 'irish', 'gender' => 'male'],
    
    // Nordic dialects
    ['culture' => 'nordic', 'dialect' => 'icelandic', 'gender' => 'male'],
    ['culture' => 'nordic', 'dialect' => 'finnish', 'gender' => 'female'],
    
    // Eastern dialects
    ['culture' => 'eastern', 'dialect' => 'japanese', 'gender' => 'male'],
    ['culture' => 'eastern', 'dialect' => 'japanese', 'gender' => 'female'],
    ['culture' => 'eastern', 'dialect' => 'arabic', 'gender' => 'male'],
    
    // Fantasy dialects
    ['culture' => 'elven', 'dialect' => 'high_elven', 'gender' => 'male'],
    ['culture' => 'elven', 'dialect' => 'dark_elven', 'gender' => 'female'],
    ['culture' => 'orcish', 'dialect' => 'mountain_orc', 'gender' => 'male'],
    ['culture' => 'dwarven', 'dialect' => 'deep_dwarf', 'gender' => 'male'],
    ['culture' => 'draconic', 'dialect' => 'ancient', 'gender' => 'female'],
];

foreach ($tests as $test) {
    $label = ucfirst($test['dialect']) . " (" . ucfirst($test['gender']) . ")";
    echo str_pad($label, 30) . ": ";
    $names = [];
    for ($i = 0; $i < 5; $i++) {
        $names[] = $e->generate($test['culture'], $test['gender'], $test['dialect']);
    }
    echo implode(", ", $names) . "\n";
}

echo "\n=== Base Cultures (no dialect) ===\n\n";

$cultures = ['western', 'nordic', 'eastern', 'elven', 'orcish', 'dwarven', 'draconic'];
foreach ($cultures as $culture) {
    echo str_pad(ucfirst($culture), 15) . ": ";
    $names = [];
    for ($i = 0; $i < 5; $i++) {
        $names[] = $e->generate($culture, 'male', null);
    }
    echo implode(", ", $names) . "\n";
}
?>
