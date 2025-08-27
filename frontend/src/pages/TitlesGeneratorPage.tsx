import React, { useState } from 'react';
import TitlesForm from '../components/TitlesForm';
import ResultsGrid from '../components/ResultsGrid';
import { fetchTitleNames } from '../utils/api';
import type { TitleParams } from '../utils/api';

const TitlesGeneratorPage: React.FC = () => {
  const [titlesResults, setTitlesResults] = useState<string[]>([]);
  const [titlesLoading, setTitlesLoading] = useState(false);

  const handleTitlesGenerate = async (params: TitleParams) => {
    setTitlesLoading(true);
    try {
      const results = await fetchTitleNames(params);
      setTitlesResults(results);
    } catch (e) {
      setTitlesResults([]);
    } finally {
      setTitlesLoading(false);
    }
  };

  return (
    <div className="space-y-6">
      <div className="bg-white dark:bg-gray-900 shadow-sm border-b border-gray-200 dark:border-gray-700 rounded-lg">
        <div className="px-6 py-4">
          <h2 className="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">
            Titles Generator
          </h2>
          <p className="text-gray-600 dark:text-gray-300 mt-1">
            Generate titles, ranks, and honorifics
          </p>
        </div>
      </div>
      
      <TitlesForm onGenerate={handleTitlesGenerate} loading={titlesLoading} />
      <ResultsGrid results={titlesResults} type="titles" />
    </div>
  );
};

export default TitlesGeneratorPage;