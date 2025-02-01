import React  from 'react';
import { BrowserRouter as Router, Routes, Route, Link } from 'react-router-dom';
import VoituresList from './components/VoituresList.tsx';
import AddCarForm from './components/AddCarForm.tsx';
import CalculateTimeForm from './components/CalculateTimeForm.tsx';
import  './App.css';


const App = () => {
    return (
      <Router>
      <div className="app-container">
          <nav className="fade-in">
              <ul>
                  <li><Link to="/">Liste des Voitures</Link></li>
                  <li><Link to="/add">Ajouter une Voiture</Link></li>
                  <li><Link to="/calculate">Calculer le Temps</Link></li>
              </ul>
          </nav>

          <div className="container">
              <Routes>
                  <Route path="/" element={<VoituresList />} />
                  <Route path="/add" element={<AddCarForm />} />
                  <Route path="/calculate" element={<CalculateTimeForm />} />
              </Routes>
          </div>
      </div>
  </Router>
    );
};

export default App;
