import { Link } from "react-router-dom";
import "./Tutor.css";

export default function TutorNavbar(){
    return(
        <nav className="navbar">
            <div className="nav-left">
                <Link to="/tutor">
                    <img src="/logo.png" alt="LiberArte" className="logo" />
                </Link>
            </div>

            <div className="nav-center">
                <Link to="/tutor/perfil-alumno">Perfil Alumno</Link>
                <Link to="/tutor/actividades"> Actividades y Pagos</Link>
                <Link to="/tutor/horarios">Horarios</Link>
            </div>

            <div className="nav-right">
                <button className="logout-btn" onClick={() => {
                    localStorage.clear();
                    window.location.href = "/login";
                }}> 
                    Cerrar sesión
                </button>
            </div>

            <div className="navbar-divider"></div>
        </nav>
    );
}