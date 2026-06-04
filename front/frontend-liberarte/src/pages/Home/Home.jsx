import "./Home.css";

export default function Home(){
    return(
        <div className="home">

            <div className="home-background">
                {/**IMAGEN */}
                <img src="/ilustracion-fondo.png" alt="Fondo LiberArte" className="home-bg-img" />
            
                {/*CONTENEDOR IZQUIERDO */}
                <div className="home-card">
                <h1>Arte en libertad, expresión sin <br/>fronteras</h1>
                    
                <div className="home-badges">

                    <div className="badge-item">
                        <img src="/icon-creatividad.png" alt="Creatividad" className="badge-icon"/>
                            <p>Creatividad para niños 3 - 7 años</p>
                    </div>

                    <div className="badge-item">
                        <img src="/icon-sin-pantallas.png" alt="Sin pantallas" className="badge-icon"/>
                            <p>Entorno sin pantallas</p>
                        </div>

                    <div className="badge-item">
                        <img src="/icon-inclusion.png" alt="Inclusión" className="badge-icon"/>
                            <p>Espacio seguro e inclusivo</p>
                    </div>
                </div>

                <a href="/conocenos" className="hero-btn">Conócenos</a>

                </div>

            </div>
        </div>
    );  
}