import { Outlet } from "react-router-dom";
import AdminNavbar from "./AdminNavbar";
import "./Admin.css";

export default function AdminLayout(){
    return(
        <div className="admin-layout">
            <AdminNavbar />

            <div className="admin-main">
                <div className="admin-container">
                    <Outlet />
                </div>

            </div>

        </div>
    );
}