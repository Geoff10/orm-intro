import { useReducer, useState } from "react";

export default function QueuedJobs({ queueLog }) {
    const statusReducer = (state, jobStatus) => {
        return state.includes(jobStatus) ?
            state.filter(status => status !== jobStatus) :
            [...state, jobStatus];
    };

    const [filterStatus, setFilterStatus] = useReducer(statusReducer, []);

    const filteredJobs = queueLog.jobs.filter(job => {
        if (filterStatus.length === 0) {
            return true;
        }

        return filterStatus.includes(job.status);
    });

    return (
        <>
            <div className='border-t border-b border-gray-500 px-1 py-1 flex'>
                <div className="mr-3">
                    Statuses:
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
            </div>
            <div className='grow basis-0 overflow-y-auto'>
                <table className='w-full text-lg'>
                    <thead>
                        <tr className='text-left'>
                            <th>Job ID</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        {filteredJobs.map((job, index) => (
                            <tr key={'queueJob-' + index} className={index % 2 == 0 ? 'bg-slate-200' : ''}>
                                <td className='py-1'>{job.jobId}</td>
                                <td className='py-1'>{job.status}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}
