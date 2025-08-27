import React, { useState } from 'react';
import EventsForm from '../components/EventsForm';
import ResultsGrid from '../components/ResultsGrid';
import { fetchEventNames } from '../utils/api';

const EventsGeneratorPage: React.FC = () => {
  const [eventsResults, setEventsResults] = useState<string[]>([]);
  const [eventsLoading, setEventsLoading] = useState(false);

  const handleEventsGenerate = async (params: { count: number; type: string; theme: string; tone: string; }) => {
    setEventsLoading(true);
    try {
      const results = await fetchEventNames(params);
      setEventsResults(results);
    } catch (e) {
      setEventsResults([]);
    } finally {
      setEventsLoading(false);
    }
  };

  return (
    <div className="space-y-6">
      <div className="bg-white dark:bg-gray-900 shadow-sm border-b border-gray-200 dark:border-gray-700 rounded-lg">
        <div className="px-6 py-4">
          <h2 className="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">
            Events Generator
          </h2>
          <p className="text-gray-600 dark:text-gray-300 mt-1">
            Generate names for events, festivals, and occasions
          </p>
        </div>
      </div>
      
      <EventsForm onGenerate={handleEventsGenerate} loading={eventsLoading} />
      <ResultsGrid results={eventsResults} type="events" />
    </div>
  );
};

export default EventsGeneratorPage;