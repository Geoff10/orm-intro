import { useState } from "react";

export default function QueuedJobs({ queueLog }) {
    const [showBindings, setShowBindings] = useState(false);
    const [showTime, setShowTime] = useState(false);

    return (
        <>
            <div className='border-t border-b border-gray-500 px-1 py-1 flex'>
                <div className="mr-3">
                    Display:
                </div>
                <div className="mr-3">
                    <input type="checkbox" id="showBindings" name="showBindings" checked={showBindings} onChange={() => setShowBindings(!showBindings)} />
                    <label htmlFor="showBindings" className='ml-2 select-none'>Bindings</label>
                </div>
                <div>
                    <input type="checkbox" id="showTime" name="showTime" checked={showTime} onChange={() => setShowTime(!showTime)} />
                    <label htmlFor="showTime" className='ml-2 select-none'>Time</label>
                </div>
            </div>
            <div className='grow basis-0 overflow-y-auto'>
                <table className='w-full text-lg'>
                    <thead>
                        <tr className='text-left'>
                            <th>Job ID</th>
                            <th>Change</th>
                            {/* {showBindings && <th>Bindings</th>}
                            {showTime && <th>Time</th>} */}
                        </tr>
                    </thead>
                    <tbody>
                        {queueLog.history.map((item, index) => (
                            <tr key={'queueJobHistory-' + index} className={index % 2 == 0 ? 'bg-slate-200' : ''}>
                                <td className='py-1'>{item.jobId}</td>
                                <td className='py-1'>{item.message}</td>
                                {/* {showBindings && (
                                    <td>
                                        <pre>{query.bindings ? JSON.stringify(query.bindings, null, 2) : ''}</pre>
                                    </td>
                                )}
                                {showTime && <td>{query.time}</td>} */}
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}
