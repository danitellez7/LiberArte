import React, { useEffect, useState} from "react";
import "./Inscripciones.css";

export default function Inscripciones(){

    const [tutores, setTutores] = useState([]);
    const [ninos, setNinos] = useState([]);
    const [actividades, setActividades] = useState([]);

    const [tutorId, setTutorId] = useState("");
    const [ninoId, setNinoId] = useState("");
    const [actividadId, setActividadId] = useState("");

    useEffect(() => {
        fetch("http://localhost:8000/api/admin/usuarios")
            .then(res => res.json())
            .then(data => setTutores(data));

        fetch("http://localhost:8000/api/actividades")
            .then(res => res.json())
            .then(data => setActividades(data));
    }, []);

    useEffect(() => {
        if(!tutorId) return;

        fetch(`http://localhost:8000/api/ninos/tutor/${tutorId}`)
            .then(res => res.json())
            .then(data => setNinos(data));
    }, [tutorId]);

    const handleSubmit = (e) => {
        e.preventDefault();

        const datos = {
            tutor_id: tutorId,
            nino_id: ninoId,
            actividad_id: actividadId
        };

        fetch("http://localhost:8000/api/inscripciones", {
            method: "POST",
            headers: { "Content-Type": "application/json"},
            body: JSON.stringify(datos)
        })
            .then(res => res.json())
            .then(data => {
                alert("Inscripción creada correctamente");
                console.log(data);
            });
    };

    return(
        <div className="inscripcion-page">
            
            <h1 className="inscripcion-title">Crear Inscripción</h1>

            <form className="inscripcion-form" onSubmit={handleSubmit}>

                <label>Tutor:</label>
                <select
                    className="inscripcion-select"
                    value={tutorId}
                    onChange={(e) => setTutorId(e.target.value)}
                >
                    <option value="">Seleciona un tutor</option>
                    {tutores.map(t => (
                        <option key={t.id} value={t.id}>
                            {t.nombre} {t.apellidos}
                        </option>
                    ))}
                </select>

                <label>Alumno:</label>
                <select
                    className="inscripcion-select"
                    value={ninoId}
                    onChange={(e) => setNinoId(e.target.value)}
                >
                    <option value="">Seleciona un alumno</option>
                    {ninos.map(n => (
                        <option key={n.id} value={n.id}>
                            {n.nombre} {n.apellidos}
                        </option>
                    ))}
                </select>

                <label>Actividad</label>
                <select
                    className="inscripcion-select"
                    value={actividadId}
                    onChange={(e) => setActividadId(e.target.value)}
                >
                    <option value="">Seleciona una actividad</option>
                    {actividades.map(a => (
                        <option key={a.id} value={a.id}>
                            {a.nombre}
                        </option>
                    ))}
                </select>

                <button className="inscripcion-btn" type="submit">
                    Inscribir
                </button>
            </form>
        </div>
    );
}