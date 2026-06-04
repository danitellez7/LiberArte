import { Link } from "react-router-dom";
import "./Navbar.css";

export default function Navbar(){
    return(
        <nav className="navbar">
            <div className="nav-left">
                <Link to="/">
                    <img src="/logo.png" alt="LiberArte" className="logo" />
                </Link>
            </div>

            <div className="nav-center">
                <Link to="/conocenos">Conócenos</Link>
                <Link to="/novedades">Novedades</Link>
                <Link to="/tarifas">Tarifas</Link>
                <Link to="/contacto">Contacto</Link>
            </div>

            <div className="nav-right">
                <Link to="/login">
                    <img src="/user-icon.png" alt="Login" className="login-icon" />
                </Link>
            </div>

            <div className="navbar-divider"></div>
        </nav>
    );
}