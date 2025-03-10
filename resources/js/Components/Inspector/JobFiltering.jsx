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
        const [filterJobId, setFilterJobId] = useState('');

        useEffect(() => {
            setManagedQueueLog(props.queueLog.filter(job => {
                if (filterJobId !== '' && job.jobId.indexOf(filterJobId) === -1) {
                    return false;
                }

                if (filterStatus.length > 0) {
                    return filterStatus.includes(job.status);
                }

                return true;
            }));
        }, [filterStatus, filterJobId, props]);

        const filters = (<>
            <div>
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
                <div>
                    <label htmlFor="jobIdFilter" className="mr-2">Job ID:</label>
                    <input type="text" id="jobIdFilter" name="jobIdFilter" value={filterJobId} onChange={(e) => setFilterJobId(e.target.value)} className="p-0" />
                </div>
            </div>
        </>)

        return <WrappedComponent {...props} queueLog={managedQueueLog} filters={filters} setFilterJobId={setFilterJobId} />;
    };

    return WithJobFilteringComponent;
}
