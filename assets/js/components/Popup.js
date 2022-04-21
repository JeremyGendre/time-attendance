import React, {useState, useEffect} from 'react';
import '../../styles/components/popup.css';
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faCircleCheck, faCircleXmark} from "@fortawesome/free-solid-svg-icons";

export default function Popup(
    {
        title,
        onClose = () => {},
        show = true,
        type = null,
        children
    }
){
    const [display, setDisplay] = useState(show);

    useEffect(() => {
        if(show !== display){
            setDisplay(show);
        }
    },[show]);

    const handleClickAway = (e) => {
        if(e.target.classList.contains('popup-background')){
            setDisplay(false);
        }
    };

    useEffect(() => {
        if(!display) onClose();
    },[display]);

    if(!display) return;

    const icon = () => {
        switch(type) {
            case 'error':
                return <FontAwesomeIcon style={{color:'red'}} icon={faCircleXmark}/>;
            case 'success':
                return <FontAwesomeIcon style={{color:'green'}} icon={faCircleCheck}/>;
            default:
                return '';
        }
    };

    return (
        <PopupContent onClose={handleClickAway}>
            <div className="popup-background">
                <div className="popup">
                    {title && <h2 className="popup-title">{icon()} {title}</h2>}
                    {children}
                </div>
            </div>
        </PopupContent>
    );
}

function PopupContent({children, onClose}){

    // to handle click away
    useEffect(() => {
        document.addEventListener('click', onClose);
        return () => {
            document.removeEventListener('click', onClose);
        }
    },[]);

    return(
        <>{children}</>
    );
}
