import React, {useState, useEffect} from "react";
import axios from 'axios';
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faPlus} from "@fortawesome/free-solid-svg-icons";

export default function ExtraTicking(){
    const [fetching, setFetching] = useState(true);
    const [extraTickings, setExtraTickings] = useState([]);

    useEffect(() => {
        axios.get(`/extra-ticking/today`)
            .then(result => {
                setExtraTickings(result.data.extraTickings);
            })
            .catch(console.error)
            .finally(() => setFetching(false))
    },[]);

    if(fetching) return <div className="d-flex"><div className="my-auto mr-1">Chargement...</div><div className="loader simple-loader"/></div>;

    return (
        <div className="extra-tickings-container">
            <h2 className="d-inline-block">Pointages exceptionnels ({extraTickings.length})</h2>
            <div className="d-inline-block ml-2 my-auto">
                <div className="d-flex my-button">
                    <FontAwesomeIcon className="my-auto mr-1" icon={faPlus} /> Nouveau
                </div>
            </div>
            {extraTickings.length > 0 && (
                <table>
                    <thead>
                    <tr>
                        <th>Départ</th>
                        <th>Retour</th>
                        <th>Détail</th>
                    </tr>
                    </thead>
                    <tbody>
                    {extraTickings.map(extraTicking => (
                        <tr key={`extra-ticking-${extraTicking.id}`}>
                            <td>{extraTicking.startDate}</td>
                            <td>{extraTicking.endDate}</td>
                            <td>{extraTicking.description}</td>
                        </tr>
                    ))}
                    </tbody>
                </table>
            )}
        </div>
    );
}
