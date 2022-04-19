import React, {useState} from 'react';
import ReactDOM from "react-dom/client";
import '../../styles/app/app.css';
import Loader from "../components/Loader";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faCircleCheck } from '@fortawesome/free-solid-svg-icons'

const appContainer = document.getElementById('app-container');

if(appContainer){
    let todayTicking = appContainer.getAttribute('data-today-ticking');
    if(todayTicking){
        todayTicking = JSON.parse(todayTicking);
    }
    const root = ReactDOM.createRoot(appContainer);
    root.render(<App todayTicking={(todayTicking || todayTicking !== '') ? todayTicking : null}/>);
}

function App({todayTicking = null}){

    console.log(todayTicking);

    return (
        <div className="app-container">
            <Ticking title="Entrée" defaultTime={todayTicking ? todayTicking.enterDate : null}/>
            <Ticking title="Pause" defaultTime={todayTicking ? todayTicking.breakDate : null}/>
            <Ticking title="Retour" defaultTime={todayTicking ? todayTicking.returnDate : null}/>
            <Ticking title="Sortie" defaultTime={todayTicking ? todayTicking.exitDate : null}/>
        </div>
    );
}

function Ticking({title = '', defaultTime = null}){
    const [loading, setLoading] = useState(false);
    const [time, setTime] = useState(defaultTime);

    const handleClick = () => {
        if(loading) return;
        setLoading(true);
        setTimeout(() => {
            setLoading(false);
            setTime('12:51');
        },2000);
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
