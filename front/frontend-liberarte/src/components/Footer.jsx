import "./Footer.css";
import { Link } from "react-router-dom";

export default function Footer(){
    return(
        <footer className="footer" role="contentinfo">
            <div className="footer-inner">
                <div className="footer-block footer-brand">
                    <img src="/LiberArte.png" alt="LiberArte" className="footer-logo"/>
                    <p className="footer-phrase">Creando arte, creando futuro.</p>

                    <div className="social-icons" aria-label="Redes sociales">
                        <a href="#" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
                            <img src="/icon-instagram.png" alt="Instagram"/>
                        </a>
                        <a href="#" aria-label="Facebook" target="_blank" rel="noopener noreferrer">
                            <img src="/icon-facebook.png" alt="Facebook" />
                        </a>
                        <a href="#" aria-label="YouTube" target="_blank" rel="noopener noreferrer">
                            <img src="/icon-youtube.png" alt="YouTube"/>
                        </a>
                    </div>
                </div>
            

                {/**ENLACES */}
                <div className="footer-block footer-links">
                    <h3>Enlaces</h3>
                    <Link to="/">Inicio</Link>
                    <Link to="/conocenos">Conócenos</Link>
                    <Link to="/novedades">Novedades</Link>
                    <Link to="/tarifas">Tarifas</Link>
                    <Link to="/contacto">Contacto</Link>
                </div>

                {/**CONTACTO */}
                <div className="footer-block footer-contact">
                    <h3>Contacto</h3>
                    <p>📍 Calle ejemplo 14, Algeciras</p>
                    <p>📧 info@liberarte.com</p>
                    <p>📞 600 000 000</p>
                </div>

                {/**LEGAL */}
                <div className="footer-block footer-legal">
                    <h3>Legal</h3>
                    <Link to="/privacidad">Política de privacidad</Link>
                    <Link to="/cookies">Política de Cookies</Link>
                    <Link to="/aviso-legal">Aviso Legal</Link>
                    <Link to="/terminos">Términos y condiciones</Link>
                </div>
            </div>

            {/**COPYRIGHT */}
            <div className="footer-bottom" role="note">
                <p>© 2026 LiberArte - Todos los derechos reservados</p>
            </div>
        </footer>
    )
}