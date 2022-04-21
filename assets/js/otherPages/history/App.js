import React from 'react';
import ReactDOM from "react-dom/client";
import PopupContextProvider from "../../app/context/PopupContext";

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
    return (
        <div>history</div>
    );
}
