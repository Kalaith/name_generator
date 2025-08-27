import React from 'react';
import { Link, useLocation } from 'react-router-dom';

interface SharedLayoutProps {
  children: React.ReactNode;
}

const SharedLayout: React.FC<SharedLayoutProps> = ({ children }) => {
  const location = useLocation();

  const tabs = [
    { label: 'People', value: 'people', path: '/people' },
    { label: 'Places', value: 'places', path: '/places' },
    { label: 'Events', value: 'events', path: '/events' },
    { label: 'Titles', value: 'titles', path: '/titles' },
    { label: 'Batch', value: 'batch', path: '/batch' },
  ];

  const getActiveTab = () => {
    const path = location.pathname;
    return tabs.find(tab => path === tab.path)?.value || 'people';
  };

  const activeTab = getActiveTab();

  return (
    <div className="min-h-screen bg-gradient-to-br from-slate-50 via-white to-blue-50 dark:from-gray-900 dark:via-gray-800 dark:to-indigo-900 text-gray-900 dark:text-gray-100">
      <div className="w-full">
        {/* Header */}
        <header className="relative overflow-hidden bg-white dark:bg-gray-900 shadow-lg">
          <div className="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 opacity-5"></div>
          <div className="relative px-6 py-8">
            <div className="max-w-6xl mx-auto text-center">
              <h1 className="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 tracking-tight">
                ✨ Name Generator
              </h1>
              <p className="text-gray-600 dark:text-gray-300 mt-2 text-lg">
                Generate unique names for people, places, events, and titles
              </p>
            </div>
          </div>
        </header>
        
        {/* Navigation */}
        <nav className="bg-white dark:bg-gray-900 shadow-sm border-b border-gray-200 dark:border-gray-700 sticky top-0 z-10">
          <div className="max-w-6xl mx-auto px-6 py-4">
            <div className="flex flex-wrap gap-2 justify-center">
              {tabs.map(tab => (
                <Link
                  key={tab.value}
                  to={tab.path}
                  className={`relative px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 ${
                    activeTab === tab.value 
                      ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg shadow-blue-500/25' 
                      : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white'
                  }`}
                >
                  {tab.label}
                  {activeTab === tab.value && (
                    <div className="absolute inset-0 rounded-xl bg-white/20 animate-pulse"></div>
                  )}
                </Link>
              ))}
            </div>
          </div>
        </nav>
        
        {/* Main Content */}
        <main className="max-w-6xl mx-auto px-6 py-8">
          {children}
        </main>
      </div>
    </div>
  );
};

export default SharedLayout;