import React, { useState } from 'react';
import PlacesForm from '../components/PlacesForm';
import ResultsGrid from '../components/ResultsGrid';
import { fetchPlaceNames } from '../utils/api';
import type { PlaceParams } from '../utils/api';

const PlacesGeneratorPage: React.FC = () => {
  const [placesResults, setPlacesResults] = useState<string[]>([]);
  const [placesLoading, setPlacesLoading] = useState(false);

  const handlePlacesGenerate = async (params: PlaceParams) => {
    setPlacesLoading(true);
    try {
      const results = await fetchPlaceNames(params);
      setPlacesResults(results);
    } catch {
      setPlacesResults([]);
    } finally {
      setPlacesLoading(false);
    }
  };

  return (
    <div className="space-y-6">
      <div className="bg-white dark:bg-gray-900 shadow-sm border-b border-gray-200 dark:border-gray-700 rounded-lg">
        <div className="px-6 py-4">
          <h2 className="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">
            Places Generator
          </h2>
          <p className="text-gray-600 dark:text-gray-300 mt-1">
            Generate names for cities, towns, and locations
          </p>
        </div>
      </div>

      <PlacesForm onGenerate={handlePlacesGenerate} loading={placesLoading} />
      <ResultsGrid results={placesResults} type="places" />
    </div>
  );
};

export default PlacesGeneratorPage;