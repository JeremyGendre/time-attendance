import {useState} from "react";
import {getDateString} from "../date";

export default function useTime(){
    const [time, setTime] = useState(getDateString(new Date()));

    setInterval(() => {
        setTime(getDateString(new Date()));
    },1000);

    return time;
}
