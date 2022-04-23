import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import React from "react";
import '../../styles/components/button.css';
import {Loader} from "./Loader";

export default function Button(
    {
        icon = null,
        iconPosition = 'left',
        bordered = false,
        filled = false,
        noBackground = false,
        loading = false,
        children,
        ...other
    }
) {
    const isIconLeft = iconPosition === 'left';
    return (
        <button {...other} className={`d-flex my-button ${bordered ? 'bordered-button' : ''} ${filled ? 'filled-button' : ''} ${noBackground ? 'no-background' : ''}`}>
            {!isIconLeft ? children : ''}
            {loading ? (
                <Loader loaderStyle={{borderTop:'solid 2px var(--header-background-color)', width:'1em', height:'1em', marginRight:'0.5em'}}/>
            ) : (
                <>{icon && <FontAwesomeIcon className={`my-auto ${isIconLeft ? 'mr-1' : 'ml-1'}`} icon={icon} />}</>
            )}
            {isIconLeft ? children : ''}
        </button>
    );
}
