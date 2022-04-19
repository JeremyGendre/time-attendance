import React from "react";
import '../../styles/components/loader.css';

export default function Loader({containerClass = '', loaderClass = '', containerStyle = {} , loaderStyle = {}}){
    return (
        <div className={"loader-container " + containerClass} style={containerStyle}>
            <div className={"loader " + loaderClass} style={loaderStyle}/>
        </div>
    );
}
