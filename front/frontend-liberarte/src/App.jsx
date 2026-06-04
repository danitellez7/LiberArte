import { useLocation } from "react-router-dom";
import Navbar from "./components/Navbar";
import AppRouter from "./router/AppRouter";
import Footer from "./components/Footer";

export default function App() {

    const location = useLocation();

    const rutasSinLayout = [
        "/admin",
        "/empleado",
        "/tutor",
        "/nino"
    ];

    const hideLayout = 
        location.pathname.startsWith("/admin") ||
        location.pathname.startsWith("/tutor") ||
        location.pathname.startsWith("/nino");

    return (    
        <>
            {!hideLayout && <Navbar />}

            <AppRouter />

            {!hideLayout && <Footer />}
        </>
    );
}

