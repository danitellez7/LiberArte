import { useEffect, useState } from "react";
import axios from "axios";
import "./Actividades.css";

export default function Actividades(){

    const [actividades, setActividades] = useState([]);
    const [form, setForm] = useState({
        nombre: "",
        descripcion: "",
        area_artistica: "",
        edad_minima: "",
        edad_maxima: "",
        duracion: "",
        estado: "activa",
        imagen: "",
        empleado_id: ""
    });

    useEffect(() => {
        cargarActividades();
    }, []);

    const cargarActividades = () => {
        axios.get("http://localhost:8000/api/actividades")
            .then(res => setActividades(res.data))
            .catch(err => console.error(err));
    };

    const handleChange = (e) => {
        setForm({
            ...form,
            [e.target.name]: e.target.value
        });
    };

    const crearActividad = (e) => {
        e.preventDefault();

        axios.post("http://localhost:8000/api/actividades", form)
            .then(() => {
                cargarActividades();
                setForm({
                    nombre: "",
                    descripcion: "",
                    area_artistica: "",
                    edad_minima: "",
                    edad_maxima: "",
                    estado: "activa",
                    imagen: "",
                    empleado_id: ""
                });
            })
            .catch(err => console.error(err));
    };

    const borrarActividad = (id) => {
        axios.delete(`http://localhost:8000/api/actividades/${id}`)
            .then(() => cargarActividades())
            .catch(err => console.error(err));
        
    };

    return(
        <div className="actividades-container">

            <h1>Actividades</h1>

            <form className="actividad-form" onSubmit={crearActividad}>
                <input type="text" name="nombre" placeholder="Nombre" value={form.nombre} onChange={handleChange} required />

                <textarea name="descripcion" placeholder="Descripción" value={form.descripcion} onChange={handleChange} required></textarea>

                <input type="text" name="area_artistica" placeholder="Área artística" value={form.area_artistica} onChange={handleChange} required />

                <input type="number" name="edad_minima" placeholder="Edad mínima" value={form.edad_minima} onChange={handleChange} />

                <input type="number" name="edad_maxima" placeholder="Edad máxima" value={form.edad_maxima} onChange={handleChange} />

                <input type="text" name="duracion" placeholder="Duración" value={form.duracion} onChange={handleChange} />

                <select name="estado" value={form.estado} onChange={handleChange}>
                    <option value="activa">Activa</option>
                    <option value="inactiva">Inactiva</option>
                </select>

                <input type="text" name="imagen" placeholder="URL de imagen" value={form.imagen} onChange={handleChange} />

                <input type="number" name="empleado_id" placeholder="ID del empleado" value={form.empleado_id} onChange={handleChange} />

                <button type="submit">Crear actividad</button>
            </form>

            <ul className="actividad-lista">
                {actividades.map(act => (
                    <li key={act.id} className="actividad-item">
                        <span>{act.nombre}</span>
                        <button onClick={() => borrarActividad(act.id)}>Eliminar</button>

                    </li>
                ))}

            </ul>

        </div>
    )
}