import React, {useState, useEffect} from "react";
import axios from 'axios';
import {faPlus} from "@fortawesome/free-solid-svg-icons";
import Popup from "../components/Popup";
import Button from "../components/Button";

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
                <Button icon={faPlus}>Nouveau</Button>
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
            <Popup title="Pointage exceptionnel">
                <form>
                    <div className="d-flex justify-between my-2">
                        <input type="time"/>
                        <input type="time"/>
                    </div>
                    <textarea className="w-full mb-2"></textarea>
                    <Button bordered>Enregistrer</Button>
                </form>
            </Popup>
        </div>
    );
}
