import React from 'react';
import '../../styles/components/popup.css';

export default function Popup({title, children}){
    return (
        <div className="popup-background">
            <div className="popup">
                {title && <h2 className="popup-title">{title}</h2>}
                {children}
            </div>
        </div>
    );
}
