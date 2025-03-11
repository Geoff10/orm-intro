export default function NetworkRequests({ networkLog }) {
    return (
        <>
            <div className='grow basis-0 overflow-y-auto'>
                {networkLog.map((job, index) => (
                    <div key={'networkJob-' + index} className='flex flex-col border border-gray-500 m-2 rounded-md'>
                        <div className='flex justify-between'>
                            <div className='flex'>
                                <div className='px-1 uppercase'>{job.method}</div>
                                <div className='px-1'>({job.status})</div>
                            </div>
                            <div className='px-1'>{job.duration} seconds</div>
                        </div>
                    </div>
                ))}
            </div>
        </>
    )
}
