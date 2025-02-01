import { React } from 'react';

import { useEffect, useState } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

const VoituresList = () => {
    const [voitures, setVoitures] = useState([]);

    useEffect(() => {
        axios.get('http://localhost:8000/api/voitures')
            .then(response => setVoitures(response.data))
            .catch(error => console.error(error));
    }, []);

    return (
        <div className="list-container fade-in">
            <h2>Liste des Voitures</h2>
            {voitures.map((voiture: any) => (
                <div key={voiture.id} className="list-item">
                    <span>{voiture.model} - {voiture.kmh} km/h</span>
                </div>
            ))}
        </div>
    );
};

export default VoituresList;
