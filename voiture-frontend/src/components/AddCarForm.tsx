import { React } from 'react';
import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';

const AddCarForm = () => {
    const [model, setModel] = useState('');
    const [kmh, setKmh] = useState('');
    const navigate = useNavigate();

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        try {
            await axios.post('http://localhost:8000/api/voitures', { model, kmh: parseInt(kmh, 10) });
            navigate('/'); 
        } catch (error) {
            console.error(error);
        }
    };

    return (
        <form onSubmit={handleSubmit} className="fade-in">
        <h2>Ajouter une Voiture</h2>
        <input type="text" placeholder="Modèle" value={model} onChange={e => setModel(e.target.value)} required />
        <input type="number" placeholder="Vitesse (km/h)" value={kmh} onChange={e => setKmh(e.target.value)} required />
        <button type="submit">Ajouter</button>
    </form>
    );
};

export default AddCarForm;
