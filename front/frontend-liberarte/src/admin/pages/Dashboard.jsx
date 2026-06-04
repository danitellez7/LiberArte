import { useEffect, useState } from "react";
import axios from "axios";

export default function Dashboard() {

    const [stats, setStats] = useState({
        empleados: 0,
        tutores: 0,
        actividades: 0
    });

    useEffect(() => {
        axios.get("http://localhost:8000/api/admin/dashboard")
            .then(res => {
                setStats(res.data);
            })
            .catch(err => {
                console.error("Error cargando estadísticas: ", err);
            });
    }, []);

    return(
        <div className="admin-dashboard">
            <h1>Dashboard</h1>

            <div className="dashboard-cards">
                <div className="dashboard-card">Empleados: {stats.empleados}</div>
                <div className="dashboard-card">Tutores: {stats.tutores}</div>
                <div className="dashboard-card">Actividades: {stats.actividades}</div>
            </div>

        </div>
    );
}