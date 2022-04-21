import React, {useContext, useState} from "react";
import Popup from "../../components/Popup";

const PopupContext = React.createContext(null);

export const usePopupContext = () => useContext(PopupContext);

export default function PopupContextProvider({children}){
    const [showPopup, setShowPopup] = useState(false);
    const [title, setTitle] = useState('Erreur');
    const [type, setType] = useState(null);
    const [message, setMessage] = useState('Une erreur est survenue');

    const firePopup = (newTitle = 'Erreur', newMessage = 'Une erreur est survenue', newType = null) => {
        setTitle(newTitle);
        setMessage(newMessage);
        setType(newType);
        setShowPopup(true);
    };

    return (
        <PopupContext.Provider value={{firePopup}}>
            {children}
            <Popup onClose={() => setShowPopup(false)} show={showPopup} type={type} title={title}>
                {message}
            </Popup>
        </PopupContext.Provider>
    )
}
