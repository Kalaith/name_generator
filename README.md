# Name Generator

A comprehensive web application for generating various types of names including people, places, events, titles, and batch generation. Built with a modern React frontend and PHP backend, featuring multiple generation algorithms and cultural patterns.

## 🚀 Features

### Name Generation Types
- **People Names**: Generate first and last names with cultural and gender options
- **Place Names**: Create location names with different styles (fantasy, realistic, historical)
- **Event Names**: Generate event and occasion names
- **Titles**: Create titles, epithets, and honorifics
- **Batch Generation**: Generate multiple names at once

### Generation Methods
- **Markov Chain**: Statistical name generation based on existing name patterns
- **Syllable-Based**: Construct names from syllable components
- **Phonetic Pattern**: Generate names following phonetic rules
- **Historical Pattern**: Create period-appropriate names

### Cultural Support
- Western names
- Nordic names
- Fantasy names
- Historical variants (Ancient, Medieval, Victorian)

## 🏗️ Architecture

### Frontend
- **React 19** with TypeScript
- **Vite** for build tooling
- **Tailwind CSS** for styling
- **Zustand** for state management (planned)
- **React Router** for navigation
- **ESLint** for code quality

### Backend
- **PHP 8.1+** (currently plain PHP, migration to Slim Framework planned)
- **Composer** for dependency management (planned)
- Multiple generation algorithms
- RESTful API endpoints

## 📁 Project Structure

```
name_generator/
├── backend/
│   ├── generate_batch.php
│   ├── generate_event.php
│   ├── generate_name.php
│   ├── generate_place.php
│   ├── generate_title.php
│   ├── generators.php
│   └── options.php
├── frontend/
│   ├── public/
│   ├── src/
│   │   ├── components/
│   │   │   ├── BatchForm.tsx
│   │   │   ├── EventsForm.tsx
│   │   │   ├── PeopleForm.tsx
│   │   │   ├── PlacesForm.tsx
│   │   │   ├── TitlesForm.tsx
│   │   │   ├── ResultsGrid.tsx
│   │   │   ├── SharedLayout.tsx
│   │   │   ├── TabPanel.tsx
│   │   │   └── FormSelectField.tsx
│   │   ├── pages/
│   │   │   ├── BatchGeneratorPage.tsx
│   │   │   ├── EventsGeneratorPage.tsx
│   │   │   ├── PeopleGeneratorPage.tsx
│   │   │   ├── PlacesGeneratorPage.tsx
│   │   │   └── TitlesGeneratorPage.tsx
│   │   ├── stores/
│   │   │   └── nameStore.ts
│   │   ├── types/
│   │   │   └── index.ts
│   │   ├── utils/
│   │   │   ├── api.ts
│   │   │   └── mockData.ts
│   │   ├── App.tsx
│   │   ├── index.css
│   │   └── main.tsx
│   ├── package.json
│   ├── tsconfig.json
│   ├── vite.config.ts
│   └── README.md
├── COMPLIANCE_REPORT.md
└── publish.ps1
```

## 🛠️ Installation & Setup

### Prerequisites
- Node.js 18+ and npm
- PHP 8.1+ with web server
- Composer (for future backend migration)

### Frontend Setup
```bash
cd frontend
npm install
npm run dev
```

### Backend Setup
```bash
cd backend
# Start PHP development server
php -S localhost:8000
```

## 🚀 Usage

1. **Start the backend server** on port 8000
2. **Start the frontend development server** on port 5173 (default Vite port)
3. **Open your browser** and navigate to the frontend URL
4. **Select a generation type** from the tabs (People, Places, Events, Titles, Batch)
5. **Configure options** such as culture, gender, method, etc.
6. **Generate names** and view results in the grid
7. **Copy, favorite, or export** generated names

## 🔧 Development

### Frontend Scripts
```bash
npm run dev          # Start development server
npm run build        # Build for production
npm run preview      # Preview production build
npm run lint         # Run ESLint
npm run type-check   # Run TypeScript type checking
```

### Backend Development
Currently using plain PHP files. Future migration planned to Slim Framework with:
- Actions pattern for business logic
- Repository pattern for data access
- PSR-12 coding standards
- Composer dependency management

## 📊 API Endpoints

- `POST /generate_name.php` - Generate people names
- `POST /generate_place.php` - Generate place names
- `POST /generate_event.php` - Generate event names
- `POST /generate_title.php` - Generate titles
- `POST /generate_batch.php` - Generate batch names
- `GET /options.php` - Get available options

## 🎯 Generation Algorithms

### Markov Chain Generation
Uses statistical analysis of existing names to generate new ones by predicting the next character based on previous characters.

### Syllable-Based Generation
Constructs names by combining predefined syllable components (prefixes, middles, suffixes).

### Phonetic Pattern Generation
Creates names following specific phonetic patterns (CVC, CVCCV, etc.) using vowels and consonants.

### Historical Pattern Generation
Applies historical naming conventions and modifiers for different time periods.

## 🔄 State Management

Currently implemented with React local state. Migration planned to Zustand with:
- Persistent storage for generated names
- User preferences
- Favorites and history
- Cross-session data preservation

## 📈 Compliance Status

**Current Compliance: 55%** ⚠️
- ✅ Frontend Technology Stack (React 19, TypeScript, Vite)
- ✅ Project Structure and Configuration
- ⚠️ Missing State Management (Zustand implementation needed)
- ❌ Backend Architecture (Slim Framework migration required)

See `COMPLIANCE_REPORT.md` for detailed compliance information and roadmap.

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🙏 Acknowledgments

- Built with modern web technologies
- Features multiple name generation algorithms
- Designed for flexibility and extensibility
- Comprehensive cultural and historical support</content>
<parameter name="filePath">h:\WebHatchery\apps\name_generator\README.md
