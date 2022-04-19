import React, {useState} from 'react';
import ReactDOM from "react-dom/client";
import '../../styles/app/app.css';
import Loader from "../components/Loader";

const appContainer = document.getElementById('app-container');

if(appContainer){
    const root = ReactDOM.createRoot(appContainer);
    root.render(<App/>);
}

function App(){
    return (
        <div className="app-container">
            <Ticking>Entrée</Ticking>
            <Ticking>Pause</Ticking>
            <Ticking>Retour</Ticking>
            <Ticking>Sortie</Ticking>
        </div>
    );
}

function Ticking({children}){
    const [ticked, setTicked] = useState(false);
    const [loading, setLoading] = useState(false);

    const handleClick = () => {
        setLoading(true);
        setTimeout(() => {
            setLoading(false);
            setTicked(prev => !prev)
        },2000);
    };

    return (
        <div onClick={handleClick} className={`ticking-container ${loading ? 'ticking-loading' : ''} ${ticked ? 'ticked' : ''}`}>
            {loading && <Loader/>}
            {children}
        </div>
    );
}
