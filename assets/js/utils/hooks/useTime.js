import {useState, useEffect} from "react";
import {getDateString} from "../date";

export default function useTime(){
    const [time, setTime] = useState(getDateString(new Date()));

    const interval = setInterval(() => {
        setTime(getDateString(new Date()));
    },1000);

    useEffect(() => {
        return () => clearInterval(interval)
    },[]);

    return time;
}
