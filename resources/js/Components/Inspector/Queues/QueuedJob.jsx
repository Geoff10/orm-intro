export default function QueuedJob({ job, ...props }) {
    const getJobClasses = (job) => {
        let classes = ['flex', 'items-center', 'w-full', 'border', 'rounded-md', 'px-4', 'py-2', 'm-1'];

        switch (job.status) {
            case 'queued':
                classes.push('bg-gray-100', 'border-gray-400', 'text-gray-900');
                break;
            case 'processing':
                classes.push('bg-blue-100', 'border-blue-400', 'text-blue-900');
                break;
            case 'failed':
                classes.push('bg-red-100', 'border-red-400', 'text-red-900');
                break;
            case 'completed':
                classes.push('bg-green-100', 'border-green-400', 'text-green-900');
                break;
        }

        return classes.join(' ');
    };

    const getIndicatorSymbol = (job) => {
        switch (job.status) {
            case 'queued':
                return <span className="mr-2 material-symbols-rounded">pending</span>;
            case 'processing':
                return <span className="mr-2 material-symbols-rounded animate-spin">progress_activity</span>;
            case 'failed':
                return <span className="mr-2 material-symbols-rounded">cancel</span>;
            case 'completed':
                return <span className="mr-2 material-symbols-rounded">check_circle</span>;
        }
    }

    return (<div {...props} className={getJobClasses(job)}>
        {getIndicatorSymbol(job)}
        <div className="flex-grow">{job.jobId}</div>
        <div className="flex-grow text-right">{job.status}</div>
    </div>);
}
