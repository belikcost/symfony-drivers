import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper, Button } from '@mui/material';

function DriverList() {
    const [drivers, setDrivers] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetch('/api/drivers')
            .then((response) => response.json())
            .then((data) => {
                setDrivers(data);
                setLoading(false);
            });
    }, []);

    return (
        <TableContainer component={Paper} sx={{ mt: 3 }}>
            <Table>
                <TableHead>
                    <TableRow>
                        <TableCell>Имя</TableCell>
                        <TableCell>Дата рождения</TableCell>
                        <TableCell>Машина</TableCell>
                        <TableCell align="right">Действия</TableCell>
                    </TableRow>
                </TableHead>
                <TableBody>
                    {loading ? (
                        <TableRow>
                            <TableCell colSpan={4} align="center">
                                Загрузка...
                            </TableCell>
                        </TableRow>
                    ) : (
                        drivers.map((driver) => (
                            <TableRow key={driver.id}>
                                <TableCell>{driver.name}</TableCell>
                                <TableCell>{driver.birthdate}</TableCell>
                                <TableCell>
                                    {driver.car ? `${driver.car.brand} ${driver.car.model} | ${driver.car.licensePlate}` : 'Нет машины'}
                                </TableCell>
                                <TableCell align="right">
                                    <Button
                                        variant="contained"
                                        component={Link}
                                        to={`/driver/edit/${driver.id}`}
                                        sx={{ mr: 1 }}
                                    >
                                        Редактировать
                                    </Button>
                                </TableCell>
                            </TableRow>
                        ))
                    )}
                </TableBody>
            </Table>
        </TableContainer>
    );
}

export default DriverList;