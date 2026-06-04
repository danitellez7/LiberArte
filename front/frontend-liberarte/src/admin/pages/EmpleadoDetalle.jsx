import { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import axios from "axios";
import "./Empleado.css";

export default function EmpleadoDetalle(){
    
    const { id } = useParams();
    const navigate = useNavigate();

    const [empleado, setEmpleado] = useState(null);
    const [loading, setLoading] = useState(true);
    const[error, setError] = useState(null);

    const [contrato, setContrato] = useState(null);
    const [subiendo, setSubiendo] = useState(false);

    useEffect(() => {
        setLoading(true);
        setError(null);

        axios.get(`http://localhost:8000/api/admin/empleados/${id}`)
            .then (res => {
                if(res.data && res.data.empleado){
                    setEmpleado(res.data.empleado);
                }else{
                    setError("Empleado no encontrado");
                }
            })
            .catch(err => {
                setError("Error cargando empleado");
                console.error("Error cargando empleado: ", err);
            })
            .finally(() => setLoading(false));
    }, [id]);

    const handleUpload = async () => {
        if(!contrato) {
            setError("Selecciona un archivo PDF antes de subir");
            return;
        }

        setSubiendo(true);
        setError(null);

        const formData = new FormData();
        formData.append("contrato", contrato);

        try{
            const res = await axios.post(
                `http://localhost:8000/api/admin/empleados/${id}/contrato`,
                formData,
                {
                    headers: {"Content-Type": "multipart/form-data"},
                }
            );
            setEmpleado((prev) => ({
                ...prev,
                contrato_pdf: res.data.archivo,
            }));

            setContrato(null);
        }catch (err){
            setError("Erro subiendo contrato");
            console.error("Error subiendo contrato:", err);
        }finally{
            setSubiendo(false);
        }
    };

    if (loading) return <p>Cargando...</p>;
    if (error) return (
        <div className="empleado-detalle-container">
            <button className="btn-volver" onClick={() => navigate("/admin/empleados")}>Volver</button>
            <p style={{color: 'red'}}>{error}</p>
        </div>
    )

    return(
        <div className="empleado-detalle-container">
            
            <button className="btn-volver" onClick={() => navigate("/admin/empleados")}>
                Volver
            </button>

            <div className="empleado-detalle-card">

                <h2 className="empleado-detalle-titulo">
                    Datos del Empleado
                </h2>

                <ul className="empleado-detalle-lista">
                    <li><strong>ID:</strong> {empleado.id}</li>
                    <li><strong>Nombre:</strong>  {empleado.nombre}  {empleado.apellidos}</li>
                    <li><strong>DNI:</strong>  {empleado.dni}</li>
                    <li><strong>Email:</strong> {empleado.email}</li>
                    <li><strong>Teléfono</strong> {empleado.telefono}</li>
                    <li><strong>Dirección:</strong> {empleado.direccion}</li>
                    <li><strong>Rol:</strong> {empleado.rol}</li>
                </ul>

                {empleado.contrato_pdf ? (
                    <p>
                        <strong>Contrato:</strong>{" "}
                        <a href={`http://localhost:8000/storage/contratos/${empleado.contrato_pdf}`} target="_blank" rel="noreferrer">
                            Ver / Descargar contrato
                        </a>
                    </p>
                ) : (
                    <p><em>No hay contrato subido</em></p>
                )}

                <hr />

                <h3>Subir / Remplazar contrato</h3>
                
                <input type="file" accept="application/pdf"
                onChange={(e) => setContrato(e.target.files[0])} />

                <button onClick={handleUpload} disabled={subiendo} style={{marginTop: "10px"}}>
                    {subiendo ? "Subiendo..." : "Subir contrato"}
                </button>
            </div>
        </div>
    )
}