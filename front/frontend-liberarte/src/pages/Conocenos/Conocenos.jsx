import "./Conocenos.css";
import { useState } from "react";

export default function Conocenos(){

    const [activeSection, setActiveSection] = useState("que-es");
    return (
        <div className="conocenos-container">
            {/**SIDEBAR DE NAVEGACIÓN */}
            <nav className="sidebar">
                <ul>
                    <li><a href="#que-es" onClick={() => setActiveSection("que-es")}>¿Qué es LiberArte?</a></li>
                    <li><a href="#por-que-nace"  onClick={() => setActiveSection("por-que-nace")}>Por qué nace</a></li>
                    <li><a href="#vision-mision"  onClick={() => setActiveSection("vision-mision")}>Visión y misión</a></li>
                    <li><a href="#inclusion"  onClick={() => setActiveSection("inclusion")}>Inclusión</a></li>
                    <li><a href="#metodo"  onClick={() => setActiveSection("metodo")}>Método educativo</a></li>
                    <li><a href="#importancia"  onClick={() => setActiveSection("importancia")}>Importancia del arte</a></li>
                    <li><a href="#actividades"  onClick={() => setActiveSection("actividades")}>Actividades</a></li>
                    <li><a href="#equipo"  onClick={() => setActiveSection("equipo")}>Nuestro equipo</a></li>
                    <li><a href="#cta"  onClick={() => setActiveSection("cta")}>Contacto</a></li>
                </ul>
            </nav>

            {/**CONTENIDO PRINCIPAL */}
            <div className="sections">

                {/**¿QUÉ ES LIBERARTE? */}
                <section 
                id="que-es" 
                className={`section ${activeSection === "que-es" ? "active-section" : ""}`}>
                    <div className="text">
                        <h2>¿Qué es LiberArte?</h2>
                        <p>
                            LiberArte es expresión artística que ofrece teatro, danza, pintura, cerámica, música y canto para niños de 3 a 7 años. Un espacio inclusivo donde cada niño puede explorar, expresarse y crecer.
                        </p>
                    </div>
                    <div>
                        <img src="/about-image.png" alt="Que es"/>
                    </div>
                </section>

                {/**POR QUÉ NACE */}
                <section 
                id="por-que-nace" 
                className={`section ${activeSection === "por-que-nace" ? "active-section" : ""}`}>
                    <div className="text">
                        <h2>¿Por qué nace LiberArte?</h2>
                        <p>
                            En Algeciras existe una falta real de actividades artísticas para la infancia.
                            LiberArte surge para ofrecer un espacio seguro, creativo e inclusivo donde los niños puedan desarrollar su creatividad lejos de las pantallas.
                        </p>
                    </div>
                    <di>
                        <img src="/por-que-nace.png" alt="Por que nace" />
                    </di>
                    
                </section>

                {/**VISIÓN Y MISIÓN */}
                <section 
                id="vision-mision" 
                className={`section ${activeSection === "vision-mision" ? "active-section" : ""}`}>
                    <div className="columns">
                        <div className="text">
                            <h2>Visión</h2>
                            <p>
                            Ser un espacio artístico inclusivo donde cada niño pueda expresarse libremente.
                            </p>
                        </div>

                        <div className="text">
                            <h2>Misión</h2>
                            <p>
                                Acompañar a los niños en su desarrollo emocional, social y creativo a través del arte
                            </p>

                        </div>
                    
                        <div className="text">
                            <h2>Valores</h2>
                                <ul>
                                <li>Creatividad</li>
                                <li>Inclusión</li>
                                <li>Respeto</li>
                                <li>Diversidad</li>
                            </ul>
                        </div>
                    </div>

                    <img src="/vision-mision.png" alt="vision-mision"/>

                </section>

                {/**INCLUSIÓN */}
                <section 
                id="inclusion"
                className={`section ${activeSection === "inclusion" ? "active-section" : ""}`}>
                    <div className="text">
                        <h2>Un espacio para todos</h2>
                        <p>
                            LiberArte es accesible para niños con diversidad funcional y de diferentes culturas.
                            Creemos en un entorno donde cada niño pueda participar, aprender y expresarse sin barreras. 
                        </p>
                    </div>
                    <div>
                        <img src="/inclusion.png" alt="inclusion" />
                    </div>
                </section>

                {/**MÉTODO EDUCATIVO */}
                <section 
                id="metodo" 
                className={`section ${activeSection === "metodo" ? "active-section" : ""}`}>
                    <div className="text">
                        <h2>Nuestro método educativo</h2>
                        <p>
                            Basado en el aprendizaje a través del arte, el juego y la experimentación.
                            Fomentamos el desarrollo emocional, cognitivo y social mediante actividades artísticas diseñadas para la etapa de 3 a 7 años. 
                        </p>
                    </div>
                    <div>
                        <img src="/metodo.png" alt="Nuestro método" />
                    </div>
                </section>

                {/**IMPORTANCIA DEL ARTE */}
                <section 
                id="importancia" 
                className={`section ${activeSection === "importancia" ? "active-section" : ""}`}>
                    <div className="text">
                        <h2>¿Por qué el arte es esencial?</h2>
                        <div className="cards">
                            <div className="card">
                                <p>Creatividad y expresión emocional </p>
                                <img src="/creatividad-expresion.png" alt="Creatividad y expresion" />    
                            </div>
                            <div className="card">
                                <p>Desarrollo cognitivo y social</p>
                                <img src="/desarrollo.png" alt="Desarrollo" />    
                            </div>
                            <div className="card">
                                <p>Inclusión y diversidad</p>
                                <img src="/inclusion-diversidad.png" alt="Inclusion y diversidad" />    
                            </div>
                            <div className="card">
                                <p>Pensamiento crítico</p>
                                <img src="/pensamiento-critico.png" alt="Pensamiento critico" />    
                            </div>
                        </div>
                    </div>
                </section>

                {/**ACTIVIDADES */}
                <section 
                id="actividades" 
                className={`section ${activeSection === "actividades" ? "active-section" : ""}`}>
                    <div className="text">
                        <h2>Actividades destacadas</h2>
                        <div className="activity-list">
                            <div className="activity-card">
                                <p>"Taller de cerámica"</p>
                                <img src="/ceramica.png" alt="Taller de cerámica" />
                            </div>
                            <div className="activity-card">
                                <p>"El cuento en títeres y marionetas"</p>
                                <img src="/marionetas.png" alt="Taller de títeres" />
                            </div>
                            <div className="activity-card">
                                <p>"Teoría del color</p>
                                <img src="/color.png" alt="teoría del color" />
                            </div>
                        </div>
                    </div>
                </section>

                {/**EQUIPO */}
                <section 
                id="equipo"
                className={`section ${activeSection === "equipo" ? "active-section" : ""}`}>
                    <div className="text">
                        <h2>Nuestro equipo</h2>
                        <div className="team-member-content">
                            <div className="team-member">
                                <h3>Laura Gómez Allevato</h3>
                                <p>Educadora infantil y promotora del proyecto</p>

                                <div className="member-body">
                                    <img src="laura-allevato.png" alt="Laura Allevato" />

                                    <div className="descripcion">
                                        <p>"Soy una persona entusiasta y creativa, le pongo el corazón a todo lo que hago. La educación y el arte en todas sus vertientes son mis dos pasiones, y desde ellas busco acompañar, inspirar y transformar a quienes se cruzan con mi trabajo".</p>
                                    </div>
                                </div>
                            </div>

                            <div className="team-member">
                                <h3>Dani Tellez</h3>
                                <p>Especialista en expresión artística</p>

                                <div className="member-body">
                                    <img src="dani-tellez.png" alt="Dani Tellez" />

                                    <div className="descripcion">
                                        <p>"Soy una persona bastante creativa, con mucha iniciativa y confianza en todo lo que hace, y pongo esa energía al servicio de transformar ideas en experiencias que inspiren, conecten y dejen huella en quienes las viven."</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/**CTA */}
                <section 
                id="cta" 
                className={`section ${activeSection === "cta" ? "active-section" : ""}`}>
                    <div className="text">
                        <h2>¿Quiéres saber más?</h2>

                        <a href="/contacto" className="cta-btn" >Contáctanos</a>
                    </div>
                    <div>
                        <img src="/rosquilla-contacto.png" alt="Contáctanos" />
                    </div>
                </section>
            </div>
        </div>
    );
}