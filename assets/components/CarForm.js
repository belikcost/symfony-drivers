import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { TextField, Button, Box } from '@mui/material';

function CarForm() {
    const navigate = useNavigate();
    const [licensePlate, setLicensePlate] = useState('');
    const [brand, setBrand] = useState('');
    const [model, setModel] = useState('');
    const [licensePlateError, setLicensePlateError] = useState(false);
    const [brandError, setBrandError] = useState(false);
    const [modelError, setModelError] = useState(false);

    const handleSubmit = (event) => {
        event.preventDefault();

        const isLicensePlateValid = licensePlate.trim() !== '';
        const isBrandValid = brand.trim() !== '';
        const isModelValid = model.trim() !== '';

        setLicensePlateError(!isLicensePlateValid);
        setBrandError(!isBrandValid);
        setModelError(!isModelValid);

        if (!isLicensePlateValid || !isBrandValid || !isModelValid) {
            return;
        }

        const car = { licensePlate, brand, model };

        fetch('/api/cars', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(car),
        }).then(() => navigate('/'));
    };

    return (
        <Box component="form" onSubmit={handleSubmit} sx={{ mt: 3 }}>
            <TextField
                fullWidth
                label="Номер машины"
                value={licensePlate}
                onChange={(e) => setLicensePlate(e.target.value)}
                error={licensePlateError}
                helperText={licensePlateError ? "Номер машины обязателен" : ""}
                margin="normal"
                required
            />
            <TextField
                fullWidth
                label="Марка"
                value={brand}
                onChange={(e) => setBrand(e.target.value)}
                error={brandError}
                helperText={brandError ? "Марка обязательна" : ""}
                margin="normal"
                required
            />
            <TextField
                fullWidth
                label="Модель"
                value={model}
                onChange={(e) => setModel(e.target.value)}
                error={modelError}
                helperText={modelError ? "Модель обязательна" : ""}
                margin="normal"
                required
            />
            <Button type="submit" variant="contained" color="primary">
                Создать
            </Button>
        </Box>
    );
}

export default CarForm;