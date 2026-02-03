import { describe, it, expect } from 'vitest';
import { render, screen } from '@testing-library/react';
import TabPanel from './TabPanel';

describe('TabPanel', () => {
    it('should render children when name matches active', () => {
        render(
            <TabPanel name="tab1" active="tab1">
                <div data-testid="content">Tab Content</div>
            </TabPanel>
        );

        expect(screen.getByTestId('content')).toBeInTheDocument();
        expect(screen.getByText('Tab Content')).toBeInTheDocument();
    });

    it('should return null when name does not match active', () => {
        const { container } = render(
            <TabPanel name="tab1" active="tab2">
                <div data-testid="content">Tab Content</div>
            </TabPanel>
        );

        expect(container.firstChild).toBeNull();
        expect(screen.queryByTestId('content')).not.toBeInTheDocument();
    });

    it('should render complex children when active', () => {
        render(
            <TabPanel name="complex" active="complex">
                <div>
                    <h1>Title</h1>
                    <p>Paragraph</p>
                    <button>Button</button>
                </div>
            </TabPanel>
        );

        expect(screen.getByText('Title')).toBeInTheDocument();
        expect(screen.getByText('Paragraph')).toBeInTheDocument();
        expect(screen.getByText('Button')).toBeInTheDocument();
    });

    it('should have animation classes when rendered', () => {
        const { container } = render(
            <TabPanel name="animated" active="animated">
                <div>Content</div>
            </TabPanel>
        );

        const wrapper = container.firstChild as HTMLElement;
        expect(wrapper).toHaveClass('animate-in');
        expect(wrapper).toHaveClass('fade-in-0');
    });

    it('should handle empty name correctly', () => {
        const { container } = render(
            <TabPanel name="" active="">
                <div>Content</div>
            </TabPanel>
        );

        expect(container.firstChild).not.toBeNull();
        expect(screen.getByText('Content')).toBeInTheDocument();
    });

    it('should be case sensitive', () => {
        const { container } = render(
            <TabPanel name="Tab1" active="tab1">
                <div>Content</div>
            </TabPanel>
        );

        expect(container.firstChild).toBeNull();
    });
});
