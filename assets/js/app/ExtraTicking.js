import React, {useState, useEffect} from "react";
import axios from 'axios';
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faPlus, faCircleXmark} from "@fortawesome/free-solid-svg-icons";
import Popup from "../components/Popup";
import Button from "../components/Button";
import {usePopupContext} from "./context/PopupContext";
import getRealErrorMessage from "../utils/Error";

export default function ExtraTicking(){
    const [fetching, setFetching] = useState(true);
    const [extraTickings, setExtraTickings] = useState([]);
    const [showPopup, setShowPopup] = useState(false);

    useEffect(() => {
        axios.get(`/extra-ticking/today`)
            .then(result => {
                setExtraTickings(result.data.extraTickings);
            })
            .catch(console.error)
            .finally(() => setFetching(false))
    },[]);

    const handleNewExtraTickingClick = () => {
        setShowPopup(true);
    };

    const handleNewExtraTicking = (newExtraTicking) => {
        setExtraTickings(prev => [...prev, newExtraTicking]);
        setShowPopup(false);
    };

    const handleCancelExtraTicking = (extraTicking) => {
        setExtraTickings(prev => prev.filter(et => et.id !== extraTicking.id));
    };

    if(fetching) return <div className="d-flex"><div className="my-auto mr-1">Chargement...</div><div className="loader simple-loader"/></div>;

    return (
        <div className="extra-tickings-container">
            <h2 className="d-inline-block">Pointages exceptionnels ({extraTickings.length})</h2>
            <div className="d-inline-block ml-2 my-auto">
                <Button onClick={handleNewExtraTickingClick} icon={faPlus}>Nouveau</Button>
            </div>
            {extraTickings.length > 0 && (
                <ExtraTickingTable extraTickings={extraTickings} onCancel={handleCancelExtraTicking}/>
            )}
            <Popup onClose={() => setShowPopup(false)} show={showPopup} title="Pointage exceptionnel">
                <NewExtraTickingForm onNew={handleNewExtraTicking}/>
            </Popup>
        </div>
    );
}

export function ExtraTickingTable({extraTickings, fullWidth = false, onCancel = null}) {
    const [cancelingExtraTickings, setCancelingExtraTickings] = useState([]);
    const {firePopup} = usePopupContext();

    const handleCancelExtraTicking = (extraTicking) => event => {
        setCancelingExtraTickings(prev => [...prev, extraTicking]);
        axios.delete(`/extra-ticking/${extraTicking.id}`)
            .then(() => {
                onCancel(extraTicking);
            })
            .catch(error => {
                firePopup('Erreur', getRealErrorMessage(error), 'error');
            })
            .finally(() => {
                setCancelingExtraTickings(prev => prev.filter(et => et.id !== extraTicking.id));
            })
    };

    return (
        <table className={fullWidth ? 'w-full text-left' : ''}>
            <thead>
            <tr>
                <th>D??part</th>
                <th>Retour</th>
                <th>D??tail</th>
                <th/>
            </tr>
            </thead>
            <tbody>
            {extraTickings.map(extraTicking => {
                const deleting = cancelingExtraTickings.find(et => et.id === extraTicking.id);
                return (
                    <tr key={`extra-ticking-${extraTicking.id}`}>
                        <td>{extraTicking.formattedStartDate}</td>
                        <td>{extraTicking.formattedEndDate}</td>
                        <td>{!!extraTicking.description ? extraTicking.description : <small><i>Aucun d??tail</i></small>}</td>
                        <td>{(extraTicking.deletable && onCancel !== null) ? (
                            <Button
                                bordered
                                noBackground
                                onClick={handleCancelExtraTicking(extraTicking)}
                                loading={deleting}
                                disabled={deleting}
                            >
                                Annuler
                            </Button>
                        ) : ''}</td>
                    </tr>
                );
            })}
            </tbody>
        </table>
    );
}

function NewExtraTickingForm({onNew}){
    const [start, setStart] = useState('');
    const [end, setEnd] = useState('');
    const [description, setDescription] = useState('');
    const [error, setError] = useState(null);
    const [submitting, setSubmitting] = useState(false);

    const handleSubmit = (e) => {
        e.preventDefault();
        if(!start || !end){
            setError("L'heure de d??part et de retour doivent ??tre renseign??es");
            return;
        }
        setError(null);
        setSubmitting(true);
        axios.post(`/extra-ticking/today`,{start,end,description})
            .then(result => {
                onNew(result.data.extraTicking);
            })
            .catch(error => {
                setError(getRealErrorMessage(error));
            })
            .finally(() => setSubmitting(false))
    };

    const isFormValid = !!start && !!end;

    return (
        <form onSubmit={handleSubmit}>
            <div className="d-flex justify-center flex-wrap gap-2 my-2">
                <div>
                    <label htmlFor="extra-ticking-start" className="d-block text-center" style={{marginBottom: '0.2em'}}>
                        D??part {!!start && <FontAwesomeIcon onClick={() => setStart('')} className="cursor-pointer theme-icons" icon={faCircleXmark}/>}
                    </label>
                    <input id="extra-ticking-start" type="time" value={start} onChange={e => setStart(e.target.value)}/>
                </div>
                <div>
                    <label htmlFor="extra-ticking-end" className="d-block text-center" style={{marginBottom: '0.2em'}}>
                        Retour {!!end && <FontAwesomeIcon onClick={() => setEnd('')} className="cursor-pointer theme-icons" icon={faCircleXmark}/>}
                    </label>
                    <input id="extra-ticking-end" type="time" value={end} onChange={e => setEnd(e.target.value)}/>
                </div>
            </div>
            <textarea
                className="w-full max-w-full mb-2 p-1"
                rows={6}
                placeholder="D??tail"
                onChange={(e) => setDescription(e.target.value)}
                value={description}
            />
            {error && <div className="error mb-2 text-center">{error}</div>}
            <div className="d-flex justify-center">
                <Button disabled={!isFormValid || submitting} filled bordered>
                    {submitting ? 'Enregistrement...' : 'Enregistrer'}
                </Button>
            </div>
        </form>
    );
}
