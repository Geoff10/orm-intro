import { useState } from "react";

export default function DatabaseQueries({ queryLog }) {
    const [showBindings, setShowBindings] = useState(false);

    return (
        <div>
            <div className='border-t border-b border-gray-500 py-2 flex justify-between'>
                Queries Executed: {queryLog.length}
                {/* <span>
                    <input type="checkbox" id="showBindings" name="showBindings" checked={showBindings} onChange={() => setShowBindings(!showBindings)} />
                    <label htmlFor="showBindings" className='ml-2'>Show Bindings</label>
                </span> */}
            </div>
            <div className='grow overflow-y-auto'>
                <table className='w-full text-lg mb-4'>
                    <thead>
                        <tr className='text-left'>
                            <th>Query</th>
                            {showBindings && <th>Bindings</th>}
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        {queryLog.map((query, index) => (
                            <tr key={index} className={index % 2 == 0 ? 'bg-slate-200' : ''}>
                                <td className='py-1'>{query.sql}</td>
                                {showBindings && (
                                    <td>
                                        <pre>{query.bindings ? JSON.stringify(query.bindings, null, 2) : ''}</pre>
                                    </td>
                                )}
                                <td>{query.time}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </div>
    )
}
