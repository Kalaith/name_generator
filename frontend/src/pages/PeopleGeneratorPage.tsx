import React, { useState } from 'react';
import PeopleForm from '../components/PeopleForm';
import ResultsGrid from '../components/ResultsGrid';
import { fetchPeopleNames } from '../utils/api';
import type { PersonNameResult } from '../types';
import type { PeopleParams } from '../utils/api';

const PeopleGeneratorPage: React.FC = () => {
  const [peopleResults, setPeopleResults] = useState<PersonNameResult[]>([]);
  const [loading, setLoading] = useState(false);

  const handlePeopleGenerate = async (params: PeopleParams) => {
    setLoading(true);
    try {
      const results = await fetchPeopleNames(params);
      setPeopleResults(results);
    } catch (e) {
      setPeopleResults([]);
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="space-y-6">
      <div className="bg-white dark:bg-gray-900 shadow-sm border-b border-gray-200 dark:border-gray-700 rounded-lg">
        <div className="px-6 py-4">
          <h2 className="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">
            People Names Generator
          </h2>
          <p className="text-gray-600 dark:text-gray-300 mt-1">
            Generate unique names for characters and NPCs
          </p>
        </div>
      </div>
      
      <PeopleForm onGenerate={handlePeopleGenerate} loading={loading} />
      <ResultsGrid results={peopleResults} type="people" />
    </div>
  );
};

export default PeopleGeneratorPage;