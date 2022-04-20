import {useState, useEffect} from "react";
import {getDateString} from "../date";

export default function useTime(){
    const [time, setTime] = useState(getDateString(new Date()));

    useEffect(() => {
        const interval = setInterval(() => {
            setTime(getDateString(new Date()));
        },1000);
        return () => clearInterval(interval)
    },[]);

    return time;
}
