import React, {useState} from 'react';
import ReactDOM from "react-dom/client";
import '../../styles/app/app.css';
import Loader from "../components/Loader";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faCircleCheck } from '@fortawesome/free-solid-svg-icons'

const appContainer = document.getElementById('app-container');

if(appContainer){
    const root = ReactDOM.createRoot(appContainer);
    root.render(<App/>);
}

function App(){
    return (
        <div className="app-container">
            <Ticking title="Entrée"/>
            <Ticking title="Pause"/>
            <Ticking title="Retour"/>
            <Ticking title="Sortie"/>
        </div>
    );
}

function Ticking({title = ''}){
    const [ticked, setTicked] = useState(false);
    const [loading, setLoading] = useState(false);
    const [time, setTime] = useState(null);

    const handleClick = () => {
        setLoading(true);
        setTimeout(() => {
            setLoading(false);
            setTicked(prev => !prev);
            setTime('12:51');
        },2000);
    };

    return (
        <div onClick={handleClick} className={`ticking-container ${loading ? 'ticking-loading' : ''} ${ticked ? 'ticked' : ''}`}>
            {loading && <Loader/>}
            <div>
                <div className="font-bold d-flex justify-between">
                    <div>{title}</div>
                    <div className="my-auto">
                        {ticked && <FontAwesomeIcon className="ticking-success-icon" icon={faCircleCheck} />}
                    </div>
                </div>
                <hr/>
                <div>
                    {time ? (
                        <div>Pointé à : <strong>{time}</strong></div>
                    ) : (
                        <small><i>Aucun horaire saisi</i></small>
                    )}
                </div>
            </div>
        </div>
    );
}
