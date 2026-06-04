import "./Contacto.css";
import { useEffect } from "react";

export default function Contacto() {

    useEffect(() =>{
        const form = document.querySelector("#contacto-form");
        const success = document.querySelector("#contacto-success");
        const title = document.querySelector("#contacto-title");


        if (!form || !success) return;

        form.addEventListener("submit", (e) =>{
        e.preventDefault();

        form.style.display = "none";

        title.style.display = "none";

        success.style.display = "block";
        });
    }, []);

    return(
        <section id="section" className="section-contacto">
            <div className="contacto-content">

                <h2 id="contacto-title" className="contacto-title">Contáctanos</h2>

                <form id="contacto-form" className="contacto-form">

                    <input type="text" placeholder="Nombre" className="contacto-input" required/>

                    <input type="email" placeholder="Correo" className="contacto-input" required />

                    <textarea placeholder="Escribe tu mensaje..." className="contacto-textarea" required></textarea>

                    <button className="contacto-btn">Enviar</button>
                </form>

                <p id="contacto-success" className="contacto-success" style={{display: "none"}}>¡Mensaje enviado correctamente</p>

            </div>
        </section>
    );
}