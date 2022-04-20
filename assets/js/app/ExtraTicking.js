import React, {useState, useEffect} from "react";
import axios from 'axios';

export default function ExtraTicking(){
    const [fetching, setFetching] = useState(true);
    const [extraTicking, setExtraTicking] = useState([]);

    useEffect(() => {
        axios.get(`/extra-ticking/today`)
            .then(result => {
                setExtraTicking(result.data.extraTickings);
            })
            .catch(console.error)
            .finally(() => setFetching(false))
    },[]);

    if(fetching) return <div className="d-flex"><div className="my-auto mr-1">Chargement...</div><div className="loader simple-loader"/></div>;

    return (
        <div className="extra-tickings-container">
            <div>Pointages exceptionnels :</div>
            <div>{extraTicking.map(extraTicking => (
                <div key={`extra-ticking-${extraTicking.id}`}>
                    <div>{extraTicking.startDate} - {extraTicking.endDate}</div>
                </div>
            ))}</div>
        </div>
    );
}
