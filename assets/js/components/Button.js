import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import React from "react";
import '../../styles/components/button.css';

export default function Button({icon = null, bordered = false, children, ...other}){
    return (
        <button {...other} className={`d-flex my-button ${bordered ? 'bordered-button' : ''}`}>
            {icon && <FontAwesomeIcon className="my-auto mr-1" icon={icon} />}
            {children}
        </button>
    );
}
