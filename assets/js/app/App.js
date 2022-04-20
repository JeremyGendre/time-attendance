import React, {useState} from 'react';
import ReactDOM from "react-dom/client";
import '../../styles/app/app.css';
import AppContextProvider, {useAppContext} from "./context/AppContext";
import Ticking from "./Ticking";
import {getDateString} from "../utils/date";

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
    const {todayTicking} = useAppContext();
    const [date, setDate] = useState(getDateString(new Date()));

    setInterval(() => {
        setDate(getDateString(new Date()));
    },1000);

    return (
        <div className="app-container">
            <div className="text-center my-2 flex-1" style={{fontSize: '2em'}}>Nous sommes le <strong>{date}</strong></div>
            <div className="app-ticking-container">
                <Ticking title="Entrée" property="enterDate" action="enter"/>
                <Ticking title="Pause" property="breakDate" action="break"/>
                <Ticking title="Retour" property="returnDate" action="return"/>
                <Ticking title="Sortie" property="exitDate" action="exit"/>
            </div>
            <div className="px-2 my-2 w-full">
                <hr className="w-full"/>
            </div>
            <div>oui</div>
        </div>
    );
}
