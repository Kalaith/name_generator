import React, { useState, useEffect, useMemo } from 'react';
import FormSelectField from './FormSelectField';
import { fetchSelectOptions, fetchDialectOptions } from '../utils/api';
import type { Option, DialectOption } from '../types';

interface PeopleFormProps {
  onGenerate: (params: {
    count: number;
    gender: string;
    culture: string;
    method: string;
    type: string;
    period: string;
    dialect: string;
    excludeReal: boolean;
  }) => void;
  loading?: boolean;
}

const fields = ['gender', 'culture', 'method', 'type', 'period'] as const;
type Field = typeof fields[number];

const PeopleForm: React.FC<PeopleFormProps> = ({ onGenerate, loading }) => {
  const [count, setCount] = useState(5);
  const [gender, setGender] = useState('any');
  const [culture, setCulture] = useState('any');
  const [method, setMethod] = useState('markov_chain');
  const [type, setType] = useState('full_name');
  const [period, setPeriod] = useState('modern');
  const [dialect, setDialect] = useState('any');
  const [excludeReal, setExcludeReal] = useState(false);

  const [options, setOptions] = useState<Record<Field, Option[]>>({
    gender: [], culture: [], method: [], type: [], period: []
  });
  const [dialectOptions, setDialectOptions] = useState<DialectOption[]>([]);
  const [loadingOptions, setLoadingOptions] = useState(true);

  useEffect(() => {
    let isMounted = true;
    setLoadingOptions(true);

    // Fetch both regular options and dialect options
    Promise.all([
      ...fields.map(field => fetchSelectOptions(field)),
      fetchDialectOptions()
    ])
      .then(results => {
        if (!isMounted) return;
        setOptions({
          gender: results[0],
          culture: results[1],
          method: results[2],
          type: results[3],
          period: results[4],
        });
        setDialectOptions(results[5] as DialectOption[]);
        setLoadingOptions(false);
      })
      .catch(() => {
        if (isMounted) setLoadingOptions(false);
      });
    return () => { isMounted = false; };
  }, []);

  // Filter dialects based on selected culture
  const filteredDialects = useMemo(() => {
    if (!dialectOptions.length) return [];

    return dialectOptions.filter(d => {
      // Always show "Any / Default"
      if (d.value === 'any') return true;
      // Show dialects that match the selected culture or are universal
      if (d.cultures?.includes('all')) return true;
      if (culture === 'any') return true; // Show all dialects if culture is "any"
      return d.cultures?.includes(culture);
    });
  }, [dialectOptions, culture]);

  // Reset dialect when culture changes (if current dialect doesn't match)
  useEffect(() => {
    if (dialect !== 'any') {
      const currentDialect = dialectOptions.find(d => d.value === dialect);
      if (currentDialect && !currentDialect.cultures?.includes('all')) {
        if (!currentDialect.cultures?.includes(culture) && culture !== 'any') {
          setDialect('any');
        }
      }
    }
  }, [culture, dialect, dialectOptions]);

  // Check if phonetic method is selected (dialects only work with phonetic)
  const isPhoneticMethod = method === 'phonetic_pattern';

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    onGenerate({
      count,
      gender,
      culture,
      method,
      type,
      period,
      dialect: isPhoneticMethod ? dialect : 'any',
      excludeReal
    });
  };

  return (
    <div className="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
      <div className="bg-gradient-to-r from-blue-500 to-indigo-600 px-8 py-6">
        <h2 className="text-2xl font-bold text-white mb-2">👥 Generate People Names</h2>
        <p className="text-blue-100">Create unique, culturally-inspired names for your characters and stories</p>
      </div>

      <form onSubmit={handleSubmit} className="p-8 space-y-8">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div className="space-y-2">
            <label htmlFor="count" className="block text-base font-semibold text-gray-800 dark:text-gray-100">
              Count
            </label>
            <input
              id="count"
              type="number"
              min={1}
              max={20}
              value={count}
              onChange={e => setCount(Number(e.target.value))}
              className="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
              placeholder="1-20"
            />
            <p className="text-sm text-gray-500">Choose between 1 and 20 names</p>
          </div>

          <FormSelectField
            label="Gender"
            name="gender"
            value={gender}
            onChange={setGender}
            options={options.gender}
            className="space-y-2"
          />

          <FormSelectField
            label="Culture"
            name="culture"
            value={culture}
            onChange={setCulture}
            options={options.culture}
            className="space-y-2"
          />

          <FormSelectField
            label="Generation Method"
            name="method"
            value={method}
            onChange={setMethod}
            options={options.method}
            className="space-y-2"
          />

          {/* Regional Dialect - only shown when phonetic method is selected */}
          {isPhoneticMethod && (
            <div className="space-y-2">
              <label htmlFor="dialect" className="block text-base font-semibold text-gray-800 dark:text-gray-100">
                Regional Dialect
                <span className="ml-2 text-xs font-normal text-blue-500 bg-blue-50 dark:bg-blue-900/30 px-2 py-0.5 rounded-full">
                  Phonetic only
                </span>
              </label>
              <select
                id="dialect"
                name="dialect"
                value={dialect}
                onChange={e => setDialect(e.target.value)}
                className="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
              >
                {filteredDialects.map(opt => (
                  <option key={opt.value} value={opt.value}>
                    {opt.label}
                  </option>
                ))}
              </select>
              <p className="text-sm text-gray-500">
                {culture === 'any'
                  ? 'Select a culture to see regional dialects'
                  : `Regional variations for ${culture} names`}
              </p>
            </div>
          )}

          <FormSelectField
            label="Name Type"
            name="type"
            value={type}
            onChange={setType}
            options={options.type}
            className="space-y-2"
          />

          <FormSelectField
            label="Time Period"
            name="period"
            value={period}
            onChange={setPeriod}
            options={options.period}
            className="space-y-2"
          />
        </div>

        <div className="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
          <input
            type="checkbox"
            id="excludeReal"
            checked={excludeReal}
            onChange={e => setExcludeReal(e.target.checked)}
            className="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition-colors"
          />
          <div>
            <label htmlFor="excludeReal" className="text-base font-medium text-gray-800 dark:text-gray-100 cursor-pointer">
              Exclude Real Names
            </label>
            <p className="text-sm text-gray-500">Avoid using real-world names in results</p>
          </div>
        </div>

        <div className="flex justify-center pt-4">
          <button
            type="submit"
            className="group relative px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg transform transition-all duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
            disabled={loading || loadingOptions}
          >
            <span className="flex items-center gap-2">
              {loading ? (
                <>
                  <svg className="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" className="opacity-25"></circle>
                    <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" className="opacity-75"></path>
                  </svg>
                  Generating...
                </>
              ) : loadingOptions ? (
                <>
                  <svg className="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" className="opacity-25"></circle>
                    <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" className="opacity-75"></path>
                  </svg>
                  Loading Options...
                </>
              ) : (
                <>
                  <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 10V3L4 14h7v7l9-11h-7z" />
                  </svg>
                  Generate Names
                </>
              )}
            </span>
          </button>
        </div>
      </form>
    </div>
  );
};

export default PeopleForm;