# Name Generator API Documentation

> **Version:** 1.0  
> **Last Updated:** January 2026

## Base URLs

| Environment | Base URL |
|-------------|----------|
| Local Development | `https://127.0.0.1/name_generator/api` |
| Production | `https://webhatchery.au/name_generator/api` |

---

## Authentication

All API requests require an API key passed in the `X-API-KEY` header.

```http
X-API-KEY: your_api_key_here
```

**Development Key:** `development_key_123`

---

## Endpoints

### 1. Generate People Names

Generate names for characters, NPCs, or people.

```
GET /generate_name.php
```

#### Parameters

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `count` | integer | No | 1 | Number of names to generate (1-20) |
| `gender` | string | No | `male` | Gender: `any`, `male`, `female` |
| `culture` | string | No | `western` | Cultural style (see [Cultures](#cultures)) |
| `method` | string | No | `markov_chain` | Generation algorithm (see [Methods](#generation-methods)) |
| `type` | string | No | `full_name` | Name type (see [Types](#name-types)) |
| `period` | string | No | `modern` | Time period: `modern`, `medieval`, `ancient` |
| `dialect` | string | No | `any` | Regional dialect (see [Dialects](#dialects)) |
| `excludeReal` | string | No | `0` | Exclude real names: `0` or `1` |

#### Example Request

```bash
curl -X GET "https://webhatchery.au/name_generator/api/generate_name.php?count=5&gender=female&culture=elven&method=phonetic_pattern&dialect=high_elven" \
  -H "X-API-KEY: your_api_key"
```

#### Example Response

```json
{
  "names": [
    "Aelindiel",
    "Thaerwen",
    "Celebriel",
    "Nimrothiel",
    "Galathiel"
  ]
}
```

---

### 2. Generate Place Names

Generate names for locations, cities, landmarks, etc.

```
GET /generate_place.php
```

#### Parameters

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `count` | integer | No | 1 | Number of names to generate |
| `genre` | string | No | `fantasy` | Genre: `fantasy`, `realistic`, `sci-fi` |
| `location_type` | string | No | `city` | Type: `city`, `town`, `village`, `landmark`, `country` |
| `tone` | string | No | `neutral` | Tone: `neutral`, `dark`, `bright`, `mysterious` |
| `climate` | string | No | `temperate` | Climate setting |
| `size` | string | No | `medium` | Size: `small`, `medium`, `large` |

#### Example Request

```bash
curl -X GET "https://webhatchery.au/name_generator/api/generate_place.php?count=3&genre=fantasy&location_type=city" \
  -H "X-API-KEY: your_api_key"
```

#### Example Response

```json
{
  "names": [
    "Silverhaven",
    "Thornhollow",
    "Mistbridge"
  ]
}
```

---

### 3. Generate Event Names

Generate names for events, festivals, battles, etc.

```
GET /generate_event.php
```

#### Parameters

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `count` | integer | No | 1 | Number of names to generate |
| `type` | string | No | `festival` | Event type: `festival`, `battle`, `ceremony`, `tournament` |
| `theme` | string | No | `general` | Theme: `general`, `royal`, `religious`, `military` |
| `tone` | string | No | `neutral` | Tone: `neutral`, `dark`, `celebratory` |

#### Example Request

```bash
curl -X GET "https://webhatchery.au/name_generator/api/generate_event.php?count=3&type=battle&tone=dark" \
  -H "X-API-KEY: your_api_key"
```

#### Example Response

```json
{
  "names": [
    "The Siege of Blackvale",
    "The Crimson Reckoning",
    "The Fall of Thorncrest"
  ]
}
```

---

### 4. Generate Title Names

Generate titles, epithets, and honorifics.

```
GET /generate_title.php
```

#### Parameters

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `count` | integer | No | 1 | Number of titles to generate |
| `type` | string | No | `epithet` | Type: `epithet`, `noble`, `military`, `religious` |
| `genre` | string | No | `fantasy` | Genre: `fantasy`, `historical`, `sci-fi` |
| `tone` | string | No | `neutral` | Tone: `neutral`, `heroic`, `dark`, `humble` |
| `keywords` | string | No | ` ` | Keywords to incorporate |
| `setting` | string | No | `medieval` | Setting: `medieval`, `modern`, `ancient` |
| `gender` | string | No | `any` | Gender: `any`, `male`, `female` |
| `race` | string | No | `human` | Race/species |
| `species` | string | No | ` ` | Species (alternative to race) |

#### Example Response

```json
{
  "titles": [
    "The Ironheart",
    "Defender of the Realm",
    "The Unbroken"
  ]
}
```

---

### 5. Batch Generation

Generate multiple name types in a single request.

```
GET /generate_batch.php
```

#### Parameters

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `count` | integer | No | 1 | Number of each type to generate |
| `types[]` | string[] | Yes | - | Array of types: `people`, `places`, `events`, `titles` |

#### Example Request

```bash
curl -X GET "https://webhatchery.au/name_generator/api/generate_batch.php?count=2&types[]=people&types[]=places" \
  -H "X-API-KEY: your_api_key"
```

#### Example Response

```json
{
  "people": ["Marcus Thornwood", "Elena Brightwater"],
  "places": ["Ravenshollow", "Stormwatch Keep"]
}
```

---

### 6. Get Options

Retrieve available options for dropdowns/select fields.

```
GET /options.php
```

#### Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `field` | string | Yes | Field name to get options for |

**Available fields:** `gender`, `culture`, `method`, `type`, `period`, `dialect`

#### Example Request

```bash
curl -X GET "https://webhatchery.au/name_generator/api/options.php?field=culture" \
  -H "X-API-KEY: your_api_key"
```

#### Example Response

```json
[
  { "value": "any", "label": "Any" },
  { "value": "western", "label": "Western (General)" },
  { "value": "nordic", "label": "Nordic (General)" },
  { "value": "eastern", "label": "Eastern (General)" },
  { "value": "elven", "label": "Elven" },
  { "value": "orcish", "label": "Orcish" },
  { "value": "dwarven", "label": "Dwarven" },
  { "value": "draconic", "label": "Draconic" }
]
```

---

## Reference Tables

### Cultures

| Value | Description |
|-------|-------------|
| `any` | Random culture |
| `western` | Western European style |
| `nordic` | Scandinavian style |
| `eastern` | East Asian / Middle Eastern style |
| `elven` | Fantasy elven names |
| `orcish` | Fantasy orcish names |
| `dwarven` | Fantasy dwarven names |
| `draconic` | Dragon-inspired names |

### Generation Methods

| Value | Description |
|-------|-------------|
| `markov_chain` | Statistical pattern-based generation |
| `syllable_based` | Syllable concatenation |
| `phonetic_pattern` | Phoneme-based with dialect support |
| `historical_pattern` | Period-appropriate historical names |
| `fantasy_generated` | Pure fantasy names |

### Name Types

| Value | Description |
|-------|-------------|
| `full_name` | First and last name |
| `first_only` | First name only |
| `last_only` | Surname only |
| `nickname` | Informal name/alias |
| `formal` | Formal/titled name |

### Dialects

Dialects are **only supported with `phonetic_pattern` method**.

#### Western Dialects
| Value | Label |
|-------|-------|
| `british` | British |
| `american` | American |
| `french` | French |
| `german` | German |
| `italian` | Italian |
| `spanish` | Spanish |
| `irish` | Irish/Celtic |

#### Nordic Dialects
| Value | Label |
|-------|-------|
| `swedish` | Swedish |
| `norwegian` | Norwegian |
| `danish` | Danish |
| `icelandic` | Icelandic |
| `finnish` | Finnish |

#### Eastern Dialects
| Value | Label |
|-------|-------|
| `japanese` | Japanese |
| `chinese` | Chinese |
| `korean` | Korean |
| `vietnamese` | Vietnamese |
| `indian` | Indian |
| `arabic` | Arabic |

#### Fantasy Dialects

**Elven:**
`high_elven`, `wood_elven`, `dark_elven`, `sea_elven`

**Orcish:**
`mountain_orc`, `plains_orc`, `half_orc`

**Dwarven:**
`mountain_dwarf`, `hill_dwarf`, `deep_dwarf`

**Draconic:**
`chromatic`, `metallic`, `ancient`

---

## Error Responses

### 400 Bad Request

```json
{
  "error": "Invalid or missing field parameter"
}
```

### 401 Unauthorized

```json
{
  "error": "Missing or invalid API key"
}
```

### 404 Not Found

```json
{
  "error": "Endpoint not found or forbidden"
}
```

### 500 Internal Server Error

```json
{
  "error": "Backend processing error"
}
```

---

## Code Examples

### JavaScript/TypeScript

```typescript
const API_BASE = 'https://webhatchery.au/name_generator/api';
const API_KEY = 'your_api_key';

async function generateNames(options: {
  count?: number;
  gender?: string;
  culture?: string;
  method?: string;
  dialect?: string;
}) {
  const params = new URLSearchParams({
    count: (options.count || 5).toString(),
    gender: options.gender || 'any',
    culture: options.culture || 'western',
    method: options.method || 'phonetic_pattern',
    dialect: options.dialect || 'any',
  });

  const response = await fetch(`${API_BASE}/generate_name.php?${params}`, {
    headers: { 'X-API-KEY': API_KEY },
  });

  if (!response.ok) throw new Error('API request failed');
  return response.json();
}

// Usage
const names = await generateNames({
  count: 10,
  culture: 'elven',
  method: 'phonetic_pattern',
  dialect: 'high_elven',
  gender: 'female'
});
console.log(names);
```

### Python

```python
import requests

API_BASE = 'https://webhatchery.au/name_generator/api'
API_KEY = 'your_api_key'

def generate_names(count=5, culture='western', gender='any', 
                   method='phonetic_pattern', dialect='any'):
    response = requests.get(
        f'{API_BASE}/generate_name.php',
        params={
            'count': count,
            'culture': culture,
            'gender': gender,
            'method': method,
            'dialect': dialect,
        },
        headers={'X-API-KEY': API_KEY}
    )
    response.raise_for_status()
    return response.json()['names']

# Usage
names = generate_names(
    count=10, 
    culture='nordic', 
    dialect='icelandic',
    gender='male'
)
print(names)
```

### C# / Unity

```csharp
using UnityEngine;
using UnityEngine.Networking;
using System.Collections;

public class NameGenerator : MonoBehaviour
{
    private const string API_BASE = "https://webhatchery.au/name_generator/api";
    private const string API_KEY = "your_api_key";

    public IEnumerator GenerateNames(int count, string culture, string dialect, 
                                      System.Action<string[]> callback)
    {
        string url = $"{API_BASE}/generate_name.php?count={count}&culture={culture}" +
                     $"&method=phonetic_pattern&dialect={dialect}";
        
        using (UnityWebRequest request = UnityWebRequest.Get(url))
        {
            request.SetRequestHeader("X-API-KEY", API_KEY);
            yield return request.SendWebRequest();

            if (request.result == UnityWebRequest.Result.Success)
            {
                var response = JsonUtility.FromJson<NameResponse>(request.downloadHandler.text);
                callback(response.names);
            }
        }
    }

    [System.Serializable]
    private class NameResponse { public string[] names; }
}
```

---

## Rate Limits

| Tier | Requests/Minute | Requests/Day |
|------|-----------------|--------------|
| Development | 60 | Unlimited |
| Production | 120 | 10,000 |

---

## Changelog

### v1.0 (January 2026)
- Initial API release
- Support for people, places, events, and titles
- Phonetic pattern generation with 28 regional dialects
- 7 cultural profiles with gender-aware generation
