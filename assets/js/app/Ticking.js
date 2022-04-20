import {useAppContext} from "./context/AppContext";
import React, {useState} from "react";
import axios from "axios";
import Loader from "../components/Loader";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faCircleCheck, faCircleXmark} from "@fortawesome/free-solid-svg-icons";

export default function Ticking({title = '', property, action}){
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
