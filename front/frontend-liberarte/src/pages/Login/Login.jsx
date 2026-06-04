import "./Login.css";
import { useState } from "react";
import { useNavigate } from "react-router-dom";

export default function Login(){

    const navigate = useNavigate();

    //Estados para capturas email y password
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [error, setError] = useState(false);

    //Función para el formulario
    const handleSubmit = async (e) => {
        e.preventDefault();

        setError("");
        console.log("FORMULARIO ENVIADO");

        try{
            const response = await fetch("http://127.0.0.1:8000/api/login", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify({email, password})
            });

            console.log("STATUS: ", response.status);

            const data = await response.json();
            console.log("DATA RAW: ", data);

            //Credenciales incorrectas
            if(response.status === 401){
                setError("Credendiales incorrectas");
                return;
            }

            if(response.status === 403){
                setError("Debes verificar tu email antes de iniciar sesión");
                return;
            }

            //Otro error
            if(!response.ok){
                setError("Error al iniciar sesión");
                return;
            }

            localStorage.setItem("token", data.token);
            localStorage.setItem("user", JSON.stringify(data.user));
            localStorage.setItem("rol", data.user.rol);

            if (data.user.rol === "tutor") {
                localStorage.setItem("tutor_id", data.user.id);
            }

            if (data.user.rol === "tutor"){
                if(!data.user.nombre || !data.user.apellidos){
                    navigate("/crear-perfil");
                    return;
                }
            }

            if(data.user.rol ==="admin") navigate("/admin");
            if(data.user.rol === "empleado") navigate("/empleado");
            if(data.user.rol === "tutor") navigate("/tutor");

        }catch(error){
            console.log("ERROR: ", error );
            setError("Error de conexión con el servidor");
        }
    };

    return(
        <section id="section" className="section-login">
            <div className="login-content">

                <div className="login-card">

                    <h2 className="login-title">Inicia sesión</h2>

                    <form className="login-form" onSubmit={handleSubmit}>

                        <input type="email" placeholder="Correo" className="login-input" required value={email} onChange={(e) => { setEmail(e.target.value); setError("")}} />

                        <input type="password" placeholder="Contraseña" className="login-input" required value={password} onChange={(e) => {setPassword(e.target.value); setError("")}}/>

                        <button type="submit" className="login-btn">Acceder</button>
                        
                        {error && (
                            <p className="login-error" style={{color: "red"}}>{error}</p>
                        )}
                        
                    </form>

                    <div className="login-links">

                        <button className="login-link-btn" onClick={() => navigate("/forgot-password")}>¿Has olvidado la contraseña?</button>
                    </div>
                </div>
            </div>
        </section>

    );
}