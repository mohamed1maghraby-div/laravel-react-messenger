import React from "react";

export const EventBusContext = React.createContext();

export const EventBusProvider = ({ children }) => {
    const [events, setEvents] = React.useState({});

    const emit = (name, data) => {
        if(events[name]){
            for(let cd of events[name]){
                cd(data);
            }
        }
    }
    const on = (name, cb) => {
        if(!events[name]){
            events[name] = [];
        }

        events[name].push(cb);

        return () => {
            events[name] = events[name].filter((callback) => callback !== cb);
        }
    }
    return (
        <EventBusContext.Provider value={{ emit, on }}>
            {children}
        </EventBusContext.Provider>
    )
}

export const useEventBus = () => {
    return React.useContext(EventBusContext);
}