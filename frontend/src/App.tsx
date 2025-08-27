import React from 'react';
import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom';
import SharedLayout from './components/SharedLayout';
import PeopleGeneratorPage from './pages/PeopleGeneratorPage';
import PlacesGeneratorPage from './pages/PlacesGeneratorPage';
import EventsGeneratorPage from './pages/EventsGeneratorPage';
import TitlesGeneratorPage from './pages/TitlesGeneratorPage';
import BatchGeneratorPage from './pages/BatchGeneratorPage';

const App: React.FC = () => {
  return (
    <BrowserRouter>
      <SharedLayout>
        <Routes>
          <Route path="/" element={<Navigate to="/people" replace />} />
          <Route path="/people" element={<PeopleGeneratorPage />} />
          <Route path="/places" element={<PlacesGeneratorPage />} />
          <Route path="/events" element={<EventsGeneratorPage />} />
          <Route path="/titles" element={<TitlesGeneratorPage />} />
          <Route path="/batch" element={<BatchGeneratorPage />} />
          <Route path="*" element={<Navigate to="/people" replace />} />
        </Routes>
      </SharedLayout>
    </BrowserRouter>
  );
};

export default App;
