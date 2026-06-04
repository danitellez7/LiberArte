import { Outlet } from "react-router-dom";
import TutorNavbar from "./TutorNavbar";
import "./Tutor.css";

export default function TutorLayout(){
    return(
        <div className="tutor-layout">
            <TutorNavbar />

            <div className="tutor-main">
                <div className="tutor-container">
                    <Outlet />
                </div>
            </div>
        </div>
    );
}