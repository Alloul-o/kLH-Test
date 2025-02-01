import { React } from 'react';
import { useState } from 'react';
import axios from 'axios';

const CalculateTimeForm = () => {
    const [distance, setDistance] = useState('');
    const [model, setModel] = useState('');
    const [time, setTime] = useState<number | null>(null);

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        try {
            const response = await axios.post('http://localhost:8000/api/voitures/calculate-time', { distance: parseInt(distance, 10), model });
            setTime(response.data.time_hours);
        } catch (error) {
            console.error(error);
        }
    };

    return (
        <form onSubmit={handleSubmit} className="fade-in">
            <h2>Calculer le Temps</h2>
            <input type="number" placeholder="Distance (km)" value={distance} onChange={e => setDistance(e.target.value)} required />
            <input type="text" placeholder="Modèle" value={model} onChange={e => setModel(e.target.value)} required />
            <button type="submit">Calculer</button>
            {time !== null && <p>Temps estimé : {time} heures</p>}
        </form>
    );
};

export default CalculateTimeForm;
