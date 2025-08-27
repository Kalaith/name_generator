import React, { useState } from 'react';
import BatchForm from '../components/BatchForm';
import ResultsGrid from '../components/ResultsGrid';
import { fetchBatchResults } from '../utils/api';

const BatchGeneratorPage: React.FC = () => {
  const [batchResults, setBatchResults] = useState<Record<string, string[]>>({});
  const [batchLoading, setBatchLoading] = useState(false);

  const handleBatchGenerate = async (params: { count: number; types: string[] }) => {
    setBatchLoading(true);
    try {
      const results = await fetchBatchResults(params);
      setBatchResults(results);
    } catch (e) {
      setBatchResults({});
    } finally {
      setBatchLoading(false);
    }
  };

  return (
    <div className="space-y-6">
      <div className="bg-white dark:bg-gray-900 shadow-sm border-b border-gray-200 dark:border-gray-700 rounded-lg">
        <div className="px-6 py-4">
          <h2 className="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">
            Batch Generator
          </h2>
          <p className="text-gray-600 dark:text-gray-300 mt-1">
            Generate multiple types of names at once
          </p>
        </div>
      </div>
      
      <BatchForm onGenerate={handleBatchGenerate} loading={batchLoading} />
      
      <div className="space-y-6 mt-6">
        {['people', 'places', 'events', 'titles'].map(type => (
          batchResults[type] && (
            <div key={type}>
              <h3 className="text-lg font-bold mb-2 capitalize text-gray-900 dark:text-gray-100">
                {type}
              </h3>
              <ResultsGrid results={batchResults[type]} type={type as any} />
            </div>
          )
        ))}
      </div>
    </div>
  );
};

export default BatchGeneratorPage;