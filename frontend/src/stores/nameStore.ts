import { create } from 'zustand';
import { persist } from 'zustand/middleware';
import type { PersonNameResult, PeopleParams } from '../types';

export interface GeneratedName {
  id: string;
  name: string;
  type: 'person' | 'place' | 'event' | 'title';
  details: Record<string, unknown>; // Specific to each type
  generatedAt: Date;
}

export interface UserPreferences {
  favoriteTypes: string[];
  defaultCount: number;
  preferredCultures: string[];
  nameLength: 'short' | 'medium' | 'long';
  allowCompound: boolean;
  includeOrigin: boolean;
  includeMeaning: boolean;
  includePronunciation: boolean;
}

interface NameState {
  generatedNames: GeneratedName[];
  favorites: string[];
  history: GeneratedName[];
  preferences: UserPreferences;
  recentParameters: {
    people?: PeopleParams;
    places?: Record<string, unknown>;
    events?: Record<string, unknown>;
    titles?: Record<string, unknown>;
  };
}

interface NameActions {
  // Name generation results
  addGeneratedNames: (names: GeneratedName[]) => void;
  clearGeneratedNames: () => void;

  // Favorites
  addToFavorites: (nameId: string) => void;
  removeFromFavorites: (nameId: string) => void;
  clearFavorites: () => void;

  // History
  clearHistory: () => void;

  // Preferences
  updatePreferences: (preferences: Partial<UserPreferences>) => void;
  resetPreferences: () => void;

  // Parameters
  saveParameters: (type: string, params: PeopleParams | Record<string, unknown>) => void;
  getLastParameters: (type: string) => PeopleParams | Record<string, unknown> | null;

  // Utility
  findNameById: (id: string) => GeneratedName | undefined;
  getNamesByType: (type: string) => GeneratedName[];
  clearAll: () => void;
}

type NameStore = NameState & NameActions;

const generateId = () => crypto.randomUUID();

const defaultPreferences: UserPreferences = {
  favoriteTypes: ['person'],
  defaultCount: 10,
  preferredCultures: ['any'],
  nameLength: 'medium',
  allowCompound: true,
  includeOrigin: true,
  includeMeaning: true,
  includePronunciation: false,
};

export const useNameStore = create<NameStore>()(
  persist(
    (set, get) => ({
      // State
      generatedNames: [],
      favorites: [],
      history: [],
      preferences: { ...defaultPreferences },
      recentParameters: {},

      // Generated Names
      addGeneratedNames: (names) =>
        set((state) => {
          const newNames = names.map(name => ({ ...name, id: name.id || generateId() }));
          return {
            generatedNames: newNames,
            history: [...newNames, ...state.history].slice(0, 100), // Keep last 100
          };
        }),

      clearGeneratedNames: () => set({ generatedNames: [] }),

      // Favorites
      addToFavorites: (nameId) =>
        set((state) => {
          if (state.favorites.includes(nameId)) return state;
          return {
            favorites: [...state.favorites, nameId],
          };
        }),

      removeFromFavorites: (nameId) =>
        set((state) => ({
          favorites: state.favorites.filter(id => id !== nameId),
        })),

      clearFavorites: () => set({ favorites: [] }),

      // History
      clearHistory: () => set({ history: [] }),

      // Preferences
      updatePreferences: (newPreferences) =>
        set((state) => ({
          preferences: { ...state.preferences, ...newPreferences },
        })),

      resetPreferences: () => set({ preferences: { ...defaultPreferences } }),

      // Parameters
      saveParameters: (type, params) =>
        set((state) => ({
          recentParameters: {
            ...state.recentParameters,
            [type]: params,
          },
        })),

      getLastParameters: (type) => {
        const state = get();
        const key = type as keyof NameState['recentParameters'];
        return state.recentParameters[key] || null;
      },

      // Utility
      findNameById: (id) => {
        const state = get();
        return state.history.find(name => name.id === id) ||
          state.generatedNames.find(name => name.id === id);
      },

      getNamesByType: (type) => {
        const state = get();
        return state.history.filter(name => name.type === type);
      },

      clearAll: () =>
        set({
          generatedNames: [],
          favorites: [],
          history: [],
          preferences: { ...defaultPreferences },
          recentParameters: {},
        }),
    }),
    {
      name: 'name-generator-storage',
      partialize: (state) => ({
        favorites: state.favorites,
        history: state.history,
        preferences: state.preferences,
        recentParameters: state.recentParameters,
      }),
    }
  )
);

// Helper functions for converting API results to GeneratedName format
export const createPersonName = (result: PersonNameResult): GeneratedName => ({
  id: generateId(),
  name: result.name,
  type: 'person',
  details: {
    firstName: result.firstName,
    lastName: result.lastName,
    culture: result.culture,
    gender: result.gender,
    method: result.method,
    origin: result.origin,
    meaning: result.meaning,
    pronunciation: result.pronunciation,
    period: result.period,
  },
  generatedAt: new Date(),
});

export const createPlaceName = (result: Record<string, unknown>): GeneratedName => ({
  id: generateId(),
  name: result.name as string,
  type: 'place',
  details: result,
  generatedAt: new Date(),
});

export const createEventName = (result: Record<string, unknown>): GeneratedName => ({
  id: generateId(),
  name: result.name as string,
  type: 'event',
  details: result,
  generatedAt: new Date(),
});

export const createTitleName = (result: Record<string, unknown>): GeneratedName => ({
  id: generateId(),
  name: result.name as string,
  type: 'title',
  details: result,
  generatedAt: new Date(),
});