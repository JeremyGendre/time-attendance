import React, {useEffect, useState} from 'react';
import ReactDOM from "react-dom/client";
import PopupContextProvider from "../../app/context/PopupContext";
import axios from 'axios';
import getRealErrorMessage from "../../utils/Error";
import WideLoader from "../../components/Loader";
import '../../../styles/app/history.css';
import {faEye, faArrowLeft, faArrowRight} from "@fortawesome/free-solid-svg-icons";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import Popup from "../../components/Popup";
import {ExtraTickingTable} from "../../app/ExtraTicking";
import Button from "../../components/Button";
import {deleteUrlParam, setUrlParam} from "../../utils/url";

const historyContainer = document.getElementById('history-container');

if(historyContainer){
    const root = ReactDOM.createRoot(historyContainer);
    root.render(
        <PopupContextProvider>
            <App/>
        </PopupContextProvider>
    );

    const loadingTypes = {
        previous:1,
        current:2,
        next:3,
    };

    const resquestHistoryUrl = `/ticking/my-history`;
    const currentWeek = parseInt(historyContainer.getAttribute('data-current-week'));
    const currentYear = parseInt(historyContainer.getAttribute('data-current-year'));
    const initialRequestedWeek = parseInt(historyContainer.getAttribute('data-week'));
    const initialRequestedYear = parseInt(historyContainer.getAttribute('data-year'));

    function App(){
        const [tickings, setTickings] = useState([]);
        const [fetching, setFetching] = useState(true);
        const [loadingType, setLoadingType] = useState(null);
        const [showTickingExtras, setShowTickingExtras] = useState(null);
        const [week, setWeek] = useState(initialRequestedWeek);
        const [year, setYear] = useState(initialRequestedYear);

        useEffect(() => {
            axios.get(resquestHistoryUrl, {params: {week, year}})
                .then(result => {
                    setTickings(result.data.tickings);
                })
                .catch(error => {
                    console.error(getRealErrorMessage(error));
                })
                .finally(() => setFetching(false))
        },[]);

        const handlePreviousWeekClick = () => {
            setLoadingType(loadingTypes.previous);
            setWeek(prev => {
                if(prev === 1){
                    setYear(prev => prev - 1);
                    return 52;
                }else{
                    return prev - 1;
                }
            })
        };

        const handleCurrentWeekClick = () => {
            setLoadingType(loadingTypes.current);
            setWeek(currentWeek);
            setYear(currentYear);
        };

        const handleNextWeekClick = () => {
            setLoadingType(loadingTypes.next);
            setWeek(prev => {
                if(prev === 52){
                    setYear(prev => prev + 1);
                    return 1;
                }else{
                    return prev + 1;
                }
            })
        };

        useEffect(() => {
            if(week === currentWeek && year === currentYear){
                deleteUrlParam("week");
                deleteUrlParam("year");
            }else{
                setUrlParam("week", week);
                setUrlParam("year", year);
            }
            if(!fetching){
                axios.get(resquestHistoryUrl, {params:{week,year}})
                    .then(console.log)
                    .catch(console.error)
                    .finally(() => setLoadingType(null));
            }
        }, [week, year]);

        if(fetching) return (
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

        const canNext = year < currentYear || week < currentWeek;
        const canCurrent = week !== currentWeek || year !== currentYear;

        return (
            <div className="history-container">
                <h1>Mon Historique</h1>
                <table className="w-full text-center">
                    <thead>
                    <tr>
                        <th/>
                        <th>Date</th>
                        <th>Entrée</th>
                        <th>Pause</th>
                        <th>Retour Pause</th>
                        <th>Sortie</th>
                        <th className="text-left">Pointages exceptionnels</th>
                    </tr>
                    </thead>
                    <tbody>
                    {tickings.map(ticking => {
                        return (
                            <tr key={`ticking-${ticking.id}`}>
                                <td className="text-right">{ticking.tickingDayLabel}</td>
                                <td>{ticking.formattedTickingDay}</td>
                                <td>{ticking.formattedEnterDate}</td>
                                <td>{ticking.formattedBreakDate}</td>
                                <td>{ticking.formattedReturnDate}</td>
                                <td>{ticking.formattedExitDate}</td>
                                <td className="text-left">
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
                <div className="w-full d-flex justify-center mt-2 gap-2">
                    <Button
                        disabled={!!loadingType}
                        loading={loadingType === loadingTypes.previous}
                        onClick={handlePreviousWeekClick} icon={faArrowLeft}
                    >Semaine précédente</Button>
                    <Button
                        disabled={!!loadingType || !canCurrent}
                        loading={loadingType === loadingTypes.current}
                        onClick={handleCurrentWeekClick}
                    >Semaine en cours</Button>
                    <Button
                        disabled={!!loadingType || !canNext }
                        loading={loadingType === loadingTypes.next}
                        onClick={handleNextWeekClick}
                        icon={faArrowRight}
                        iconPosition="right"
                    >Semaine suivante</Button>
                </div>
            </div>
        );
    }
}
