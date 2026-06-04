//LiberArte
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Home from "../pages/Home/Home";
import Conocenos from "../pages/Conocenos/Conocenos";
import Novedades from "../pages/Novedades/Novedades";
import Tarifas from "../pages/Tarifas/Tarifas";
import Contacto from "../pages/Contacto/Contacto";

import Login from "../pages/Login/Login";
import ForgotPassword from "../pages/Login/ForgotPassword";

import Admin from "../admin/AdminLayout";
import Tutor from "../tutor/Tutor";

import Privacidad from "../pages/Legal/Privacidad";
import Cookies from "../pages/Legal/Cookies";
import AvisoLegal from "../pages/Legal/AvisoLegal";
import Terminos from "../pages/Legal/Terminos";

//Panel admin
import AdminLayout from "../admin/AdminLayout";
import Dashboard from "../admin/pages/Dashboard";
import Usuarios from "../admin/pages/Usuarios";
import UsuarioDetalle from "../admin/pages/UsuarioDetalle";
import Empleados from "../admin/pages/Empleados";
import EmpleadoDetalle from "../admin/pages/EmpleadoDetalle";
import Inscripciones from "../admin/pages/Inscripciones";

//Tutor
import TutorLayout from "../tutor/TutorLayout";
import TutorNavbar from "../tutor/TutorNavbar";
import InicioTutor from "../tutor/pages/InicioTutor";
import ActividadesTutor from "../tutor/pages/ActividadesTutor";
import PerfilAlumno from "../tutor/pages/PerfilAlumno";
import Actividades from "../admin/pages/Actividades";
import Horarios from "../tutor/pages/Horarios";


export default function AppRouter(){
    return(
            <Routes>
                {/**Páginas públicas */}
                <Route path="/" element={<Home />} />
                <Route path="/conocenos" element={<Conocenos />} />
                <Route path="/novedades" element={<Novedades />} />
                <Route path="/tarifas" element={<Tarifas />} />
                <Route path="/contacto" element={<Contacto />} />

                {/**Autenticación */}
                <Route path="/login" element={<Login />} />
                <Route path="/forgot-password" element={<ForgotPassword />} />

                <Route path="/admin" element={<AdminLayout/>}>
                    <Route index element={<Dashboard/>} />
                    <Route path="usuarios" element={<Usuarios />} />
                    <Route path="usuarios/:id" element={<UsuarioDetalle />} />

                    <Route path="empleados" element={<Empleados />} />
                    <Route path="empleados/:id" element={<EmpleadoDetalle />} />
                    
                    <Route path="actividades" element={<Actividades />} />
                    <Route path="inscripciones" element={<Inscripciones />} />
                </Route>

                <Route path="/tutor" element={<TutorLayout />}>
                    <Route index element={<InicioTutor />} />
                    <Route path="perfil-alumno" element={<PerfilAlumno />} />
                    <Route path="actividades" element={<ActividadesTutor />} />
                    <Route path="Horarios" element={<Horarios />} />
                </Route>

                {/**Legal */}
                <Route path="/privacidad" element={<Privacidad />} />
                <Route path="/cookies" element={<Cookies />} />
                <Route path="/aviso-legal" element={<AvisoLegal />} />
                <Route path="/terminos" element={<Terminos />} />
            </Routes>
    );
}
