import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import { useNavigate } from "react-router-dom";
import axios from "axios";

export default function UsuarioDetalle(){

    const { id } = useParams();
    const navigate = useNavigate();
    const [usuario, setUsuario] = useState(null);

    useEffect(() => {
        axios.get(`http://localhost:8000/api/admin/usuarios/${id}`)
            .then(res => {
                
                console.log("RESPUESTA BACK: ", res.data);

                setUsuario(res.data.usuario);
            })
            .catch(err => console.error("Error cargando usuario: ", err));
    }, [id]);

    if (!usuario) return <p>Cargando...</p>;

    return(
        <div style={{padding: "20px"}}>

            <button className="detalle-btn" onClick={() => navigate("/admin/usuarios")}>Volver</button>

            <div className="detalle-card">
                <h1>{usuario.nombre} {usuario.apellidos}</h1>
                <h3>Datos del tutor</h3>
                <ul className="detalle lista">
                    <li><span className="detalle-subtitulo">ID:</span> {usuario.id}</li>
                    <li> <span className="detalle-subtitulo">DNI:</span> {usuario.dni}</li>
                    <li><span className="detalle-subtitulo">Email:</span> {usuario.email}</li>
                    <li><span className="detalle-subtitulo">Teléfono:</span> {usuario.telefono}</li>
                    <li><span className="detalle-subtitulo">Dirección:</span> {usuario.direccion}</li>
                </ul>
            </div>
            
            <div className="detalle-card">
                <h3>Niños</h3>
                <ul className="detalle-lista">
                    {usuario.ninos.map((n, index) => (
                        <li key={index}>
                            <span className="detalle-subtitulo">{n.nombre} {n.apellidos} </span>
                            <br/>Edad: {n.edad} años
                            <br/>Sexo: {n.sexo}
                            <br/>Alergias: {n.alergias}
                            <br/>Observaciones: {n.observaciones}
                        </li>
                    ))}
                </ul>   
            </div>
            
            <div className="detalle-card">
                <h3>Actividades</h3>
                <ul className="detalle-lista">
                    {usuario.actividades.map((a, index) => {
                        
                        const inscritos = usuario.inscripciones
                            ? usuario.inscripciones.filter(i => i.actividad_id === a.id)
                            : [];

                        return(
                            <li key={index}>
                                <span className="detalle-subtitulo">{a.nombre}</span>
                                <br/>Descripción: {a.descripcion}

                                {inscritos.length > 0 ? (
                                    <ul style={{ marginTop: "8px"}}>
                                        <strong>Niños inscritos:</strong>
                                        {inscritos.map(i => (
                                            <li key={i.id}>
                                                {i.nino.nombre} {i.nino.apellidos}
                                            </li>
                                        ))}
                                    </ul>
                                ) : (
                                    <p>No hay niños inscritos</p>
                                )}
                            </li>
                        );
                    })}
                </ul>
            </div>
            
            <div className="detalle-card">
                <h3>Pagos</h3>
                <ul>
                    {usuario.pagos.map((p, index)=> (
                        <li key={index}>
                            <span className="detalle-subtitulo">Mes:</span> {p.mes}
                            <br/>Total sin descuento: {p.total_sin_descuento}€
                            <br/>Descuento aplicado: {p.descuento_aplicado}€
                            <br/>Total final: {p.total_final}€
                            <br/>Estado: {p.estado}
                            <br/>Método de pago: {p.metodo_pago}
                            <br/>Fecha de pago: {p.fecha_pago}
                            <br/>Nota: {p.notas}
                        </li>
                    ))}
                </ul>
            </div>
        </div>
    );
}