import React, {useState} from 'react';
import ReactDOM from "react-dom/client";
import '../../styles/app/app.css';
import Loader from "../components/Loader";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faCircleCheck, faCircleXmark } from '@fortawesome/free-solid-svg-icons'
import AppContextProvider, {useAppContext} from "./context/AppContext";
import axios from "axios";

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
            <Ticking title="Entrée" property="enterDate" action="enter"/>
            <Ticking title="Pause" property="breakDate" action="break"/>
            <Ticking title="Retour" property="returnDate" action="return"/>
            <Ticking title="Sortie" property="exitDate" action="exit"/>
        </div>
    );
}

function Ticking({title = '', property, action}){
    const {todayTicking} = useAppContext();
    const [loading, setLoading] = useState(false);
    const [time, setTime] = useState(todayTicking ?  todayTicking[property] : null);
    const [error, setError] = useState(null);

    const handleClick = () => {
        if(loading || time) return;
        setLoading(true);
        setError(null);
        axios.post(`/ticking`,{action})
            .then(({data}) => {
                setTime(data.time);
            })
            .catch(error => {
                const message = error.response ? error.response.data.detail : error.toString();
                setError(message);
            })
            .finally(() => setLoading(false));
    };

    return (
        <div onClick={handleClick} className={`ticking-container ${loading ? 'ticking-loading' : ''} ${time ? 'ticked' : ''} ${error ? 'ticking-error' : ''}`}>
            {loading && <Loader/>}
            <div>
                <div className="font-bold d-flex justify-between">
                    <div>{title}</div>
                    <div className="my-auto">
                        {time && <FontAwesomeIcon className="ticking-success-icon ticking-icon" icon={faCircleCheck} />}
                        {error && <FontAwesomeIcon className="ticking-error-icon ticking-icon" icon={faCircleXmark} />}
                    </div>
                </div>
                <hr/>
                {error && <div className="error">{error}</div>}
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
