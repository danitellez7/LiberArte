import { NavLink, useLocation } from "react-router-dom";
import { useEffect, useState } from "react";
import axios from "../axios";
import "./Admin.css";

export default function AdminNavbar(){

    const [noLeidas, setNoLeidas] = useState(0);
    const location = useLocation();

    return(
        <nav className="admin-navbar">
            <div className="admin-navbar-left">
                <h2 className="admin-logo">Panel Admin</h2>
            </div>

            <ul className="admin-navbar-links">
                <li><NavLink to="/admin" end>Dashboard</NavLink></li>
                <li><NavLink to="/admin/usuarios">Usuarios</NavLink></li> 
                <li><NavLink to="/admin/empleados">Empleados</NavLink></li> 
                <li><NavLink to="/admin/actividades">
                        Actividades
                    </NavLink>
                </li>
                <li><NavLink to="/admin/inscripciones">Inscripciones</NavLink></li>
            </ul>

            <div className="admin-navbar-right">
                <NavLink to="/login" className="admin-logout">Cerrar sesión</NavLink>
            </div>

        </nav>
    );
}