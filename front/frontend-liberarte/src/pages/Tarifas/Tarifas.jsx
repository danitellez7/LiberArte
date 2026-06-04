
import "./Tarifas.css";

export default function Tarifas(){
    return (
        <section id="section" className="section-tarifas">
            <div className="tarifas-content">

                <h2 className="tarifas-title">Listas de Precios</h2>

                <div className="tarifas-grid">

                    <div className="tarifa-item musica">
                        <h3>Música</h3>
                        <p>50€ por persona</p>
                        <p>85€ dos familiares</p>
                        <p>135€ tres familiares</p>
                    </div>

                    <div className="tarifa-item pintura">
                        <h3>Pintura creativa</h3>
                        <p>60€ por persona</p>
                        <p>100€ dos familiares</p>
                        <p>165€ tres familiares</p>
                    </div>

                    <div className="tarifa-item canto">
                        <h3>Canto</h3>
                        <p>50€ por persona</p>
                        <p>85€ dos familiares</p>
                        <p>135€ tres familiares</p>
                    </div>

                    <div className="tarifa-item danza">
                        <h3>Danza</h3>
                        <p>50€ por persona</p>
                        <p>85€ dos familiares</p>
                        <p>135€ tres familiares</p>
                    </div>

                    <div className="tarifa-item ceramica">
                        <h3>Cerámica</h3>
                        <p>60€ por persona</p>
                        <p>100€ dos familiares</p>
                        <p>165€ tres familiares</p>
                    </div>

                    <div className="tarifa-item teatro">
                        <h3>Teatro</h3>
                        <p>50€ por persona</p>
                        <p>85€ dos familiares</p>
                        <p>135€ tres familiares</p>
                    </div>
                </div>

                <p className="nota">
                    Si hay matriculación en dos o más disciplinas artísticas, se realiza un descuento del 20% del total mensual.
                </p>
            </div>
        </section>
    );
}