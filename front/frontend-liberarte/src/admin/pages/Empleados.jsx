import { useEffect, useState } from "react";
import axios from "axios";
import {useNavigate} from "react-router-dom";
import "./Empleado.css";

export default function Empleados(){

    const [empleados, setEmpleados] = useState([]);
    const navigate = useNavigate();

    useEffect(() => {
        axios.get("http://localhost:8000/api/admin/empleados")
            .then(res => {
                setEmpleados(res.data);
            })
            .catch(err => console.log("Error cargando empleados:", err));
    }, []);

    return(
        <div className="empleados-container">
            <h1>Empleados</h1>

            <div className="empleados-lista">
                {empleados.map(e => (
                    <div key={e.id} className="empleado-card">

                        <h2 className="empleado-nombre">
                            {e.nombre} {e.apellidos}
                        </h2>

                        <p><strong>Email:</strong> {e.email}</p>
                        <p><strong>Teléfono:</strong> {e.telefono}</p>
                        <p><strong>Rol:</strong> {e.rol}</p>

                        <button className="btn-ver-datos" onClick={() => navigate(`/admin/empleados/${e.id}`)}>
                            Ver datos
                        </button>
                    </div>
                ))}

            </div>

        </div>
    );
}