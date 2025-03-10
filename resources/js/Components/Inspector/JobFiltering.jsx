import { useEffect, useReducer, useState } from "react";

export default function withJobFiltering(WrappedComponent) {
    const WithJobFilteringComponent = (props) => {
        const statusReducer = (state, jobStatus) => {
            return state.includes(jobStatus) ?
                state.filter(status => status !== jobStatus) :
                [...state, jobStatus];
        };

        const [managedQueueLog, setManagedQueueLog] = useState(props.queueLog);
        const [filterStatus, setFilterStatus] = useReducer(statusReducer, []);

        useEffect(() => {
            setManagedQueueLog(props.queueLog.filter(job => {
                if (filterStatus.length === 0) {
                    return true;
                }

                return filterStatus.includes(job.status);
            }));
        }, [filterStatus, props]);

        const filters = (<>
            <fieldset className="flex">
                <div className="mr-3">
                    <legend>Statuses:</legend>
                </div>
                <div className="mr-3">
                    <input type="checkbox" id="queuedStatus" name="queuedStatus" checked={filterStatus.includes('queued')} onChange={() => setFilterStatus('queued')} />
                    <label htmlFor="queuedStatus" className='ml-2 select-none'>Queued</label>
                </div>
                <div className="mr-3">
                    <input type="checkbox" id="processingStatus" name="processingStatus" checked={filterStatus.includes('processing')} onChange={() => setFilterStatus('processing')} />
                    <label htmlFor="processingStatus" className='ml-2 select-none'>Processing</label>
                </div>
                <div className="mr-3">
                    <input type="checkbox" id="failedStatus" name="failedStatus" checked={filterStatus.includes('failed')} onChange={() => setFilterStatus('failed')} />
                    <label htmlFor="failedStatus" className='ml-2 select-none'>Failed</label>
                </div>
                <div>
                    <input type="checkbox" id="completedStatus" name="completedStatus" checked={filterStatus.includes('completed')} onChange={() => setFilterStatus('completed')} />
                    <label htmlFor="completedStatus" className='ml-2 select-none'>Completed</label>
                </div>
            </fieldset>
        </>)

        return <WrappedComponent {...props} queueLog={managedQueueLog} filters={filters} />;
    };

    return WithJobFilteringComponent;
}
