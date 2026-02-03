import { describe, it, expect, vi } from 'vitest';
import { render, screen, fireEvent } from '@testing-library/react';
import FormSelectField from './FormSelectField';
import type { Option } from '../types';

describe('FormSelectField', () => {
    const defaultOptions: Option[] = [
        { value: 'option1', label: 'Option 1' },
        { value: 'option2', label: 'Option 2' },
        { value: 'option3', label: 'Option 3' },
    ];

    it('should render label correctly', () => {
        render(
            <FormSelectField
                label="Test Label"
                name="test"
                value="option1"
                onChange={() => { }}
                options={defaultOptions}
            />
        );

        expect(screen.getByText('Test Label')).toBeInTheDocument();
    });

    it('should render all options', () => {
        render(
            <FormSelectField
                label="Test"
                name="test"
                value="option1"
                onChange={() => { }}
                options={defaultOptions}
            />
        );

        expect(screen.getByRole('combobox')).toBeInTheDocument();
        expect(screen.getByText('Option 1')).toBeInTheDocument();
        expect(screen.getByText('Option 2')).toBeInTheDocument();
        expect(screen.getByText('Option 3')).toBeInTheDocument();
    });

    it('should have correct initial value', () => {
        render(
            <FormSelectField
                label="Test"
                name="test"
                value="option2"
                onChange={() => { }}
                options={defaultOptions}
            />
        );

        const select = screen.getByRole('combobox') as HTMLSelectElement;
        expect(select.value).toBe('option2');
    });

    it('should call onChange when selection changes', () => {
        const handleChange = vi.fn();

        render(
            <FormSelectField
                label="Test"
                name="test"
                value="option1"
                onChange={handleChange}
                options={defaultOptions}
            />
        );

        const select = screen.getByRole('combobox');
        fireEvent.change(select, { target: { value: 'option3' } });

        expect(handleChange).toHaveBeenCalledWith('option3');
    });

    it('should apply custom className', () => {
        const { container } = render(
            <FormSelectField
                label="Test"
                name="test"
                value="option1"
                onChange={() => { }}
                options={defaultOptions}
                className="custom-class"
            />
        );

        expect(container.firstChild).toHaveClass('custom-class');
    });

    it('should set name and id attributes correctly', () => {
        render(
            <FormSelectField
                label="Test"
                name="myField"
                value="option1"
                onChange={() => { }}
                options={defaultOptions}
            />
        );

        const select = screen.getByRole('combobox');
        expect(select).toHaveAttribute('name', 'myField');
        expect(select).toHaveAttribute('id', 'myField');
    });

    it('should associate label with select via htmlFor', () => {
        render(
            <FormSelectField
                label="Test Label"
                name="testName"
                value="option1"
                onChange={() => { }}
                options={defaultOptions}
            />
        );

        const label = screen.getByText('Test Label');
        expect(label).toHaveAttribute('for', 'testName');
    });

    it('should render empty when no options provided', () => {
        render(
            <FormSelectField
                label="Test"
                name="test"
                value=""
                onChange={() => { }}
                options={[]}
            />
        );

        const select = screen.getByRole('combobox');
        expect(select.children).toHaveLength(0);
    });
});
