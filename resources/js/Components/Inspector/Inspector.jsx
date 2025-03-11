import { useMemo, useState } from "react";
import DatabaseQueries from "./DatabaseQueries";
import QueuedJobs from "./Queues/QueuedJobs";
import withJobFiltering from "./Queues/JobFiltering";
import Tab from "@/Components/Navigation/Tab";

export default function Inspector({ queryLog = null, queueLog = null, fullHeight = false }) {
    const [currentTab, setCurrentTab] = useState(queryLog ? 'query' : 'queue');
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

    const EnhancedQueuedJobs = useMemo(() => withJobFiltering(QueuedJobs), [QueuedJobs]);

    return (
        <div className={`w-full flex flex-col ${fullHeight ? 'flex-grow' : ''}`} style={InspectorStyling}>
            <div className="flex justify-between items-center">
                <nav className="border-b border-gray-500 dark:border-gray-700">
                    {queryLog && <Tab title={`Queries (${queryLog.length})`}
                        active={currentTab === 'query'}
                        onClick={() => setTab('query')} />}
                    {queueLog && <Tab title={`Queued Jobs (${queueLog.jobs.length})`}
                        active={currentTab === 'queue'}
                        onClick={() => setTab('queue')} />}
                </nav>
                {fullHeight || <div>
                    <button onClick={() => decreaseInspectorHeight()}>
                        <span className="material-symbols-rounded">remove</span>
                    </button>
                    <button onClick={() => increaseInspectorHeight()}>
                        <span className="material-symbols-rounded">add</span>
                    </button>
                </div>}
            </div>

            <div className={`flex flex-col ${fullHeight ? 'flex-grow' : ''}`} style={{ height: fullHeight ? '100%' : `${height}rem` }}>
                {currentTab === 'query' && queryLog && <DatabaseQueries queryLog={queryLog} />}
                {currentTab === 'queue' && queueLog && <EnhancedQueuedJobs queueLog={queueLog.jobs} />}
            </div>
        </div>
    );
};

const InspectorStyling = { boxShadow: '0 0 10px 0 #000' };
