import { useEffect, useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import "./Usuarios.css";

export default function Usuarios() {

    const [usuarios, setUsuarios] = useState([]);
    const [usuarioSeleccionado, setUsuarioSeleccionado] = useState(null);
    const [ninosUsuario, setNinosUsuario] = useState([]);

    const [nuevoNino, setNuevoNino] = useState({
        nombre: "",
        apellidos: "",
        fecha_nacimiento: "",
        sexo: "",
        alergias: "",
        observaciones: ""
    });

    const navigate = useNavigate();

    useEffect(() => {
        cargarUsuarios();
    }, []);

    const cargarUsuarios = async () => {
        const res = await axios.get("http://localhost:8000/api/admin/usuarios");
        setUsuarios(res.data);
    };

    const cargarNinos = async (usuarioId) => {
        const res = await axios.get(`http://localhost:8000/api/ninos?tutor_id=${usuarioId}`);
        setNinosUsuario(res.data);
    };

    const crearNino = async () => {
        await axios.post("http://localhost:8000/api/admin/ninos", {
            tutor_id: usuarioSeleccionado.id,
            ...nuevoNino
        });

        setNuevoNino({
            nombre: "",
            apellidos: "",
            fecha_nacimiento: "",
            sexo: "",
            alergias: "",
            observaciones: ""      
        });

        cargarNinos(usuarioSeleccionado.id);
        cargarUsuarios();
    };

    const borrarNino = async (id) => {
        await axios.delete(`http://localhost:8000/api/admin/ninos/${id}`);
        
        cargarNinos(usuarioSeleccionado.id);
        cargarUsuarios();
    };

    return(
        <div className="usuarios-page">

            <h1 className="usuarios-title">Usuarios</h1>

            <div className="usuarios-grid">
                {usuarios.map((u) => (
                    <div key={u.id} className="usuario-card">

                        <h3 className="">
                            {u.nombre} {u.apellidos}
                        </h3>

                        <p><strong>Niños:</strong> {u.ninos}</p>
                        <p><strong>Edades:</strong> {u.edades.join(", ")}</p>
                        <p><strong>Actividades:</strong> {u.actividades.join(", ")}</p>
                        <p><strong>Pagos:</strong> {u.pagos}</p>

                        <button
                            className="usuario-btn"
                            onClick={() => {
                            setUsuarioSeleccionado(u);
                            cargarNinos(u.id);
                            }}
                        >
                            Añadir / Gestionar niños
                        </button>

                        <button className="usuario-btn" onClick={() => navigate(`/admin/usuarios/${u.id}`)}>Ver datos</button>
                    </div>
                ))}
            </div>
            {usuarioSeleccionado && (
                <div className="panel-ninos">

                    <h2>Niños de {usuarioSeleccionado.nombre}</h2>

                    {ninosUsuario.length === 0}

                    {ninosUsuario.map(n => (
                        <div key={n.id} className="nino-item">
                            <p><strong>{n.nombre} {n.apellidos}</strong></p>
                            <button
                                className="btn-borrar-nino"
                                onClick={() => borrarNino(n.id)}
                            >
                                Borrar
                            </button>

                        </div>
                    ))}

                    <hr />

                    <h3>Añadir nuevo niño</h3>

                    <input 
                        type="text"
                        placeholder="Nombre"
                        value={nuevoNino.nombre}
                        onChange={e => setNuevoNino({...nuevoNino, nombre: e.target.value})} 
                    />

                    <input 
                        type="text"
                        placeholder="Apellidos"
                        value={nuevoNino.apellidos}
                        onChange={e => setNuevoNino({...nuevoNino, apellidos: e.target.value})} 
                    />

                    <input 
                        type="date"
                        value={nuevoNino.fecha_nacimiento}
                        onChange={e => setNuevoNino({...nuevoNino, fecha_nacimiento: e.target.value})} 
                    />

                    <select
                        value={nuevoNino.sexo}
                        onChange={e => setNuevoNino({...nuevoNino, sexo: e.target.value})} 
                    >
                        <option value="">Sexo</option>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                        <option value="otro">Otro</option>
                    </select>

                    <textarea
                        placeholder="Alergias"
                        value={nuevoNino.alergias}
                        onChange={e => setNuevoNino({...nuevoNino, alergias: e.target.value})} 
                    />

                    <textarea
                        placeholder="Observaciones"
                        value={nuevoNino.observaciones}
                        onChange={e => setNuevoNino({...nuevoNino, observaciones: e.target.value})} 
                    />

                    <button className="usuario-btn" onClick={crearNino}>
                        Guardar
                    </button>

                    <button 
                        className="usuario-btn cancelar"
                        onClick={() => setUsuarioSeleccionado(null)}
                    >
                        Cerrar
                    </button>
                </div>
            )}
        </div>
    );
}