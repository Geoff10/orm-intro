import { useState } from "react";
import DatabaseQueries from "./DatabaseQueries";
import Tab from "@/Components/Navigation/Tab";

export default function Inspector({ queryLog }) {
    const [currentTab, setCurrentTab] = useState('query');

    const setTab = (tab) => {
        setCurrentTab(tab);
    };

    return (
        <div className=" h-96 w-full flex flex-col" style={InspectorStyling}>
            <nav className="border-b border-gray-500 dark:border-gray-700">
                <Tab title={`Queries (${queryLog.length})`}
                    active={currentTab === 'query'}
                    onClick={() => setTab('query')} />
            </nav>

            {currentTab === 'query' && <DatabaseQueries queryLog={queryLog} />}
        </div>
    );
};

const InspectorStyling = { boxShadow: '0 0 10px 0 #000' };
