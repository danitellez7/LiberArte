import { useEffect, useState } from "react";
import "./PerfilAlumno.css";
import axios from "axios";

export default function PerfilAlumno(){

    const [tutor, setTutor] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const tutorId = localStorage.getItem("tutor_id");

    useEffect(() => {
        if(!tutorId){
            setError("No hay tutor_id en localStorage");
            setLoading(false);
            return;
        }

        const fetchTutor = async () => {
            try{
                setLoading(true);
                const res = await axios.get(`http://localhost:8000/api/tutor/${tutorId}`);
                const data = res.data.usuario ?? res.data;
                setTutor(data);
            }catch(err){
                console.error(err);
                setError("Error al obtener datos del servidor");
            }finally{
                setLoading(false);
            }
        };
        fetchTutor();
    }, [tutorId]);

    if (loading) return <h2>Cargando perfil...</h2>;
    if (error) return <h2>{error}</h2>;
    if (!tutor) return <h2>No se encontró el tutor</h2>;

    return(
        <div className="perfil-page">
            <div className="perfil-card">
                <h2>Perfil</h2>
                <p><strong>Nombre:</strong> {tutor.nombre}  {tutor.apellidos}</p>
                <p><strong>Email:</strong> {tutor.email}</p>
                <p><strong>Teléfono:</strong> {tutor.telefono}</p>
            </div>
        

            <div className="perfil-card">
                <h2>Hijos</h2>
                {Array.isArray(tutor.ninos) && tutor.ninos.length > 0 ? (
                    tutor.ninos.map(h => (
                        <div key={h.id} className="perfil-item">
                            <p><strong>{h.nombre} {h.apellidos}</strong></p>
                            <p>Edad: {h.edad}</p>
                            <p>Alergias: {h.alergias || "Ninguna"}</p>
                            <p>Observaciones: {h.observaciones || "Ninguna"}</p>
                        </div>
                    ))
                ) : (
                    <p>No hay hijos registrados</p>
                )}
            </div>
        </div>
    );
}