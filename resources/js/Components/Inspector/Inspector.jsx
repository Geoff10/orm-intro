import { useState } from "react";
import DatabaseQueries from "./DatabaseQueries";
import Tab from "@/Components/Navigation/Tab";

export default function Inspector({ queryLog }) {
    const [currentTab, setCurrentTab] = useState('query');

    const setTab = (tab) => {
        setCurrentTab(tab);
    };

    return (
        <div className="h-24 w-full grow flex flex-col">
            <nav className="border-b border-gray-500 dark:border-gray-700">
                <Tab title='Queries' active={currentTab === 'query'} onClick={() => setTab('query')} />
            </nav>

            {currentTab === 'query' && <DatabaseQueries queryLog={queryLog} />}
        </div>
    );
};
