import React from 'react'
import './home.scss';

export default function App() {
  return (
    <div className={'App'}>
      <header className={'header'}>
        <img src="public-assets/imagenes?path=Quetzal_Framework.png" className="App-logo" alt="logo" />
        <h1>Una forma sencilla de construir aplicaciones</h1>
        <a
          className=""
          href="https://github.com/DamianGonzalez27/Ivy"
          target="_blank"
          rel="noopener noreferrer"
        >
          Aprender Quetzal
        </a>
      </header>
    </div>
  );
}