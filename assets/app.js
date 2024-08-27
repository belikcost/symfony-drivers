import React from 'react';
import { createRoot } from 'react-dom/client';
import { BrowserRouter as Router, Route, Routes, Link } from 'react-router-dom';
import { AppBar, Toolbar, Typography, Container, Button } from '@mui/material';
import DriverList from './components/DriverList';
import DriverForm from './components/DriverForm';
import CarForm from './components/CarForm';
import DriverLogs from './components/DriverLogs';

function App() {
    return (
        <Router>
            <AppBar position="static">
                <Toolbar>
                    <Typography variant="h6" component="div" sx={{ flexGrow: 1 }}>
                        DriveRRs App
                    </Typography>
                    <Button color="inherit" component={Link} to="/">Список водителей</Button>
                    <Button color="inherit" component={Link} to="/driver/new">Создать водителя</Button>
                    <Button color="inherit" component={Link} to="/car/new">Создать машину</Button>
                    <Button color="inherit" component={Link} to="/driver-logs">Логи</Button>
                </Toolbar>
            </AppBar>
            <Container>
                <Routes>
                    <Route path="/" element={<DriverList />} />
                    <Route path="/driver/new" element={<DriverForm />} />
                    <Route path="/driver/edit/:id" element={<DriverForm />} />
                    <Route path="/car/new" element={<CarForm />} />
                    <Route path="/driver-logs" element={<DriverLogs />} />
                </Routes>
            </Container>
        </Router>
    );
}

const rootElement = document.getElementById('root');
const root = createRoot(rootElement);
root.render(<App />);