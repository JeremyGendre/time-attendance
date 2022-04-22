import React, {useEffect, useState} from 'react';
import ReactDOM from "react-dom/client";
import PopupContextProvider from "../../app/context/PopupContext";
import axios from 'axios';
import getRealErrorMessage from "../../utils/Error";

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

    return (
        <div>history</div>
    );
}
