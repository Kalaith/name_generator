import { describe, it, expect, vi, beforeEach, afterEach } from 'vitest';
import {
    fetchPeopleNames,
    fetchPlaceNames,
    fetchEventNames,
    fetchTitleNames,
    fetchBatchResults,
    fetchSelectOptions,
    fetchDialectOptions,
} from './api';

// Mock global fetch
const mockFetch = vi.fn();
global.fetch = mockFetch;

describe('API Utils', () => {
    beforeEach(() => {
        mockFetch.mockClear();
    });

    afterEach(() => {
        vi.restoreAllMocks();
    });

    describe('fetchPeopleNames', () => {
        it('should fetch people names with correct query params', async () => {
            const mockResponse = {
                names: [
                    { name: 'John Doe', firstName: 'John', lastName: 'Doe', culture: 'western', gender: 'male', method: 'markov_chain', origin: 'English', meaning: 'God is gracious', pronunciation: '/john/', period: 'modern' },
                ],
            };
            mockFetch.mockResolvedValueOnce({
                ok: true,
                json: () => Promise.resolve(mockResponse),
            });

            const params = {
                count: 5,
                gender: 'male',
                culture: 'western',
                method: 'markov_chain',
                type: 'full_name',
                period: 'modern',
                dialect: 'any',
                excludeReal: false,
            };

            const result = await fetchPeopleNames(params);

            expect(mockFetch).toHaveBeenCalledTimes(1);
            expect(mockFetch).toHaveBeenCalledWith(
                expect.stringContaining('api/generate_name.php'),
                expect.objectContaining({
                    headers: expect.objectContaining({
                        'Content-Type': 'application/json',
                        'X-API-KEY': 'development_key_123',
                    }),
                })
            );
            expect(result).toEqual(mockResponse.names);
        });

        it('should throw error on API failure', async () => {
            mockFetch.mockResolvedValueOnce({ ok: false });

            const params = {
                count: 1,
                gender: 'any',
                culture: 'any',
                method: 'markov_chain',
                type: 'full_name',
                period: 'modern',
                dialect: 'any',
                excludeReal: false,
            };

            await expect(fetchPeopleNames(params)).rejects.toThrow('API error');
        });

        it('should include dialect in query params', async () => {
            mockFetch.mockResolvedValueOnce({
                ok: true,
                json: () => Promise.resolve({ names: [] }),
            });

            const params = {
                count: 1,
                gender: 'male',
                culture: 'japanese',
                method: 'phonetic_pattern',
                type: 'full_name',
                period: 'modern',
                dialect: 'kansai',
                excludeReal: true,
            };

            await fetchPeopleNames(params);

            const calledUrl = mockFetch.mock.calls[0][0];
            expect(calledUrl).toContain('dialect=kansai');
            expect(calledUrl).toContain('excludeReal=1');
        });
    });

    describe('fetchPlaceNames', () => {
        it('should fetch place names with correct params', async () => {
            const mockResponse = { names: ['Silverdale', 'Oakwood Manor'] };
            mockFetch.mockResolvedValueOnce({
                ok: true,
                json: () => Promise.resolve(mockResponse),
            });

            const params = {
                count: 2,
                genre: 'fantasy',
                location_type: 'city',
                tone: 'epic',
                climate: 'temperate',
                size: 'large',
            };

            const result = await fetchPlaceNames(params);

            expect(mockFetch).toHaveBeenCalledWith(
                expect.stringContaining('api/generate_place.php'),
                expect.any(Object)
            );
            expect(result).toEqual(['Silverdale', 'Oakwood Manor']);
        });

        it('should handle alternative response format with locations', async () => {
            mockFetch.mockResolvedValueOnce({
                ok: true,
                json: () => Promise.resolve({ locations: ['Place A', 'Place B'] }),
            });

            const params = {
                count: 2,
                genre: 'fantasy',
                location_type: 'city',
                tone: 'epic',
                climate: 'temperate',
                size: 'large',
            };

            const result = await fetchPlaceNames(params);
            expect(result).toEqual(['Place A', 'Place B']);
        });

        it('should return empty array when no names or locations', async () => {
            mockFetch.mockResolvedValueOnce({
                ok: true,
                json: () => Promise.resolve({}),
            });

            const params = {
                count: 1,
                genre: 'fantasy',
                location_type: 'city',
                tone: 'epic',
                climate: 'temperate',
                size: 'large',
            };

            const result = await fetchPlaceNames(params);
            expect(result).toEqual([]);
        });

        it('should throw error on API failure', async () => {
            mockFetch.mockResolvedValueOnce({ ok: false });

            const params = {
                count: 1,
                genre: 'fantasy',
                location_type: 'city',
                tone: 'epic',
                climate: 'temperate',
                size: 'large',
            };

            await expect(fetchPlaceNames(params)).rejects.toThrow('API error');
        });
    });

    describe('fetchEventNames', () => {
        it('should fetch event names with correct params', async () => {
            const mockResponse = { names: ['The Great War', 'Festival of Lights'] };
            mockFetch.mockResolvedValueOnce({
                ok: true,
                json: () => Promise.resolve(mockResponse),
            });

            const params = {
                count: 2,
                type: 'historical',
                theme: 'war',
                tone: 'dramatic',
            };

            const result = await fetchEventNames(params);

            expect(mockFetch).toHaveBeenCalledWith(
                expect.stringContaining('api/generate_event.php'),
                expect.any(Object)
            );
            expect(result).toEqual(['The Great War', 'Festival of Lights']);
        });

        it('should return empty array when no names', async () => {
            mockFetch.mockResolvedValueOnce({
                ok: true,
                json: () => Promise.resolve({}),
            });

            const params = { count: 1, type: 'historical', theme: 'war', tone: 'dramatic' };
            const result = await fetchEventNames(params);
            expect(result).toEqual([]);
        });

        it('should throw error on API failure', async () => {
            mockFetch.mockResolvedValueOnce({ ok: false });

            const params = { count: 1, type: 'historical', theme: 'war', tone: 'dramatic' };
            await expect(fetchEventNames(params)).rejects.toThrow('API error');
        });
    });

    describe('fetchTitleNames', () => {
        it('should fetch title names with correct params', async () => {
            const mockResponse = { titles: ['Lord of the Rings', 'The Crown Prince'] };
            mockFetch.mockResolvedValueOnce({
                ok: true,
                json: () => Promise.resolve(mockResponse),
            });

            const params = {
                count: 2,
                type: 'book',
                genre: 'fantasy',
                tone: 'epic',
                keywords: 'adventure',
                setting: 'medieval',
                gender: 'any',
                race: 'human',
                species: 'any',
            };

            const result = await fetchTitleNames(params);

            expect(mockFetch).toHaveBeenCalledWith(
                expect.stringContaining('api/generate_title.php'),
                expect.any(Object)
            );
            expect(result).toEqual(['Lord of the Rings', 'The Crown Prince']);
        });

        it('should return empty array when no titles', async () => {
            mockFetch.mockResolvedValueOnce({
                ok: true,
                json: () => Promise.resolve({}),
            });

            const params = {
                count: 1,
                type: 'book',
                genre: 'fantasy',
                tone: 'epic',
                keywords: '',
                setting: 'medieval',
                gender: 'any',
                race: 'human',
                species: 'any',
            };

            const result = await fetchTitleNames(params);
            expect(result).toEqual([]);
        });

        it('should throw error on API failure', async () => {
            mockFetch.mockResolvedValueOnce({ ok: false });

            const params = {
                count: 1,
                type: 'book',
                genre: 'fantasy',
                tone: 'epic',
                keywords: '',
                setting: 'medieval',
                gender: 'any',
                race: 'human',
                species: 'any',
            };

            await expect(fetchTitleNames(params)).rejects.toThrow('API error');
        });
    });

    describe('fetchBatchResults', () => {
        it('should fetch batch results with array types', async () => {
            const mockResponse = {
                people: ['John', 'Jane'],
                places: ['City A', 'Town B'],
            };
            mockFetch.mockResolvedValueOnce({
                ok: true,
                json: () => Promise.resolve(mockResponse),
            });

            const params = {
                count: 2,
                types: ['people', 'places'],
            };

            const result = await fetchBatchResults(params);

            expect(mockFetch).toHaveBeenCalledWith(
                expect.stringContaining('api/generate_batch.php'),
                expect.any(Object)
            );

            // Verify types[] are appended correctly
            const calledUrl = mockFetch.mock.calls[0][0];
            expect(calledUrl).toContain('types%5B%5D=people');
            expect(calledUrl).toContain('types%5B%5D=places');

            expect(result).toEqual(mockResponse);
        });

        it('should throw error on API failure', async () => {
            mockFetch.mockResolvedValueOnce({ ok: false });

            const params = { count: 1, types: ['people'] };
            await expect(fetchBatchResults(params)).rejects.toThrow('API error');
        });
    });

    describe('fetchSelectOptions', () => {
        it('should fetch options for a field', async () => {
            const mockResponse = [
                { value: 'male', label: 'Male' },
                { value: 'female', label: 'Female' },
                { value: 'any', label: 'Any' },
            ];
            mockFetch.mockResolvedValueOnce({
                ok: true,
                json: () => Promise.resolve(mockResponse),
            });

            const result = await fetchSelectOptions('gender');

            expect(mockFetch).toHaveBeenCalledWith(
                expect.stringContaining('api/options.php?field=gender'),
                expect.any(Object)
            );
            expect(result).toEqual(mockResponse);
        });

        it('should encode field name properly', async () => {
            mockFetch.mockResolvedValueOnce({
                ok: true,
                json: () => Promise.resolve([]),
            });

            await fetchSelectOptions('special&field');

            const calledUrl = mockFetch.mock.calls[0][0];
            expect(calledUrl).toContain('field=special%26field');
        });

        it('should throw error on API failure', async () => {
            mockFetch.mockResolvedValueOnce({ ok: false });

            await expect(fetchSelectOptions('gender')).rejects.toThrow('Failed to fetch options');
        });
    });

    describe('fetchDialectOptions', () => {
        it('should fetch dialect options', async () => {
            const mockResponse = [
                { value: 'any', label: 'Any / Default', cultures: ['all'] },
                { value: 'kansai', label: 'Kansai', cultures: ['japanese'] },
            ];
            mockFetch.mockResolvedValueOnce({
                ok: true,
                json: () => Promise.resolve(mockResponse),
            });

            const result = await fetchDialectOptions();

            expect(mockFetch).toHaveBeenCalledWith(
                expect.stringContaining('api/options.php?field=dialect'),
                expect.any(Object)
            );
            expect(result).toEqual(mockResponse);
        });

        it('should throw error on API failure', async () => {
            mockFetch.mockResolvedValueOnce({ ok: false });

            await expect(fetchDialectOptions()).rejects.toThrow('Failed to fetch dialect options');
        });
    });
});
