import React, {useContext, useState} from "react";
import Popup from "../../components/Popup";

const PopupContext = React.createContext(null);

export const usePopupContext = () => useContext(PopupContext);

export default function PopupContextProvider({children}){
    const [showPopup, setShowPopup] = useState(false);
    const [title, setTitle] = useState('');
    const [type, setType] = useState(null);
    const [message, setMessage] = useState('');

    const firePopup = (newTitle = '', newMessage = '', newType = null) => {
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
