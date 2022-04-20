import React, {useState} from 'react';
import ReactDOM from "react-dom/client";
import '../../styles/app/app.css';
import Loader from "../components/Loader";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faCircleCheck } from '@fortawesome/free-solid-svg-icons'
import AppContextProvider, {useAppContext} from "./context/AppContext";

const appContainer = document.getElementById('app-container');

if(appContainer){
    let todayTicking = appContainer.getAttribute('data-today-ticking');
    if(todayTicking){
        todayTicking = JSON.parse(todayTicking);
    }
    const root = ReactDOM.createRoot(appContainer);
    root.render(
        <AppContextProvider defaultTodayTicking={(todayTicking || todayTicking !== '') ? todayTicking : null}>
            <App/>
        </AppContextProvider>
    );
}

function App(){

    return (
        <div className="app-container">
            <Ticking title="Entrée" property="enterDate"/>
            <Ticking title="Pause" property="breakDate"/>
            <Ticking title="Retour" property="returnDate"/>
            <Ticking title="Sortie" property="exitDate"/>
        </div>
    );
}

function Ticking({title = '', property}){
    const {todayTicking} = useAppContext();
    const [loading, setLoading] = useState(false);
    const [time, setTime] = useState(todayTicking ?  todayTicking[property] : null);

    const handleClick = () => {
        if(loading || time) return;
        setLoading(true);

    };

    return (
        <div onClick={handleClick} className={`ticking-container ${loading ? 'ticking-loading' : ''} ${time ? 'ticked' : ''}`}>
            {loading && <Loader/>}
            <div>
                <div className="font-bold d-flex justify-between">
                    <div>{title}</div>
                    <div className="my-auto">
                        {time && <FontAwesomeIcon className="ticking-success-icon" icon={faCircleCheck} />}
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
