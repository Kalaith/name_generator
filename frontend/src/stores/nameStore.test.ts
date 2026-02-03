import { describe, it, expect, beforeEach, vi } from 'vitest';
import { useNameStore, createPersonName, createPlaceName, createEventName, createTitleName } from './nameStore';
import type { PersonNameResult } from '../types';

// Mock crypto.randomUUID
vi.stubGlobal('crypto', {
    randomUUID: () => 'test-uuid-' + Math.random().toString(36).substr(2, 9),
});

describe('nameStore', () => {
    beforeEach(() => {
        // Reset store before each test
        useNameStore.getState().clearAll();
    });

    describe('addGeneratedNames', () => {
        it('should add generated names to the store', () => {
            const names = [
                { id: '1', name: 'John', type: 'person' as const, details: {}, generatedAt: new Date() },
                { id: '2', name: 'Jane', type: 'person' as const, details: {}, generatedAt: new Date() },
            ];

            useNameStore.getState().addGeneratedNames(names);

            const state = useNameStore.getState();
            expect(state.generatedNames).toHaveLength(2);
            expect(state.history).toHaveLength(2);
        });

        it('should generate IDs for names without IDs', () => {
            const names = [
                { id: '', name: 'NoId', type: 'person' as const, details: {}, generatedAt: new Date() },
            ];

            useNameStore.getState().addGeneratedNames(names);

            const state = useNameStore.getState();
            expect(state.generatedNames[0].id).toBeTruthy();
        });

        it('should cap history at 100 items', () => {
            // Add 50 names twice (100 total) then add more
            const batch1 = Array.from({ length: 60 }, (_, i) => ({
                id: `batch1-${i}`,
                name: `Name ${i}`,
                type: 'person' as const,
                details: {},
                generatedAt: new Date(),
            }));

            useNameStore.getState().addGeneratedNames(batch1);

            const batch2 = Array.from({ length: 50 }, (_, i) => ({
                id: `batch2-${i}`,
                name: `Name ${i + 60}`,
                type: 'person' as const,
                details: {},
                generatedAt: new Date(),
            }));

            useNameStore.getState().addGeneratedNames(batch2);

            const state = useNameStore.getState();
            expect(state.history.length).toBeLessThanOrEqual(100);
        });
    });

    describe('clearGeneratedNames', () => {
        it('should clear generated names but keep history', () => {
            const names = [
                { id: '1', name: 'John', type: 'person' as const, details: {}, generatedAt: new Date() },
            ];

            useNameStore.getState().addGeneratedNames(names);
            useNameStore.getState().clearGeneratedNames();

            const state = useNameStore.getState();
            expect(state.generatedNames).toHaveLength(0);
            expect(state.history).toHaveLength(1); // History preserved
        });
    });

    describe('favorites', () => {
        it('should add to favorites', () => {
            useNameStore.getState().addToFavorites('name-1');
            useNameStore.getState().addToFavorites('name-2');

            const state = useNameStore.getState();
            expect(state.favorites).toContain('name-1');
            expect(state.favorites).toContain('name-2');
        });

        it('should not duplicate favorites', () => {
            useNameStore.getState().addToFavorites('name-1');
            useNameStore.getState().addToFavorites('name-1');

            const state = useNameStore.getState();
            expect(state.favorites).toHaveLength(1);
        });

        it('should remove from favorites', () => {
            useNameStore.getState().addToFavorites('name-1');
            useNameStore.getState().addToFavorites('name-2');
            useNameStore.getState().removeFromFavorites('name-1');

            const state = useNameStore.getState();
            expect(state.favorites).not.toContain('name-1');
            expect(state.favorites).toContain('name-2');
        });

        it('should clear all favorites', () => {
            useNameStore.getState().addToFavorites('name-1');
            useNameStore.getState().addToFavorites('name-2');
            useNameStore.getState().clearFavorites();

            const state = useNameStore.getState();
            expect(state.favorites).toHaveLength(0);
        });
    });

    describe('history', () => {
        it('should clear history', () => {
            const names = [
                { id: '1', name: 'John', type: 'person' as const, details: {}, generatedAt: new Date() },
            ];

            useNameStore.getState().addGeneratedNames(names);
            useNameStore.getState().clearHistory();

            const state = useNameStore.getState();
            expect(state.history).toHaveLength(0);
        });
    });

    describe('preferences', () => {
        it('should update preferences partially', () => {
            useNameStore.getState().updatePreferences({ defaultCount: 20 });

            const state = useNameStore.getState();
            expect(state.preferences.defaultCount).toBe(20);
            expect(state.preferences.nameLength).toBe('medium'); // Default preserved
        });

        it('should reset preferences to defaults', () => {
            useNameStore.getState().updatePreferences({ defaultCount: 20, nameLength: 'long' });
            useNameStore.getState().resetPreferences();

            const state = useNameStore.getState();
            expect(state.preferences.defaultCount).toBe(10);
            expect(state.preferences.nameLength).toBe('medium');
        });
    });

    describe('parameters', () => {
        it('should save and retrieve parameters', () => {
            const peopleParams = {
                count: 5,
                gender: 'male',
                culture: 'western',
                method: 'markov_chain',
                type: 'full_name',
                period: 'modern',
                dialect: 'any',
                excludeReal: false,
            };

            useNameStore.getState().saveParameters('people', peopleParams);

            const retrieved = useNameStore.getState().getLastParameters('people');
            expect(retrieved).toEqual(peopleParams);
        });

        it('should return null for unknown parameter type', () => {
            const result = useNameStore.getState().getLastParameters('unknown');
            expect(result).toBeNull();
        });
    });

    describe('utility functions', () => {
        it('should find name by id in history', () => {
            const names = [
                { id: 'unique-id', name: 'John', type: 'person' as const, details: {}, generatedAt: new Date() },
            ];

            useNameStore.getState().addGeneratedNames(names);

            const found = useNameStore.getState().findNameById('unique-id');
            expect(found).toBeDefined();
            expect(found?.name).toBe('John');
        });

        it('should return undefined for non-existent id', () => {
            const found = useNameStore.getState().findNameById('non-existent');
            expect(found).toBeUndefined();
        });

        it('should get names by type', () => {
            const names = [
                { id: '1', name: 'John', type: 'person' as const, details: {}, generatedAt: new Date() },
                { id: '2', name: 'Silverdale', type: 'place' as const, details: {}, generatedAt: new Date() },
                { id: '3', name: 'Jane', type: 'person' as const, details: {}, generatedAt: new Date() },
            ];

            useNameStore.getState().addGeneratedNames(names);

            const people = useNameStore.getState().getNamesByType('person');
            expect(people).toHaveLength(2);

            const places = useNameStore.getState().getNamesByType('place');
            expect(places).toHaveLength(1);
        });
    });

    describe('clearAll', () => {
        it('should reset entire store to initial state', () => {
            // Populate store
            useNameStore.getState().addGeneratedNames([
                { id: '1', name: 'John', type: 'person' as const, details: {}, generatedAt: new Date() },
            ]);
            useNameStore.getState().addToFavorites('1');
            useNameStore.getState().updatePreferences({ defaultCount: 20 });
            useNameStore.getState().saveParameters('people', { count: 5 });

            // Clear all
            useNameStore.getState().clearAll();

            const state = useNameStore.getState();
            expect(state.generatedNames).toHaveLength(0);
            expect(state.favorites).toHaveLength(0);
            expect(state.history).toHaveLength(0);
            expect(state.preferences.defaultCount).toBe(10);
            expect(Object.keys(state.recentParameters)).toHaveLength(0);
        });
    });
});

describe('Helper Functions', () => {
    describe('createPersonName', () => {
        it('should create a GeneratedName from PersonNameResult', () => {
            const personResult: PersonNameResult = {
                name: 'John Doe',
                firstName: 'John',
                lastName: 'Doe',
                culture: 'western',
                gender: 'male',
                method: 'markov_chain',
                origin: 'English',
                meaning: 'God is gracious',
                pronunciation: '/john/',
                period: 'modern',
            };

            const result = createPersonName(personResult);

            expect(result.name).toBe('John Doe');
            expect(result.type).toBe('person');
            expect(result.id).toBeTruthy();
            expect(result.details.firstName).toBe('John');
            expect(result.details.lastName).toBe('Doe');
            expect(result.details.culture).toBe('western');
            expect(result.generatedAt).toBeInstanceOf(Date);
        });
    });

    describe('createPlaceName', () => {
        it('should create a GeneratedName from place result', () => {
            const placeResult = { name: 'Silverdale', type: 'city', climate: 'temperate' };

            const result = createPlaceName(placeResult);

            expect(result.name).toBe('Silverdale');
            expect(result.type).toBe('place');
            expect(result.id).toBeTruthy();
            expect(result.details).toEqual(placeResult);
        });
    });

    describe('createEventName', () => {
        it('should create a GeneratedName from event result', () => {
            const eventResult = { name: 'The Great War', type: 'historical' };

            const result = createEventName(eventResult);

            expect(result.name).toBe('The Great War');
            expect(result.type).toBe('event');
            expect(result.id).toBeTruthy();
        });
    });

    describe('createTitleName', () => {
        it('should create a GeneratedName from title result', () => {
            const titleResult = { name: 'Lord of the Rings', genre: 'fantasy' };

            const result = createTitleName(titleResult);

            expect(result.name).toBe('Lord of the Rings');
            expect(result.type).toBe('title');
            expect(result.id).toBeTruthy();
        });
    });
});
