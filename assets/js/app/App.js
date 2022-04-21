import React from 'react';
import ReactDOM from "react-dom/client";
import '../../styles/app/app.css';
import AppContextProvider, {useAppContext} from "./context/AppContext";
import Ticking from "./Ticking";
import useTime from "../utils/hooks/useTime";
import ExtraTicking from "./ExtraTicking";
import PopupContextProvider from "./context/PopupContext";

const appContainer = document.getElementById('app-container');

if(appContainer){
    let todayTicking = appContainer.getAttribute('data-today-ticking');
    if(todayTicking){
        todayTicking = JSON.parse(todayTicking);
    }
    const root = ReactDOM.createRoot(appContainer);
    root.render(
        <AppContextProvider defaultTodayTicking={(todayTicking || todayTicking !== '') ? todayTicking : null}>
            <PopupContextProvider>
                <App/>
            </PopupContextProvider>
        </AppContextProvider>
    );
}

function App(){
    const time = useTime();

    return (
        <div className="app-container">
            <div className="text-center my-2" style={{fontSize: '2em'}}>Nous sommes le <strong>{time}</strong></div>
            <div className="app-ticking-container">
                <Ticking title="Entrée" property="enterDate" action="enter"/>
                <Ticking title="Pause" property="breakDate" action="break"/>
                <Ticking title="Retour" property="returnDate" action="return"/>
                <Ticking title="Sortie" property="exitDate" action="exit"/>
            </div>
            <div className="px-2 my-2 w-full">
                <hr className="w-full"/>
            </div>
            <ExtraTicking/>
        </div>
    );
}
