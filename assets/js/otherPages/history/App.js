import React, {useEffect, useState} from 'react';
import ReactDOM from "react-dom/client";
import PopupContextProvider from "../../app/context/PopupContext";
import axios from 'axios';
import getRealErrorMessage from "../../utils/Error";
import WideLoader from "../../components/Loader";
import '../../../styles/app/history.css';
import {faEye} from "@fortawesome/free-solid-svg-icons";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import Popup from "../../components/Popup";
import {ExtraTickingTable} from "../../app/ExtraTicking";

const historyContainer = document.getElementById('history-container');

if(historyContainer){
    const root = ReactDOM.createRoot(historyContainer);
    root.render(
        <PopupContextProvider>
            <App/>
        </PopupContextProvider>
    );
}

function App(){
    const [tickings, setTickings] = useState([]);
    const [loading, setLoading] = useState(true);
    const [showTickingExtras, setShowTickingExtras] = useState(null);

    useEffect(() => {
        axios.get(`/ticking/my-history`)
            .then(result => {
                setTickings(result.data.tickings);
            })
            .catch(error => {
                console.error(getRealErrorMessage(error));
            })
            .finally(() => setLoading(false))
    },[]);

    if(loading) return (
        <WideLoader
            containerStyle={{backgroundColor:'transparent'}}
            loaderStyle={{
                borderWidth:'4px',
                width:'3em',
                height: '3em',
                borderColor:'var(--background-color)',
                borderBottomColor:'var(--header-background-color)'
            }}
        />
    );

    return (
        <div className="history-container">
            <h1>Mon Historique</h1>
            <table className="w-full text-center">
                <thead>
                <tr>
                    <th>Journée</th>
                    <th>Entrée</th>
                    <th>Pause</th>
                    <th>Retour Pause</th>
                    <th>Sortie</th>
                    <th>Pointages exceptionnels</th>
                </tr>
                </thead>
                <tbody>
                {tickings.map(ticking => {
                    return (
                        <tr key={`ticking-${ticking.id}`}>
                            <td>{ticking.formattedTickingDay}</td>
                            <td>{ticking.formattedEnterDate}</td>
                            <td>{ticking.formattedBreakDate}</td>
                            <td>{ticking.formattedReturnDate}</td>
                            <td>{ticking.formattedExitDate}</td>
                            <td>
                                {ticking.extraTickings.length}
                                {ticking.extraTickings.length > 0 && (
                                    <FontAwesomeIcon title="Voir" onClick={() => setShowTickingExtras(ticking)} className="ml-1 cursor-pointer theme-icons" icon={faEye}/>
                                )}
                            </td>
                        </tr>
                    );
                })}
                </tbody>
            </table>
            {!!showTickingExtras && (
                <Popup onClose={() => setShowTickingExtras(null)} show={true} title={`Pointage(s) exceptionnel(s) du ${showTickingExtras.formattedTickingDay}`}>
                    <ExtraTickingTable fullWidth extraTickings={showTickingExtras.extraTickings}/>
                </Popup>
            )}
        </div>
    );
}
