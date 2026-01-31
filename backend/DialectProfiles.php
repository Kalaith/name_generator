<?php

/**
 * DialectProfiles - Regional phonetic variations within cultures
 * 
 * Each dialect modifies the base culture's phonetic profile with:
 * - Regional phoneme preferences
 * - Characteristic name endings
 * - Specific consonant/vowel patterns
 */
class DialectProfiles {
    
    private $dialects;
    
    public function __construct() {
        $this->initializeDialects();
    }
    
    private function initializeDialects() {
        $this->dialects = [
            // =====================
            // WESTERN DIALECTS
            // =====================
            'british' => [
                'baseCulture' => 'western',
                'onsetMods' => ['th' => 3, 'wh' => 2, 'ch' => 2],
                'nucleiMods' => ['ou' => 2, 'ea' => 2],
                'codaMods' => ['th' => 2, 'ght' => 1],
                'maleEndings' => ['ton', 'ley', 'worth', 'ham', 'ard', 'ington'],
                'femaleEndings' => ['ley', 'beth', 'ine', 'abeth', 'ora'],
                'prefixes' => [],
                'lengthMod' => 0
            ],
            'american' => [
                'baseCulture' => 'western',
                'onsetMods' => ['j' => 3, 'br' => 2, 'cr' => 2],
                'nucleiMods' => ['ay' => 2, 'ee' => 2],
                'codaMods' => ['n' => 3, 'r' => 3],
                'maleEndings' => ['son', 'er', 'an', 'den', 'ton'],
                'femaleEndings' => ['lyn', 'lee', 'ann', 'elle', 'ey'],
                'prefixes' => [],
                'lengthMod' => 0
            ],
            'french' => [
                'baseCulture' => 'western',
                'onsetMods' => ['j' => 3, 'ch' => 2, 'ph' => 2, 'cl' => 2, 'fl' => 2],
                'nucleiMods' => ['eau' => 3, 'ou' => 2, 'oi' => 2, 'ie' => 3],
                'codaMods' => ['que' => 2, 'ne' => 2],
                'maleEndings' => ['ard', 'eau', 'ien', 'ois', 'ain', 'elle'],
                'femaleEndings' => ['ette', 'elle', 'ine', 'ie', 'aise', 'ienne'],
                'prefixes' => [],
                'lengthMod' => 1
            ],
            'german' => [
                'baseCulture' => 'western',
                'onsetMods' => ['sch' => 3, 'st' => 2, 'sp' => 2, 'fr' => 2, 'kr' => 2],
                'nucleiMods' => ['ei' => 3, 'ie' => 2, 'au' => 2, 'eu' => 2],
                'codaMods' => ['ch' => 2, 'tz' => 2, 'ff' => 1],
                'maleEndings' => ['rich', 'helm', 'bert', 'fried', 'hard', 'olf'],
                'femaleEndings' => ['hild', 'heid', 'trude', 'gard', 'linde'],
                'prefixes' => [],
                'lengthMod' => 0
            ],
            'italian' => [
                'baseCulture' => 'western',
                'onsetMods' => ['gi' => 3, 'ch' => 2, 'sc' => 2, 'gn' => 2],
                'nucleiMods' => ['io' => 3, 'ia' => 3, 'eo' => 2],
                'codaMods' => [],
                'maleEndings' => ['io', 'ino', 'enzo', 'aldo', 'ello', 'etto'],
                'femaleEndings' => ['ia', 'ella', 'etta', 'ina', 'issa', 'anda'],
                'prefixes' => [],
                'lengthMod' => 1
            ],
            'spanish' => [
                'baseCulture' => 'western',
                'onsetMods' => ['j' => 3, 'll' => 2, 'ñ' => 1],
                'nucleiMods' => ['ue' => 2, 'ie' => 2],
                'codaMods' => ['z' => 2],
                'maleEndings' => ['o', 'ez', 'ando', 'igo', 'erto'],
                'femaleEndings' => ['a', 'ita', 'ela', 'inda', 'encia'],
                'prefixes' => [],
                'lengthMod' => 0
            ],
            'irish' => [
                'baseCulture' => 'western',
                'onsetMods' => ['sh' => 3, 'bh' => 2, 'dh' => 2, 'fh' => 1, 'mh' => 2],
                'nucleiMods' => ['ao' => 3, 'ai' => 2, 'ea' => 2, 'ui' => 2],
                'codaMods' => ['gh' => 2, 'dh' => 1],
                'maleEndings' => ['an', 'ain', 'us', 'agh', 'og'],
                'femaleEndings' => ['een', 'in', 'na', 'agh', 'id'],
                'prefixes' => ['O\'', 'Mc', 'Mac'],
                'lengthMod' => 0
            ],
            
            // =====================
            // NORDIC DIALECTS
            // =====================
            'swedish' => [
                'baseCulture' => 'nordic',
                'onsetMods' => ['sj' => 2, 'sk' => 2, 'stj' => 1],
                'nucleiMods' => ['å' => 2, 'ä' => 2, 'ö' => 2],
                'codaMods' => ['sson' => 3],
                'maleEndings' => ['sson', 'berg', 'gren', 'lund', 'qvist'],
                'femaleEndings' => ['sson', 'dotter', 'a', 'stina', 'rika'],
                'prefixes' => [],
                'lengthMod' => 0
            ],
            'norwegian' => [
                'baseCulture' => 'nordic',
                'onsetMods' => ['kj' => 2, 'gj' => 2, 'hv' => 2],
                'nucleiMods' => ['ø' => 2, 'æ' => 2, 'å' => 2],
                'codaMods' => ['sen' => 3],
                'maleEndings' => ['sen', 'rud', 'heim', 'dal', 'vik'],
                'femaleEndings' => ['sen', 'a', 'hild', 'dis', 'vor'],
                'prefixes' => [],
                'lengthMod' => 0
            ],
            'danish' => [
                'baseCulture' => 'nordic',
                'onsetMods' => ['hj' => 2, 'dj' => 1],
                'nucleiMods' => ['ø' => 2, 'æ' => 2, 'å' => 2],
                'codaMods' => ['sen' => 3],
                'maleEndings' => ['sen', 'gaard', 'rup', 'berg'],
                'femaleEndings' => ['sen', 'ine', 'a', 'tte'],
                'prefixes' => [],
                'lengthMod' => 0
            ],
            // Icelandic uses patronymic surnames (father's first name + son/dottir)
            // Forename endings: male: -ur, -ir, -orn, -ar (e.g., Ragnar, Gunnar, Björn)
            //                  female: -a, -ey, -dis, -hildur (e.g., Freyja, Sigridis)
            // These forename endings are handled by codaMods and preferredEndings in PhoneticEngine
            // The maleEndings/femaleEndings here are for surnames (patronymics ONLY)
            'icelandic' => [
                'baseCulture' => 'nordic',
                'onsetMods' => ['hv' => 2, 'þ' => 2, 'ð' => 1],
                'nucleiMods' => ['á' => 2, 'í' => 2, 'ú' => 2, 'ey' => 2],
                'codaMods' => ['ur' => 3, 'ir' => 2, 'ar' => 2],  // Forename codas
                // Patronymic surname endings ONLY - all Icelanders use father's name + son/dottir
                'maleEndings' => ['son', 'sson'],
                'femaleEndings' => ['dóttir', 'dottir'],
                // Note: Forename endings are applied via coda selection:
                // Male forenames typically end in: -ur, -ir, -ar, -orn, -inn
                // Female forenames typically end in: -a, -ey, -ún, -ís, -hildur
                'forenameEndingsMale' => ['ur', 'ir', 'ar', 'orn', 'inn', 'ulf'],
                'forenameEndingsFemale' => ['a', 'ey', 'ún', 'ís', 'hildur', 'dis', 'rún'],
                'prefixes' => [],
                'lengthMod' => 0,
                'patronymic' => true  // Flag indicating strict patronymic surnames
            ],
            // Finnish is Uralic (Finno-Ugric), NOT Germanic like other Nordic languages
            // Finnish has strict vowel harmony and agglutinative structure
            // Common name suffixes: -nen (patronymic/place origin), -la/-lä (place)
            'finnish' => [
                'baseCulture' => 'finnish',  // Uses dedicated Finnish base profile
                'onsetMods' => ['h' => 3, 'k' => 3, 'p' => 2, 't' => 2, 'v' => 2, 'j' => 2],
                'nucleiMods' => ['ä' => 3, 'ö' => 2, 'y' => 2, 'aa' => 2, 'ii' => 2, 'uu' => 2, 'ee' => 2],
                'codaMods' => ['nen' => 4, 'kka' => 2, 'la' => 2, 'lä' => 2],
                // Finnish surnames often end in -nen (patronymic origin) or -la/-lä (place origin)
                'maleEndings' => ['nen', 'ri', 'kka', 'mo', 'o', 'i'],
                'femaleEndings' => ['nen', 'kka', 'a', 'i', 'liina', 'ja', 'iina'],
                'prefixes' => [],
                'lengthMod' => 1,
                'vowelHarmony' => true  // Front/back vowel harmony is mandatory in Finnish
            ],
            
            // =====================
            // EASTERN DIALECTS
            // =====================
            'japanese' => [
                'baseCulture' => 'eastern',
                'onsetMods' => ['sh' => 3, 'ts' => 2, 'ry' => 2],
                'nucleiMods' => ['ou' => 2, 'uu' => 2],
                'codaMods' => ['n' => 5],
                'maleEndings' => ['ro', 'ta', 'ki', 'shi', 'suke', 'hiro'],
                'femaleEndings' => ['ko', 'mi', 'ka', 'na', 'ri', 'yo'],
                'prefixes' => [],
                'lengthMod' => 0
            ],
            'chinese' => [
                'baseCulture' => 'eastern',
                'onsetMods' => ['zh' => 3, 'ch' => 2, 'sh' => 2, 'x' => 2, 'q' => 2],
                'nucleiMods' => ['ao' => 2, 'ou' => 2, 'iu' => 2, 'ia' => 2],
                'codaMods' => ['ng' => 4, 'n' => 3],
                'maleEndings' => ['wei', 'ming', 'long', 'jun', 'feng'],
                'femaleEndings' => ['ling', 'mei', 'xia', 'yan', 'hui'],
                'prefixes' => [],
                'lengthMod' => -1
            ],
            'korean' => [
                'baseCulture' => 'eastern',
                'onsetMods' => ['ch' => 2, 'j' => 3, 'h' => 2],
                'nucleiMods' => ['eo' => 3, 'eu' => 2, 'ae' => 2],
                'codaMods' => ['ng' => 3, 'n' => 2, 'k' => 2],
                'maleEndings' => ['jun', 'ho', 'min', 'su', 'woo'],
                'femaleEndings' => ['hee', 'min', 'ji', 'young', 'soo'],
                'prefixes' => [],
                'lengthMod' => 0
            ],
            'vietnamese' => [
                'baseCulture' => 'eastern',
                'onsetMods' => ['th' => 2, 'tr' => 2, 'ng' => 3, 'nh' => 2],
                'nucleiMods' => ['uo' => 2, 'ie' => 2, 'ua' => 2],
                'codaMods' => ['nh' => 2, 'ng' => 3, 'n' => 3],
                'maleEndings' => ['anh', 'minh', 'duc', 'hung', 'tuan'],
                'femaleEndings' => ['anh', 'linh', 'trang', 'nhi', 'mai'],
                'prefixes' => [],
                'lengthMod' => 0
            ],
            'indian' => [
                'baseCulture' => 'eastern',
                'onsetMods' => ['sh' => 3, 'bh' => 2, 'dh' => 2, 'kh' => 2, 'gh' => 2],
                'nucleiMods' => ['aa' => 3, 'ee' => 2, 'ai' => 2],
                'codaMods' => ['sh' => 2],
                'maleEndings' => ['esh', 'raj', 'dev', 'kumar', 'an'],
                'femaleEndings' => ['a', 'i', 'ika', 'ini', 'ita'],
                'prefixes' => [],
                'lengthMod' => 0
            ],
            'arabic' => [
                'baseCulture' => 'eastern',
                'onsetMods' => ['kh' => 3, 'gh' => 2, 'sh' => 2, 'th' => 2],
                'nucleiMods' => ['aa' => 3, 'ii' => 2, 'uu' => 2],
                'codaMods' => ['d' => 2, 'r' => 3],
                'maleEndings' => ['id', 'ad', 'ud', 'ir', 'im', 'an'],
                'femaleEndings' => ['a', 'ah', 'iya', 'een', 'ina'],
                'prefixes' => ['Al-', 'Abd-'],
                'lengthMod' => 0
            ],
            
            // =====================
            // ELVEN DIALECTS
            // =====================
            'high_elven' => [
                'baseCulture' => 'elven',
                'onsetMods' => ['th' => 4, 'el' => 3, 'al' => 2],
                'nucleiMods' => ['ae' => 4, 'ie' => 3, 'ea' => 3],
                'codaMods' => ['th' => 3, 'ion' => 3],
                'maleEndings' => ['ion', 'or', 'iel', 'as', 'orn'],
                'femaleEndings' => ['iel', 'wen', 'ara', 'eth', 'is'],
                'prefixes' => [],
                'lengthMod' => 1
            ],
            'wood_elven' => [
                'baseCulture' => 'elven',
                'onsetMods' => ['l' => 4, 'n' => 3, 'f' => 3, 'v' => 2],
                'nucleiMods' => ['a' => 4, 'e' => 3, 'i' => 3],
                'codaMods' => ['n' => 4, 'l' => 3],
                'maleEndings' => ['an', 'en', 'il', 'ar', 'os'],
                'femaleEndings' => ['a', 'ra', 'na', 'lia', 'iel'],
                'prefixes' => [],
                'lengthMod' => 0
            ],
            'dark_elven' => [
                'baseCulture' => 'elven',
                'onsetMods' => ['v' => 3, 'z' => 3, 'x' => 2, 'dr' => 2],
                'nucleiMods' => ['i' => 4, 'a' => 3, 'y' => 2],
                'codaMods' => ['th' => 2, 'ss' => 2, 'x' => 2],
                'maleEndings' => ['rath', 'zir', 'xis', 'yn', 'oth'],
                'femaleEndings' => ['iss', 'yss', 'ira', 'yth', 'rae'],
                'prefixes' => [],
                'lengthMod' => 0
            ],
            'sea_elven' => [
                'baseCulture' => 'elven',
                'onsetMods' => ['m' => 3, 's' => 3, 'l' => 3, 'w' => 2],
                'nucleiMods' => ['ea' => 4, 'a' => 3, 'o' => 3],
                'codaMods' => ['r' => 3, 'n' => 3, 'l' => 2],
                'maleEndings' => ['mar', 'ros', 'lan', 'wer', 'or'],
                'femaleEndings' => ['mera', 'ala', 'wen', 'ora', 'iel'],
                'prefixes' => [],
                'lengthMod' => 0
            ],
            
            // =====================
            // ORCISH DIALECTS
            // =====================
            'mountain_orc' => [
                'baseCulture' => 'orcish',
                'onsetMods' => ['kr' => 4, 'gr' => 4, 'dr' => 3],
                'nucleiMods' => ['u' => 4, 'o' => 3],
                'codaMods' => ['rk' => 4, 'gk' => 3],
                'maleEndings' => ['grak', 'kur', 'gor', 'drak', 'thur'],
                'femaleEndings' => ['gra', 'kra', 'ura', 'sha'],
                'prefixes' => [],
                'lengthMod' => 0
            ],
            'plains_orc' => [
                'baseCulture' => 'orcish',
                'onsetMods' => ['g' => 3, 'k' => 3, 'z' => 3],
                'nucleiMods' => ['a' => 4, 'o' => 3],
                'codaMods' => ['g' => 3, 'sh' => 3],
                'maleEndings' => ['ash', 'gar', 'zog', 'gash', 'rok'],
                'femaleEndings' => ['sha', 'ga', 'za', 'ra'],
                'prefixes' => [],
                'lengthMod' => 0
            ],
            'half_orc' => [
                'baseCulture' => 'orcish',
                'onsetMods' => ['g' => 2, 'k' => 2, 'br' => 2, 'th' => 2],
                'nucleiMods' => ['a' => 3, 'o' => 3, 'e' => 2],
                'codaMods' => ['n' => 3, 'r' => 3, 'k' => 2],
                'maleEndings' => ['orn', 'ar', 'ek', 'dan', 'gorn'],
                'femaleEndings' => ['ra', 'na', 'eka', 'ara'],
                'prefixes' => [],
                'lengthMod' => 0
            ],
            
            // =====================
            // DWARVEN DIALECTS
            // =====================
            'mountain_dwarf' => [
                'baseCulture' => 'dwarven',
                'onsetMods' => ['th' => 3, 'gr' => 3, 'kr' => 3],
                'nucleiMods' => ['o' => 4, 'a' => 3],
                'codaMods' => ['rn' => 3, 'rm' => 3, 'rd' => 3],
                'maleEndings' => ['grim', 'orn', 'dur', 'dan', 'rik'],
                'femaleEndings' => ['dis', 'ra', 'da', 'hild'],
                'prefixes' => [],
                'lengthMod' => 0
            ],
            'hill_dwarf' => [
                'baseCulture' => 'dwarven',
                'onsetMods' => ['b' => 3, 'd' => 3, 'g' => 2],
                'nucleiMods' => ['a' => 4, 'i' => 3],
                'codaMods' => ['n' => 4, 'd' => 3],
                'maleEndings' => ['in', 'din', 'bin', 'li', 'mund'],
                'femaleEndings' => ['a', 'lin', 'da', 'ri'],
                'prefixes' => [],
                'lengthMod' => 0
            ],
            'deep_dwarf' => [
                'baseCulture' => 'dwarven',
                'onsetMods' => ['dr' => 4, 'kr' => 3, 'z' => 3],
                'nucleiMods' => ['u' => 4, 'o' => 3],
                'codaMods' => ['rg' => 4, 'rk' => 3],
                'maleEndings' => ['durg', 'krag', 'zorn', 'thur', 'gund'],
                'femaleEndings' => ['dra', 'kra', 'za', 'thura'],
                'prefixes' => [],
                'lengthMod' => 0
            ],
            
            // =====================
            // DRACONIC DIALECTS
            // =====================
            'chromatic' => [
                'baseCulture' => 'draconic',
                'onsetMods' => ['z' => 4, 'x' => 3, 'v' => 3],
                'nucleiMods' => ['i' => 4, 'a' => 3],
                'codaMods' => ['ss' => 4, 'zz' => 3],
                'maleEndings' => ['azz', 'ixis', 'oth', 'zarr', 'yss'],
                'femaleEndings' => ['iss', 'yss', 'ara', 'ith'],
                'prefixes' => [],
                'lengthMod' => 0
            ],
            'metallic' => [
                'baseCulture' => 'draconic',
                'onsetMods' => ['s' => 4, 'th' => 3, 'l' => 3],
                'nucleiMods' => ['a' => 4, 'ae' => 3, 'ia' => 3],
                'codaMods' => ['th' => 4, 's' => 3],
                'maleEndings' => ['ath', 'ius', 'arix', 'orn', 'ax'],
                'femaleEndings' => ['ia', 'ara', 'ith', 'essa'],
                'prefixes' => [],
                'lengthMod' => 1
            ],
            'ancient' => [
                'baseCulture' => 'draconic',
                'onsetMods' => ['rh' => 4, 'th' => 3, 'x' => 3],
                'nucleiMods' => ['aa' => 4, 'ae' => 3, 'uo' => 3],
                'codaMods' => ['xis' => 4, 'ath' => 3],
                'maleEndings' => ['xarion', 'thumax', 'aarix', 'ormath'],
                'femaleEndings' => ['xaria', 'thia', 'aara', 'ormith'],
                'prefixes' => [],
                'lengthMod' => 1
            ]
        ];
    }
    
    /**
     * Get dialect profile
     * @param string $dialect Dialect key
     * @return array|null Dialect profile or null if not found
     */
    public function getDialect($dialect) {
        return $this->dialects[$dialect] ?? null;
    }
    
    /**
     * Get all available dialects
     * @return array All dialect keys
     */
    public function getAvailableDialects() {
        return array_keys($this->dialects);
    }
    
    /**
     * Get dialects for a specific culture
     * @param string $culture Base culture
     * @return array Dialect keys for that culture
     */
    public function getDialectsForCulture($culture) {
        $matching = [];
        foreach ($this->dialects as $key => $profile) {
            if ($profile['baseCulture'] === $culture) {
                $matching[] = $key;
            }
        }
        return $matching;
    }
    
    /**
     * Apply dialect modifications to base profile
     * @param array $baseProfile Base phonetic profile
     * @param string $dialect Dialect to apply
     * @param string $gender Gender for endings
     * @return array Modified profile
     */
    public function applyDialect($baseProfile, $dialect, $gender = 'male') {
        $dialectProfile = $this->getDialect($dialect);
        if (!$dialectProfile) {
            return $baseProfile;
        }
        
        $modified = $baseProfile;
        
        // Add dialect-specific onset preferences
        if (!empty($dialectProfile['onsetMods'])) {
            foreach (['initial', 'medial'] as $pos) {
                if (isset($modified['onsets'][$pos])) {
                    foreach ($dialectProfile['onsetMods'] as $phoneme => $weight) {
                        $modified['onsets'][$pos][$phoneme] = ($modified['onsets'][$pos][$phoneme] ?? 0) + $weight;
                    }
                }
            }
        }
        
        // Add dialect-specific vowel preferences
        if (!empty($dialectProfile['nucleiMods'])) {
            foreach (['stressed', 'unstressed'] as $stress) {
                if (isset($modified['nuclei'][$stress])) {
                    foreach ($dialectProfile['nucleiMods'] as $phoneme => $weight) {
                        $modified['nuclei'][$stress][$phoneme] = ($modified['nuclei'][$stress][$phoneme] ?? 0) + $weight;
                    }
                }
            }
        }
        
        // Add dialect-specific coda preferences  
        if (!empty($dialectProfile['codaMods'])) {
            foreach (['medial', 'final'] as $pos) {
                if (isset($modified['codas'][$pos])) {
                    foreach ($dialectProfile['codaMods'] as $phoneme => $weight) {
                        $modified['codas'][$pos][$phoneme] = ($modified['codas'][$pos][$phoneme] ?? 0) + $weight;
                    }
                }
            }
        }
        
        // Apply length modification
        if (isset($dialectProfile['lengthMod']) && $dialectProfile['lengthMod'] !== 0) {
            $modified['length'][0] = max(1, $modified['length'][0] + $dialectProfile['lengthMod']);
            $modified['length'][1] = max(2, $modified['length'][1] + $dialectProfile['lengthMod']);
        }
        
        // Apply vowel harmony if specified
        if (!empty($dialectProfile['vowelHarmony'])) {
            $modified['vowelHarmony'] = true;
        }
        
        // Store dialect endings for later use
        $modified['_dialectEndings'] = [
            'male' => $dialectProfile['maleEndings'] ?? [],
            'female' => $dialectProfile['femaleEndings'] ?? []
        ];
        
        $modified['_dialectPrefixes'] = $dialectProfile['prefixes'] ?? [];
        
        return $modified;
    }
    
    /**
     * Get a random dialect ending for the given gender
     * @param array $profile Modified profile with dialect data
     * @param string $gender Gender
     * @return string|null Ending or null
     */
    public function getDialectEnding($profile, $gender) {
        $endings = $profile['_dialectEndings'][$gender] ?? [];
        if (empty($endings)) {
            return null;
        }
        return $endings[array_rand($endings)];
    }
    
    /**
     * Get a random dialect prefix
     * @param array $profile Modified profile with dialect data
     * @return string|null Prefix or null
     */
    public function getDialectPrefix($profile) {
        $prefixes = $profile['_dialectPrefixes'] ?? [];
        if (empty($prefixes)) {
            return null;
        }
        // Only apply prefix sometimes (30% chance)
        if (rand(1, 100) > 30) {
            return null;
        }
        return $prefixes[array_rand($prefixes)];
    }
}
?>
