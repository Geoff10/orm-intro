export default function QueuedJobs({ queueLog, filters, setFilterJobId }) {
    return (
        <>
            <div className='border-t border-b border-gray-500 px-1 py-1 flex'>
                { filters }
            </div>
            <div className='grow basis-0 overflow-y-auto'>
                <table className='w-full text-lg'>
                    <thead>
                        <tr className='text-left'>
                            <th>Job ID</th>
                            <th>Change</th>
                        </tr>
                    </thead>
                    <tbody>
                        {queueLog.map((item, index) => (
                            <tr key={'queueJobHistory-' + index} className={index % 2 == 0 ? 'bg-slate-200' : ''}>
                                <td className='py-1'>
                                    <button onClick={() => setFilterJobId(item.jobId)} className='text-blue-500 hover:text-blue-700'>
                                        {item.jobId}
                                    </button>
                                </td>
                                <td className='py-1'>{item.message}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}
