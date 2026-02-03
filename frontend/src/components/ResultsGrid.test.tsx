import { describe, it, expect } from 'vitest';
import { render, screen } from '@testing-library/react';
import ResultsGrid from './ResultsGrid';
import type { PersonNameResult } from '../types';

describe('ResultsGrid', () => {
    describe('Empty state', () => {
        it('should show empty state when results is empty array', () => {
            render(<ResultsGrid results={[]} type="people" />);

            expect(screen.getByText('No results yet')).toBeInTheDocument();
            expect(screen.getByText('Click Generate to see your results here')).toBeInTheDocument();
        });

        it('should show empty state when results is undefined via empty array', () => {
            render(<ResultsGrid results={[]} type="places" />);

            expect(screen.getByText('No results yet')).toBeInTheDocument();
        });
    });

    describe('People results', () => {
        const mockPeopleResults: PersonNameResult[] = [
            {
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
            },
            {
                name: 'Jane Smith',
                firstName: 'Jane',
                lastName: 'Smith',
                culture: 'western',
                gender: 'female',
                method: 'markov_chain',
                origin: 'English',
                meaning: 'Noble',
                pronunciation: '/jane/',
                period: 'modern',
            },
        ];

        it('should render people results with names', () => {
            render(<ResultsGrid results={mockPeopleResults} type="people" />);

            expect(screen.getByText('John Doe')).toBeInTheDocument();
            expect(screen.getByText('Jane Smith')).toBeInTheDocument();
        });

        it('should show result count badge', () => {
            render(<ResultsGrid results={mockPeopleResults} type="people" />);

            expect(screen.getByText('2 results')).toBeInTheDocument();
        });

        it('should show singular result text for single item', () => {
            render(<ResultsGrid results={[mockPeopleResults[0]]} type="people" />);

            expect(screen.getByText('1 result')).toBeInTheDocument();
        });

        it('should display first letter avatar', () => {
            render(<ResultsGrid results={mockPeopleResults} type="people" />);

            expect(screen.getByText('J')).toBeInTheDocument();
        });

        it('should handle missing name by combining firstName and lastName', () => {
            const resultNoName: PersonNameResult = {
                name: '',
                firstName: 'Bob',
                lastName: 'Wilson',
                culture: 'western',
                gender: 'male',
                method: 'markov_chain',
                origin: '',
                meaning: '',
                pronunciation: '',
                period: 'modern',
            };

            render(<ResultsGrid results={[resultNoName]} type="people" />);

            expect(screen.getByText('Bob Wilson')).toBeInTheDocument();
        });

        it('should show people header with icon', () => {
            render(<ResultsGrid results={mockPeopleResults} type="people" />);

            expect(screen.getByText('Generated people')).toBeInTheDocument();
            // Icon appears in header
            expect(screen.getAllByText('👤').length).toBeGreaterThanOrEqual(1);
        });
    });

    describe('Places results', () => {
        const mockPlaceResults = ['Silverdale', 'Oakwood Manor', 'Crystal Lake'];

        it('should render place results as strings', () => {
            render(<ResultsGrid results={mockPlaceResults} type="places" />);

            expect(screen.getByText('Silverdale')).toBeInTheDocument();
            expect(screen.getByText('Oakwood Manor')).toBeInTheDocument();
            expect(screen.getByText('Crystal Lake')).toBeInTheDocument();
        });

        it('should show places header with icon', () => {
            render(<ResultsGrid results={mockPlaceResults} type="places" />);

            expect(screen.getByText('Generated places')).toBeInTheDocument();
            // Icon appears in header and each result card
            expect(screen.getAllByText('🏰').length).toBeGreaterThanOrEqual(1);
        });

        it('should show result count', () => {
            render(<ResultsGrid results={mockPlaceResults} type="places" />);

            expect(screen.getByText('3 results')).toBeInTheDocument();
        });
    });

    describe('Events results', () => {
        const mockEventResults = ['The Great War', 'Festival of Lights'];

        it('should render event results as strings', () => {
            render(<ResultsGrid results={mockEventResults} type="events" />);

            expect(screen.getByText('The Great War')).toBeInTheDocument();
            expect(screen.getByText('Festival of Lights')).toBeInTheDocument();
        });

        it('should show events header with icon', () => {
            render(<ResultsGrid results={mockEventResults} type="events" />);

            expect(screen.getByText('Generated events')).toBeInTheDocument();
            // Icon appears in header and each result card
            expect(screen.getAllByText('⚡').length).toBeGreaterThanOrEqual(1);
        });
    });

    describe('Titles results', () => {
        const mockTitleResults = ['Lord of the Rings', 'The Crown Prince'];

        it('should render title results as strings', () => {
            render(<ResultsGrid results={mockTitleResults} type="titles" />);

            expect(screen.getByText('Lord of the Rings')).toBeInTheDocument();
            expect(screen.getByText('The Crown Prince')).toBeInTheDocument();
        });

        it('should show titles header with icon', () => {
            render(<ResultsGrid results={mockTitleResults} type="titles" />);

            expect(screen.getByText('Generated titles')).toBeInTheDocument();
            // Icon appears in header and each result card
            expect(screen.getAllByText('👑').length).toBeGreaterThanOrEqual(1);
        });
    });
});
