import { useState } from "react";
import DatabaseQueries from "./DatabaseQueries";
import Tab from "@/Components/Navigation/Tab";

export default function Inspector({ queryLog }) {
    const [currentTab, setCurrentTab] = useState('query');
    const [height, setHeight] = useState(24);

    const setTab = (tab) => {
        setCurrentTab(tab);
    };

    const increaseInspectorHeight = () => {
        if (height < 48) {
            setHeight(height + 24);
        }
    }

    const decreaseInspectorHeight = () => {
        if (height > 2) {
            setHeight(height - 24);
        }
    }

    return (
        <div className="w-full flex flex-col" style={InspectorStyling}>
            <div className="flex justify-between items-center">
                <nav className="border-b border-gray-500 dark:border-gray-700">
                    <Tab title={`Queries (${queryLog.length})`}
                        active={currentTab === 'query'}
                        onClick={() => setTab('query')} />
                </nav>
                <div>
                    <button onClick={() => decreaseInspectorHeight()}>
                        <span class="material-symbols-rounded">remove</span>
                    </button>
                    <button onClick={() => increaseInspectorHeight()}>
                        <span class="material-symbols-rounded">add</span>
                    </button>
                </div>
            </div>

            <div class="flex flex-col" style={{ height: `${height}rem` }}>
                {currentTab === 'query' && <DatabaseQueries queryLog={queryLog} />}
            </div>
        </div>
    );
};

const InspectorStyling = { boxShadow: '0 0 10px 0 #000' };
