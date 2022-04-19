import React, {useContext, useState} from "react";

const AppContext = React.createContext(null);

export const useAppContext = () => useContext(AppContext);

export default function AppContextProvider({defaultTodayTicking = null, children}){
    const [todayTicking, setTodayTicking] = useState(defaultTodayTicking);
    return (
        <AppContext.Provider value={{todayTicking, setTodayTicking}}>
            {children}
        </AppContext.Provider>
    )
}
