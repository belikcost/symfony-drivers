import React, { useState, useEffect } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { TextField, Button, MenuItem, FormControl, InputLabel, Select, Box } from '@mui/material';

function DriverForm() {
    const { id } = useParams();
    const navigate = useNavigate();
    const [name, setName] = useState('');
    const [birthdate, setBirthdate] = useState('');
    const [carId, setCarId] = useState('');
    const [cars, setCars] = useState([]);
    const [nameError, setNameError] = useState(false);
    const [birthdateError, setBirthdateError] = useState(false);
    const isEdit = !!id;

    useEffect(() => {
        fetch('/api/cars')
            .then((response) => response.json())
            .then((data) => setCars(data));

        if (isEdit) {
            fetch(`/api/drivers/${id}`)
                .then((response) => response.json())
                .then((data) => {
                    setName(data.name);
                    setBirthdate(data.birthdate);
                    setCarId(data.car ? data.car.id : '');
                });
        }
    }, [id, isEdit]);

    const handleSubmit = (event) => {
        event.preventDefault();

        // Валидация полей
        const isNameValid = name.trim() !== '';
        const isBirthdateValid = birthdate.trim() !== '';

        setNameError(!isNameValid);
        setBirthdateError(!isBirthdateValid);

        if (!isNameValid || !isBirthdateValid) {
            return;
        }

        const driver = { name, birthdate, car: carId };

        const requestOptions = {
            method: isEdit ? 'PUT' : 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(driver),
        };

        const url = isEdit ? `/api/drivers/${id}` : '/api/drivers';
        fetch(url, requestOptions)
            .then(() => navigate('/'));
    };

    return (
        <Box component="form" onSubmit={handleSubmit} sx={{ mt: 3 }}>
            <TextField
                fullWidth
                label="Имя"
                value={name}
                onChange={(e) => setName(e.target.value)}
                error={nameError}
                helperText={nameError ? "Имя обязательно" : ""}
                margin="normal"
                required
            />
            <TextField
                fullWidth
                label="Дата рождения"
                type="date"
                value={birthdate}
                onChange={(e) => setBirthdate(e.target.value)}
                error={birthdateError}
                helperText={birthdateError ? "Дата рождения обязательна" : ""}
                InputLabelProps={{
                    shrink: true,
                }}
                margin="normal"
                required
            />
            <FormControl fullWidth margin="normal">
                <InputLabel id="car-select-label">Машина</InputLabel>
                <Select
                    variant="standard"
                    labelId="car-select-label"
                    value={carId}
                    onChange={(e) => setCarId(e.target.value)}
                    label="Машина"
                    required
                >
                    <MenuItem value="">
                        <em>Выберите машину</em>
                    </MenuItem>
                    {cars.map(car => (
                        <MenuItem key={car.id} value={car.id}>
                            {car.brand} {car.model}
                        </MenuItem>
                    ))}
                </Select>
            </FormControl>
            <Button type="submit" variant="contained" color="primary">
                {isEdit ? 'Обновить' : 'Создать'}
            </Button>
        </Box>
    );
}

export default DriverForm;