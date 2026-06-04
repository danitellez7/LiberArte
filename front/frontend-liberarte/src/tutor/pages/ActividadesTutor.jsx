import { useEffect, useState } from "react";
import axios from "axios";
import "./ActividadesTutor.css";

export default function ActividadesTutor(){

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
                console.log("DATA COMPLETA:", res.data);
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

    const actividadesUnicas = tutor.actividades 
        ? tutor.actividades.filter((a, index, self) =>
            index === self.findIndex(t => t.id === a.id)
          )
        : [];
    return(
        <div className="actividades-page">

            <div className="actividades-card">
                <h2>Mis Actividades</h2>
                
                {Array.isArray(tutor.actividades) && tutor.actividades.length > 0 ? (
                    actividadesUnicas.map(a => {
                        
                        const inscritos = tutor.inscripciones
                            ? tutor.inscripciones.filter(i => i.actividad_id === a.id)
                            : [];

                        return(
                            <div key={a.id} className="actividad-item">
                                <p><strong>{a.nombre}</strong></p>
                                <p><strong>Descripción:</strong> {a.descripcion}</p>

                                {inscritos.length > 0 ? (
                                    <div className="ninos-container">
                                        <p><strong>Niños inscritos:</strong></p>
                                        {inscritos.map(i => (
                                            <p key={i.id}>
                                                {i.nino.nombre} {i.nino.apellidos}
                                            </p>
                                        ))}
                                    </div>
                                ) : (
                                    <p>No hay niños inscritos</p>
                                )}
                            </div>
                        );
                    })
                ) : (
                    <p>No estás inscrito en ninguna actividad</p>
                )}
            </div>

            <div className="actividades-card">
                <h2>Mis Pagos</h2>

                {Array.isArray(tutor.pagos) && tutor.pagos.length > 0 ? (
                    tutor.pagos.map(p => (
                        <div key={p.id} className="pago-item">
                            <p><strong>Importe:</strong> {p.total_final}</p>
                            <p><strong>Fecha:</strong> {p.fecha_pago}</p>
                            <p><strong>Método:</strong> {p.metodo_pago}</p>
                            <p><strong>Estado:</strong> {p.estado}</p>
                        </div>
                    ))
                ) : (
                    <p>No tienes pagos registrados</p>
                )}
            </div>
        </div>
    );
}