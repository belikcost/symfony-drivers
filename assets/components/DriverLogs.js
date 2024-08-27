import React, { useEffect, useState } from 'react';
import { Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper } from '@mui/material';

function DriverLogs() {
    const [logs, setLogs] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetch('/api/driver-logs')
            .then((response) => response.json())
            .then((data) => {
                setLogs(data);
                setLoading(false);
            });
    }, []);

    return (
        <TableContainer component={Paper} sx={{ mt: 3 }}>
            <Table>
                <TableHead>
                    <TableRow>
                        <TableCell>Водитель</TableCell>
                        <TableCell>Старая машина</TableCell>
                        <TableCell>Новая машина</TableCell>
                        <TableCell>Дата изменения</TableCell>
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
                        logs.map((log) => (
                            <TableRow key={log.id}>
                                <TableCell>{log.driver.name}</TableCell>
                                <TableCell>
                                    {log.oldCar ? `${log.oldCar.brand} ${log.oldCar.model}` : 'Нет'}
                                </TableCell>
                                <TableCell>
                                    {log.newCar ? `${log.newCar.brand} ${log.newCar.model}` : 'Нет'}
                                </TableCell>
                                <TableCell>{log.changedAt}</TableCell>
                            </TableRow>
                        ))
                    )}
                </TableBody>
            </Table>
        </TableContainer>
    );
}

export default DriverLogs;