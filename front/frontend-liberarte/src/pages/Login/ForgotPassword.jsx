import "./ForgotPassword.css";
import { useState } from "react";
import { useNavigate } from "react-router-dom";

export default function ForgotPassword(){

    const navigate = useNavigate();

    const [email, setEmail] = useState("");
    const [success, setSuccess] = useState(false);
    const [error, setError] = useState(false);

    const handleSubmit = async (e) => {
        e.preventDefault();

        setSuccess(false);
        setError(false);

        try{
            const response = await fetch("http://127.0.0.1:8000/api/forgot-password", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify({email})
            });

            if(response.ok){
                console.log("Email enviado correctamente.")
                setSuccess(true);
            }else {
                console.log("Error al enviar el email.")
                setError(true);
            }
        }catch (err){
            console.log("Error de conexión del servidor.")
            setError(true);
        }
    }

    return (
        <section className="section-forgot">
            <div className="forgot-content">

                <div className="forgot-card">

                    <h2 className="forgot-title">Recuperar contraseña</h2>

                    <form className="forgot-form" onSubmit={handleSubmit}>

                        <input type="email" placeholder="Introduce tu correo" className="forgot-input" required value={email} onChange={(e) => { 
                            setEmail(e.target.value);
                            setError(false);
                            setSuccess(false);
                        }}/>

                        <button className="forgot-btn">Enviar</button>

                        {success && (
                            <p className="forgot-success">
                                Si existe una cuenta con este correo, recibirás un email para restablecer tu contraseña.
                            </p>
                        )}

                        {error && (
                            <p className="forgot-error">
                                Ha ocurrido un error. Intentalo de nuevo.
                            </p>
                        )}
                        
                    </form>

                    <button className="forgot-link-btn" onClick={() => navigate("/login")}>Volver al inicio de sesión</button>

                </div>
            </div>

        </section>
    );
}