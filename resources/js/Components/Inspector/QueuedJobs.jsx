import QueuedJob from "./Queues/QueuedJob";

export default function QueuedJobs({ queueLog, filters }) {
    return (
        <>
            <div className='border-t border-b border-gray-500 px-1 py-1 flex'>
                {filters}
            </div>
            <div className='grow basis-0 overflow-y-auto'>
                {queueLog.map((job, index) => (
                    <QueuedJob key={'queueJob-' + index} job={job} />
                ))}
            </div>
        </>
    )
}
