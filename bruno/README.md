# Name Generator API - Bruno Test Collection

A comprehensive API test collection for the Name Generator API.

## Setup

1. Install [Bruno](https://www.usebruno.com/) - a fast and git-friendly API client
2. Open Bruno and select "Open Collection"
3. Navigate to this `bruno` folder and open it

## Environments

Two environments are configured:

- **test** - Local development (`http://127.0.0.1/name_generator/api`)
- **production** - Live server (`https://webhatchery.art/name_generator/api`)

Select the appropriate environment in Bruno before running tests.

## Test Categories

### People (5 tests)
Tests for all name generation methods:
- Markov Chain
- Syllable Based
- Phonetic Pattern (with dialect support)
- Historical Pattern
- Fantasy Generated

### Places (3 tests)
- Fantasy settlements
- Modern urban locations
- Water features

### Events (2 tests)
- Technology conferences
- Arts festivals

### Titles (3 tests)
- Fantasy book titles
- Dark heroic titles
- Elven quest titles

### Batch (2 tests)
- All types combined
- People only

### Options (4 tests)
- Gender options
- Culture options
- Genre options
- Dialect options (with culture filtering)

## Running Tests

1. Select an environment (test or production)
2. Run individual requests or use "Run Collection" to run all tests
3. All tests include assertions to validate:
   - Status code is 200
   - Response contains expected data structure
   - Correct count of results returned

## API Key

The default API key `development_key_123` is configured in the environment files. Update as needed for production use.
