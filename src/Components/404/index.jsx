import React from "react"
import BtnUsuario from '../landing/landing_components/BtnUsuario/btn_usuario'
import './scss/index.scss'

export default function Error()
{
    return (
        <div className="error">
           <h1><i className="fas fa-exclamation-triangle"></i></h1>
            <h2>OOPS! <br/> Ocurrió un error.</h2>
            <h2>Página no encontrada</h2>
            <a href="/home" className="btn">Volver al Home</a>
        </div>
    )
}