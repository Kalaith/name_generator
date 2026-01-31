<?php

/**
 * PhoneticEngine - Advanced Phoneme-Based Name Generation
 * 
 * Features:
 * - Phonotactic constraints for valid phoneme combinations
 * - Gender-aware phonetic patterns
 * - Syllable position awareness (initial/medial/final)
 * - Phonetic harmony rules (vowel/consonant)
 * - Stress pattern support
 */
class PhoneticEngine {
    private $profiles;
    private $genderPatterns;
    private $phonotacticRules;

    public function __construct() {
        $this->initializeProfiles();
        $this->initializeGenderPatterns();
        $this->initializePhonotacticRules();
    }

    private function initializeProfiles() {
        $this->profiles = [
            'western' => [
                'syllables' => [
                    'initial' => [['CV', 40], ['CVC', 35], ['V', 15], ['VC', 10]],
                    'medial' => [['CV', 50], ['CVC', 40], ['V', 10]],
                    'final' => [['CVC', 45], ['CV', 35], ['VC', 20]]
                ],
                'length' => [2, 3],
                'onsets' => [
                    'initial' => $this->weighted(['j', 'r', 'l', 'm', 'n', 'b', 'c', 'd', 'f', 'g', 'h', 'k', 'p', 's', 't', 'v', 'w', 'br', 'cr', 'dr', 'fr', 'gr', 'pr', 'tr', 'st', 'ch', 'th', 'sh'],
                        [3, 4, 4, 4, 3, 2, 2, 2, 2, 2, 2, 2, 2, 3, 2, 2, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1]),
                    'medial' => $this->weighted(['l', 'r', 'n', 'm', 'd', 't', 's', 'v', 'th', 'z'],
                        [5, 5, 4, 3, 2, 2, 2, 2, 1, 1])
                ],
                'nuclei' => [
                    'stressed' => $this->weighted(['a', 'e', 'i', 'o', 'u', 'ea', 'ee', 'ai', 'oa', 'ou'],
                        [10, 10, 8, 8, 6, 2, 2, 2, 2, 2]),
                    'unstressed' => $this->weighted(['a', 'e', 'i', 'o', 'u'],
                        [8, 10, 8, 6, 4])
                ],
                'codas' => [
                    'medial' => $this->weighted(['n', 'r', 'l', 's', 'm'],
                        [4, 4, 3, 2, 2]),
                    'final' => $this->weighted(['n', 'r', 'd', 's', 't', 'l', 'm', 'th', 'ld', 'nd', 'rd', 'rt'],
                        [5, 5, 3, 3, 3, 3, 2, 1, 1, 1, 1, 1])
                ],
                'stressPattern' => 'initial', // stress on first syllable
                'vowelHarmony' => false
            ],
            'nordic' => [
                'syllables' => [
                    'initial' => [['CVC', 45], ['CV', 35], ['CCVC', 20]],
                    'medial' => [['CVC', 50], ['CV', 40], ['VC', 10]],
                    'final' => [['CVC', 40], ['VC', 30], ['CV', 30]]
                ],
                'length' => [1, 3],
                'onsets' => [
                    'initial' => $this->weighted(['b', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'r', 's', 't', 'v', 'bj', 'fj', 'hj', 'sk', 'sv', 'tr', 'kv'],
                        [2, 2, 3, 2, 3, 2, 2, 3, 2, 2, 2, 3, 4, 3, 2, 1, 1, 1, 2, 2, 1, 1]),
                    'medial' => $this->weighted(['l', 'r', 'n', 'd', 'v', 's', 'g'],
                        [4, 4, 3, 2, 2, 2, 1])
                ],
                'nuclei' => [
                    'stressed' => $this->weighted(['a', 'e', 'i', 'o', 'u', 'y', 'ei', 'au', 'ey'],
                        [10, 8, 8, 8, 6, 4, 2, 2, 2]),
                    'unstressed' => $this->weighted(['a', 'e', 'i', 'o', 'u'],
                        [6, 8, 8, 6, 4])
                ],
                'codas' => [
                    'medial' => $this->weighted(['r', 'n', 'l', 's'],
                        [4, 3, 3, 2]),
                    'final' => $this->weighted(['r', 'n', 'd', 'g', 'k', 'f', 'rn', 'rm', 'rs', 'nd', 'nn'],
                        [5, 4, 3, 2, 2, 2, 1, 1, 1, 1, 1])
                ],
                'stressPattern' => 'initial',
                'vowelHarmony' => false
            ],
            'eastern' => [
                'syllables' => [
                    'initial' => [['CV', 70], ['CVC', 25], ['V', 5]],
                    'medial' => [['CV', 80], ['CVC', 15], ['V', 5]],
                    'final' => [['CV', 60], ['CVC', 30], ['V', 10]]
                ],
                'length' => [2, 4],
                'onsets' => [
                    'initial' => $this->weighted(['h', 'k', 's', 't', 'n', 'm', 'r', 'y', 'w', 'ch', 'sh', 'ts', 'j', 'l', 'b', 'g', 'd', 'p', 'z'],
                        [3, 4, 4, 3, 3, 4, 3, 3, 2, 2, 2, 1, 2, 2, 2, 2, 2, 2, 1]),
                    'medial' => $this->weighted(['k', 's', 't', 'n', 'm', 'r', 'y', 'w', 'sh', 'ch'],
                        [3, 3, 3, 4, 4, 4, 3, 2, 1, 1])
                ],
                'nuclei' => [
                    'stressed' => $this->weighted(['a', 'i', 'u', 'e', 'o', 'ai', 'ei', 'ou', 'uu'],
                        [10, 10, 8, 8, 8, 2, 2, 2, 1]),
                    'unstressed' => $this->weighted(['a', 'i', 'u', 'e', 'o'],
                        [10, 10, 8, 6, 6])
                ],
                'codas' => [
                    'medial' => $this->weighted(['n', 'ng'],
                        [4, 2]),
                    'final' => $this->weighted(['n', 'ng', 'k', 'i', 'u'],
                        [4, 3, 2, 2, 2])
                ],
                'stressPattern' => 'penultimate',
                'vowelHarmony' => false
            ],
            'elven' => [
                'syllables' => [
                    'initial' => [['CV', 50], ['CVC', 25], ['V', 25]],
                    'medial' => [['CV', 60], ['V', 25], ['CVC', 15]],
                    'final' => [['CV', 45], ['CVC', 30], ['V', 25]]
                ],
                'length' => [2, 4],
                'onsets' => [
                    'initial' => $this->weighted(['l', 'r', 'n', 'm', 'th', 'f', 'v', 's', 'h', 'c', 'g', 'gl', 'fl', 'el'],
                        [6, 5, 4, 3, 4, 3, 3, 4, 2, 2, 2, 2, 2, 1]),
                    'medial' => $this->weighted(['l', 'r', 'n', 'th', 'd', 's', 'v', 'nd', 'ld'],
                        [5, 5, 4, 3, 2, 2, 2, 1, 1])
                ],
                'nuclei' => [
                    'stressed' => $this->weighted(['a', 'e', 'i', 'ae', 'ie', 'ea', 'ia', 'o'],
                        [8, 12, 10, 3, 3, 3, 2, 4]),
                    'unstressed' => $this->weighted(['a', 'e', 'i', 'o'],
                        [6, 10, 8, 4])
                ],
                'codas' => [
                    'medial' => $this->weighted(['l', 'n', 'r', 's'],
                        [4, 4, 4, 2]),
                    'final' => $this->weighted(['l', 'n', 'r', 'th', 'll', 'nn', 's', 'el', 'iel'],
                        [4, 4, 3, 2, 2, 2, 2, 1, 1])
                ],
                'stressPattern' => 'penultimate',
                'vowelHarmony' => true,
                'harmonyType' => 'front-back'
            ],
            'orcish' => [
                'syllables' => [
                    'initial' => [['CVC', 55], ['CCVC', 30], ['CV', 15]],
                    'medial' => [['CVC', 60], ['CV', 30], ['VC', 10]],
                    'final' => [['CVC', 60], ['CCVC', 25], ['VC', 15]]
                ],
                'length' => [1, 3],
                'onsets' => [
                    'initial' => $this->weighted(['g', 'k', 'd', 't', 'b', 'z', 'kr', 'gr', 'tr', 'br', 'zg', 'kh', 'th', 'gh', 'sk', 'dr'],
                        [5, 4, 3, 2, 3, 3, 2, 3, 2, 2, 2, 2, 1, 2, 2, 2]),
                    'medial' => $this->weighted(['g', 'k', 'r', 'z', 'd', 'b', 'gh'],
                        [4, 3, 4, 3, 2, 2, 2])
                ],
                'nuclei' => [
                    'stressed' => $this->weighted(['a', 'o', 'u', 'au', 'og', 'ur'],
                        [10, 10, 10, 3, 2, 2]),
                    'unstressed' => $this->weighted(['a', 'o', 'u'],
                        [10, 10, 8])
                ],
                'codas' => [
                    'medial' => $this->weighted(['r', 'g', 'k', 'z'],
                        [4, 3, 2, 2]),
                    'final' => $this->weighted(['g', 'k', 'z', 'r', 'sh', 'th', 'rk', 'gk', 'zg', 'gh'],
                        [4, 4, 4, 3, 2, 2, 2, 1, 2, 2])
                ],
                'stressPattern' => 'initial',
                'vowelHarmony' => false
            ],
            'dwarven' => [
                'syllables' => [
                    'initial' => [['CVC', 45], ['CVCC', 25], ['CCVC', 30]],
                    'medial' => [['CVC', 55], ['CV', 30], ['VC', 15]],
                    'final' => [['CVC', 50], ['CVCC', 30], ['VC', 20]]
                ],
                'length' => [2, 3],
                'onsets' => [
                    'initial' => $this->weighted(['d', 'b', 'g', 'k', 't', 'dr', 'dw', 'gr', 'gl', 'kr', 'tr', 'th', 'kh', 'st', 'br'],
                        [4, 4, 4, 3, 3, 3, 2, 3, 2, 2, 2, 2, 2, 2, 2]),
                    'medial' => $this->weighted(['r', 'd', 'g', 'l', 'n', 'm', 'k'],
                        [5, 3, 3, 3, 3, 3, 2])
                ],
                'nuclei' => [
                    'stressed' => $this->weighted(['a', 'i', 'o', 'u', 'ai', 'oi', 'au', 'or'],
                        [10, 8, 10, 8, 2, 2, 2, 2]),
                    'unstressed' => $this->weighted(['a', 'i', 'o', 'u'],
                        [8, 8, 8, 6])
                ],
                'codas' => [
                    'medial' => $this->weighted(['r', 'n', 'm', 'd', 'l'],
                        [4, 4, 3, 2, 2]),
                    'final' => $this->weighted(['r', 'n', 'd', 'k', 'g', 'm', 'rn', 'rg', 'rm', 'nd', 'rd', 'lm'],
                        [5, 4, 3, 3, 3, 2, 2, 2, 2, 2, 1, 1])
                ],
                'stressPattern' => 'initial',
                'vowelHarmony' => false
            ],
            'draconic' => [
                'syllables' => [
                    'initial' => [['CV', 40], ['CVC', 35], ['V', 25]],
                    'medial' => [['CV', 45], ['CVC', 35], ['V', 20]],
                    'final' => [['CVC', 40], ['CV', 35], ['VC', 25]]
                ],
                'length' => [2, 4],
                'onsets' => [
                    'initial' => $this->weighted(['s', 'v', 'x', 'z', 'th', 'rh', 'k', 'g', 'm', 'n', 'l', 'sy', 'zy', 'sh', 'xh'],
                        [5, 4, 4, 4, 3, 2, 3, 2, 3, 3, 3, 2, 2, 2, 1]),
                    'medial' => $this->weighted(['s', 'x', 'z', 'r', 'l', 'th', 'n'],
                        [4, 3, 3, 4, 3, 2, 3])
                ],
                'nuclei' => [
                    'stressed' => $this->weighted(['a', 'aa', 'e', 'i', 'ae', 'ia', 'o', 'uu'],
                        [8, 4, 8, 10, 3, 3, 6, 2]),
                    'unstressed' => $this->weighted(['a', 'e', 'i', 'o'],
                        [8, 8, 10, 4])
                ],
                'codas' => [
                    'medial' => $this->weighted(['s', 'x', 'r', 'n', 'l'],
                        [3, 3, 4, 3, 2]),
                    'final' => $this->weighted(['s', 'x', 'th', 'r', 'n', 'ss', 'zz', 'xis', 'ath'],
                        [4, 4, 3, 3, 2, 2, 2, 1, 1])
                ],
                'stressPattern' => 'final',
                'vowelHarmony' => true,
                'harmonyType' => 'front-back'
            ]
        ];
    }

    private function initializeGenderPatterns() {
        $this->genderPatterns = [
            'western' => [
                'male' => [
                    'finalCodas' => ['n', 'd', 's', 't', 'r', 'k', 'th', 'rd', 'ld'],
                    'finalVowels' => ['o', 'e', 'us'],
                    'preferredEndings' => ['an', 'on', 'en', 'er', 'ar', 'us', 'os'],
                    'lengthMod' => 0
                ],
                'female' => [
                    'finalCodas' => ['n', 'l', 'th'],
                    'finalVowels' => ['a', 'ia', 'elle', 'ine', 'ette', 'anna', 'ena'],
                    'preferredEndings' => ['a', 'ia', 'ina', 'ella', 'ette', 'lyn', 'anna'],
                    'lengthMod' => 1
                ]
            ],
            'nordic' => [
                'male' => [
                    'finalCodas' => ['r', 'n', 'd', 'f', 'k', 'rn', 'nd'],
                    'finalVowels' => ['i', 'e'],
                    'preferredEndings' => ['ar', 'or', 'ir', 'ulf', 'orn', 'und'],
                    'lengthMod' => 0
                ],
                'female' => [
                    'finalCodas' => ['r', 'n', 'd'],
                    'finalVowels' => ['a', 'i', 'y', 'hild', 'run'],
                    'preferredEndings' => ['a', 'hild', 'run', 'dis', 'vor', 'ey'],
                    'lengthMod' => 0
                ]
            ],
            'eastern' => [
                'male' => [
                    'finalCodas' => ['n', 'ng', 'k'],
                    'finalVowels' => ['o', 'u', 'i'],
                    'preferredEndings' => ['ro', 'ki', 'shi', 'to', 'ken', 'jin'],
                    'lengthMod' => 0
                ],
                'female' => [
                    'finalCodas' => ['n'],
                    'finalVowels' => ['ko', 'mi', 'ri', 'na', 'ka', 'yu'],
                    'preferredEndings' => ['ko', 'mi', 'ka', 'na', 'ri', 'ki', 'yu'],
                    'lengthMod' => 0
                ]
            ],
            'elven' => [
                'male' => [
                    'finalCodas' => ['r', 'n', 'l', 'th', 's'],
                    'finalVowels' => ['or', 'ion', 'iel'],
                    'preferredEndings' => ['or', 'ion', 'iel', 'as', 'ar', 'rim'],
                    'lengthMod' => 0
                ],
                'female' => [
                    'finalCodas' => ['l', 'n', 'th'],
                    'finalVowels' => ['iel', 'ia', 'wen', 'ith', 'a'],
                    'preferredEndings' => ['iel', 'ia', 'wen', 'ith', 'ara', 'anna', 'elle'],
                    'lengthMod' => 1
                ]
            ],
            'orcish' => [
                'male' => [
                    'finalCodas' => ['g', 'k', 'z', 'rk', 'zg', 'gh', 'sh'],
                    'finalVowels' => [],
                    'preferredEndings' => ['ak', 'ug', 'og', 'zar', 'gash', 'kur', 'gor'],
                    'lengthMod' => 0
                ],
                'female' => [
                    'finalCodas' => ['g', 'k', 'r', 'z'],
                    'finalVowels' => ['a', 'ra'],
                    'preferredEndings' => ['ra', 'ga', 'ka', 'sha', 'zha', 'ura'],
                    'lengthMod' => 0
                ]
            ],
            'dwarven' => [
                'male' => [
                    'finalCodas' => ['n', 'd', 'r', 'k', 'rn', 'rg', 'rm', 'nd'],
                    'finalVowels' => ['in'],
                    'preferredEndings' => ['in', 'or', 'dur', 'grim', 'dan', 'rik', 'bor'],
                    'lengthMod' => 0
                ],
                'female' => [
                    'finalCodas' => ['n', 'd', 'r', 'l'],
                    'finalVowels' => ['a', 'i', 'ra', 'la'],
                    'preferredEndings' => ['a', 'ra', 'da', 'lin', 'dis', 'hild', 'ri'],
                    'lengthMod' => 0
                ]
            ],
            'draconic' => [
                'male' => [
                    'finalCodas' => ['s', 'x', 'th', 'ss', 'zz', 'xis'],
                    'finalVowels' => ['ax', 'ix'],
                    'preferredEndings' => ['ax', 'ix', 'us', 'os', 'zar', 'xis', 'ath'],
                    'lengthMod' => 0
                ],
                'female' => [
                    'finalCodas' => ['s', 'th', 'r'],
                    'finalVowels' => ['ia', 'iss', 'ara', 'ith'],
                    'preferredEndings' => ['ia', 'iss', 'ara', 'ith', 'essa', 'yss'],
                    'lengthMod' => 1
                ]
            ]
        ];
    }

    private function initializePhonotacticRules() {
        // Define invalid consonant clusters by culture
        $this->phonotacticRules = [
            'invalidClusters' => [
                'universal' => ['kg', 'gk', 'pb', 'bp', 'td', 'dt', 'fv', 'vf', 'sz', 'zs'],
                'western' => ['lr', 'rl', 'mn', 'nm'],
                'elven' => ['kg', 'gk', 'bp', 'pb', 'zz', 'gg', 'kk'],
                'orcish' => [], // Orcish allows harsh clusters
                'dwarven' => ['fv', 'vf']
            ],
            'vowelHarmony' => [
                'front' => ['e', 'i', 'y', 'ae', 'ie', 'ei'],
                'back' => ['a', 'o', 'u', 'au', 'oa', 'ou']
            ]
        ];
    }

    private function weighted($items, $weights = null) {
        if ($weights === null) {
            return array_fill_keys($items, 1);
        }
        $result = [];
        foreach ($items as $i => $item) {
            $result[$item] = $weights[$i] ?? 1;
        }
        return $result;
    }

    /**
     * Generate a phonetically-constructed name
     * 
     * @param string $culture The cultural profile to use
     * @param string $gender 'male', 'female', or 'any'
     * @param string|null $dialect Optional regional dialect
     * @return string Generated name
     */
    public function generate($culture, $gender = 'any', $dialect = null) {
        $profile = $this->profiles[$culture] ?? $this->profiles['western'];
        $genderProfile = $this->genderPatterns[$culture][$gender] ?? null;
        
        // Apply dialect modifications if specified
        $dialectProfiles = null;
        if ($dialect && $dialect !== 'any') {
            require_once __DIR__ . '/DialectProfiles.php';
            $dialectProfiles = new DialectProfiles();
            $profile = $dialectProfiles->applyDialect($profile, $dialect, $gender);
        }
        
        // Determine length with gender modifier
        $lengthMod = $genderProfile['lengthMod'] ?? 0;
        $length = rand($profile['length'][0], $profile['length'][1]) + $lengthMod;
        $length = max(1, min(5, $length)); // Clamp to 1-5 syllables
        
        // Determine stressed syllable position
        $stressedSyllable = $this->getStressedSyllableIndex($length, $profile['stressPattern'] ?? 'initial');
        
        // Pick vowel harmony class if applicable
        $harmonyClass = null;
        if ($profile['vowelHarmony'] ?? false) {
            $harmonyClass = rand(0, 1) ? 'front' : 'back';
        }
        
        $name = '';
        $lastPhoneme = '';
        
        for ($i = 0; $i < $length; $i++) {
            $position = $this->getSyllablePosition($i, $length);
            $isStressed = ($i === $stressedSyllable);
            
            $syllable = $this->buildSyllable($profile, $genderProfile, $position, $isStressed, $harmonyClass, $i === $length - 1, $lastPhoneme);
            
            // Track last phoneme for cluster validation
            if (strlen($syllable) > 0) {
                $lastPhoneme = substr($syllable, -1);
            }
            
            $name .= $syllable;
        }
        
        // Apply dialect-specific ending if available (higher priority)
        if ($dialectProfiles && isset($profile['_dialectEndings'])) {
            $dialectEnding = $dialectProfiles->getDialectEnding($profile, $gender);
            if ($dialectEnding && rand(1, 100) <= 70) {
                // Remove trailing vowel if ending starts with vowel
                $lastChar = substr($name, -1);
                $endingFirst = substr($dialectEnding, 0, 1);
                if (in_array($lastChar, ['a', 'e', 'i', 'o', 'u']) && in_array($endingFirst, ['a', 'e', 'i', 'o', 'u'])) {
                    $name = substr($name, 0, -1);
                }
                $name .= $dialectEnding;
            }
        }
        // Otherwise apply gender-specific ending if available
        elseif ($genderProfile && rand(1, 100) <= 60) {
            $name = $this->applyGenderEnding($name, $genderProfile);
        }
        
        // Apply dialect prefix if available
        if ($dialectProfiles && isset($profile['_dialectPrefixes'])) {
            $prefix = $dialectProfiles->getDialectPrefix($profile);
            if ($prefix) {
                $name = $prefix . ucfirst($name);
                return $name; // Already formatted
            }
        }

        return ucfirst($name);
    }

    private function getSyllablePosition($index, $totalLength) {
        if ($index === 0) return 'initial';
        if ($index === $totalLength - 1) return 'final';
        return 'medial';
    }

    private function getStressedSyllableIndex($length, $pattern) {
        switch ($pattern) {
            case 'initial':
                return 0;
            case 'penultimate':
                return max(0, $length - 2);
            case 'final':
                return $length - 1;
            default:
                return 0;
        }
    }

    private function buildSyllable($profile, $genderProfile, $position, $isStressed, $harmonyClass, $isFinal, $lastPhoneme) {
        // Select syllable structure based on position
        $syllableTypes = $profile['syllables'][$position] ?? $profile['syllables']['medial'];
        $syllableType = $this->selectWeighted($syllableTypes);
        
        $syllable = '';
        
        // Parse syllable structure and build
        if ($syllableType === 'V') {
            $syllable = $this->selectVowel($profile, $isStressed, $harmonyClass);
        } elseif ($syllableType === 'CV') {
            $onset = $this->selectOnset($profile, $position, $lastPhoneme);
            $nucleus = $this->selectVowel($profile, $isStressed, $harmonyClass);
            $syllable = $onset . $nucleus;
        } elseif ($syllableType === 'VC') {
            $nucleus = $this->selectVowel($profile, $isStressed, $harmonyClass);
            $coda = $this->selectCoda($profile, $position, $genderProfile, $isFinal);
            $syllable = $nucleus . $coda;
        } elseif ($syllableType === 'CVC') {
            $onset = $this->selectOnset($profile, $position, $lastPhoneme);
            $nucleus = $this->selectVowel($profile, $isStressed, $harmonyClass);
            $coda = $this->selectCoda($profile, $position, $genderProfile, $isFinal);
            $syllable = $onset . $nucleus . $coda;
        } elseif ($syllableType === 'CVCC') {
            $onset = $this->selectOnset($profile, $position, $lastPhoneme);
            $nucleus = $this->selectVowel($profile, $isStressed, $harmonyClass);
            $coda1 = $this->selectCoda($profile, 'medial', $genderProfile, false);
            $coda2 = $this->selectCoda($profile, $position, $genderProfile, $isFinal);
            $syllable = $onset . $nucleus . $coda1 . $coda2;
        } elseif ($syllableType === 'CCVC') {
            // Use onset clusters
            $onset = $this->selectOnset($profile, $position, $lastPhoneme);
            $nucleus = $this->selectVowel($profile, $isStressed, $harmonyClass);
            $coda = $this->selectCoda($profile, $position, $genderProfile, $isFinal);
            $syllable = $onset . $nucleus . $coda;
        }
        
        return $syllable;
    }

    private function selectOnset($profile, $position, $lastPhoneme) {
        $onsetKey = ($position === 'initial') ? 'initial' : 'medial';
        $onsets = $profile['onsets'][$onsetKey] ?? $profile['onsets']['initial'];
        
        $attempts = 0;
        $onset = '';
        
        do {
            $onset = $this->selectWeighted($onsets);
            $attempts++;
            // Check for invalid cluster with previous phoneme
            $cluster = $lastPhoneme . $onset;
            if (!$this->isInvalidCluster($cluster)) {
                break;
            }
        } while ($attempts < 5);
        
        return $onset;
    }

    private function selectVowel($profile, $isStressed, $harmonyClass) {
        $vowelKey = $isStressed ? 'stressed' : 'unstressed';
        $vowels = $profile['nuclei'][$vowelKey] ?? $profile['nuclei']['stressed'];
        
        $vowel = $this->selectWeighted($vowels);
        
        // Apply vowel harmony filter if applicable
        if ($harmonyClass) {
            $harmonyVowels = $this->phonotacticRules['vowelHarmony'][$harmonyClass];
            // Check if selected vowel (or its first char) is in harmony
            $firstVowelChar = substr($vowel, 0, 1);
            if (!in_array($firstVowelChar, ['a', 'e', 'i', 'o', 'u', 'y'])) {
                $firstVowelChar = substr($vowel, 0, 2); // Try digraph
            }
            
            // Try to find a harmonious vowel if current doesn't match
            $attempts = 0;
            while ($attempts < 3 && !$this->isVowelInHarmony($vowel, $harmonyClass)) {
                $vowel = $this->selectWeighted($vowels);
                $attempts++;
            }
        }
        
        return $vowel;
    }

    private function isVowelInHarmony($vowel, $harmonyClass) {
        $harmonyVowels = $this->phonotacticRules['vowelHarmony'][$harmonyClass];
        foreach ($harmonyVowels as $hv) {
            if (strpos($vowel, $hv) !== false) {
                return true;
            }
        }
        return false;
    }

    private function selectCoda($profile, $position, $genderProfile, $isFinal) {
        $codaKey = ($position === 'final' || $isFinal) ? 'final' : 'medial';
        $codas = $profile['codas'][$codaKey] ?? $profile['codas']['medial'];
        
        // For final syllable, prefer gender-specific codas if available
        if ($isFinal && $genderProfile && !empty($genderProfile['finalCodas']) && rand(1, 100) <= 50) {
            return $genderProfile['finalCodas'][array_rand($genderProfile['finalCodas'])];
        }
        
        return $this->selectWeighted($codas);
    }

    private function isInvalidCluster($cluster) {
        if (strlen($cluster) < 2) return false;
        
        $universalInvalid = $this->phonotacticRules['invalidClusters']['universal'];
        foreach ($universalInvalid as $invalid) {
            if (strpos($cluster, $invalid) !== false) {
                return true;
            }
        }
        
        return false;
    }

    private function applyGenderEnding($name, $genderProfile) {
        $endings = $genderProfile['preferredEndings'] ?? [];
        if (empty($endings)) return $name;
        
        $ending = $endings[array_rand($endings)];
        
        // Remove final vowel if adding vowel ending
        $lastChar = substr($name, -1);
        if (in_array($lastChar, ['a', 'e', 'i', 'o', 'u']) && in_array(substr($ending, 0, 1), ['a', 'e', 'i', 'o', 'u'])) {
            $name = substr($name, 0, -1);
        }
        
        return $name . $ending;
    }

    private function selectWeighted($options) {
        $totalWeight = 0;
        $candidates = [];
        
        foreach ($options as $key => $value) {
            if (is_array($value)) {
                $candidates[] = ['item' => $value[0], 'weight' => $value[1]];
                $totalWeight += $value[1];
            } else {
                $candidates[] = ['item' => $key, 'weight' => $value];
                $totalWeight += $value;
            }
        }
        
        if ($totalWeight <= 0) {
            return $candidates[0]['item'] ?? '';
        }
        
        $rand = rand(1, $totalWeight);
        $current = 0;
        
        foreach ($candidates as $candidate) {
            $current += $candidate['weight'];
            if ($rand <= $current) {
                return $candidate['item'];
            }
        }
        
        return $candidates[0]['item'] ?? '';
    }
}
?>
