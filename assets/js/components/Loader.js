import React from "react";
import '../../styles/components/loader.css';

export default function WideLoader({containerClass = '', loaderClass = '', containerStyle = {} , loaderStyle = {}}){
    return (
        <div className={"loader-container " + containerClass} style={containerStyle}>
            <Loader loaderClass={loaderClass} loaderStyle={loaderStyle}/>
        </div>
    );
}

export function Loader({loaderClass = '' , loaderStyle = {}}){
    return(
        <div className={"loader " + loaderClass} style={loaderStyle}/>
    )
}
