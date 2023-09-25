import WorkbookLayout from '@/Layouts/WorkbookLayout';
import RunnableCodeBlock from '@/Components/Code/RunnableCodeBlock';
import { Head } from '@inertiajs/react';
import { useState, useRef } from 'react';
import { CodeBlock, dracula } from "react-code-blocks";
import axios from 'axios';

export default function SelectData({ workbook, chapter, previous_chapter, next_chapter }) {
    const previewPane = useRef(null);

    const [previewDisplayTitle, setPreviewDisplayTitle] = useState('');
    const [queryLog, setQueryLog] = useState([]);

    const loadPreviewDisplay = (url, title) => {
        axios.get(url)
            .then((response) => response.data)
            .then((data) => {
                previewPane.current.contentWindow.document.open();
                previewPane.current.contentWindow.document.write(data.results);
                previewPane.current.contentWindow.document.close();

                const queries = data.queries ?? [];
                setQueryLog(queries);
            });

        setPreviewDisplayTitle(title);
    }

    return (
        <WorkbookLayout
            title={chapter.title}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>}
        >
            <Head title={chapter.title} />

            <div className="flex justify-between h-full w-full gap-x-3">
                <div className="bg-white dark:bg-gray-800 overflow-y-auto shadow-sm sm:rounded-lg flex-grow basis-0 p-4">
                    {console.log(chapter.content)}
                    {chapter.content.map((item, index) => {
                        switch (item.type) {
                            case 'h1':
                                return <h1 key={index} className='text-3xl my-2'>{item.content}</h1>
                            case 'h2':
                                return <h2 key={index} className='text-2xl my-2'>{item.content}</h2>
                            case 'h3':
                                return <h3 key={index} className='font-bold text-lg my-2'>{item.content}</h3>
                            case 'p':
                                return <p key={index} className='my-2'>{item.content}</p>
                            case 'runnableCodeBlock':
                                return <RunnableCodeBlock
                                    key={index}
                                    text={item.text.join("\n")}
                                    previewCallback={() => loadPreviewDisplay(item.route, item.title)}
                                />
                            case 'codeBlock':
                                return <div className="font-mono" key={index}>
                                    <CodeBlock
                                        language='php'
                                        showLineNumbers
                                        theme={dracula}
                                        wrapLines
                                        text={item.text}
                                        className='rounded-b-none'
                                    />
                                </div>
                            default:
                                return <p key={index} className='my-2'>{item.content}</p>
                        }
                    })}
                    <div class="flex justify-between border-t border-gray-300 mt-2">
                        <div class="basis-0 flex-grow text-left">
                            {previous_chapter && (
                                <a
                                    href={route('workbook', {workbook: workbook.id, chapter: previous_chapter.id})}
                                    className="text-blue-500 hover:text-blue-700">
                                        &lt; Back: { previous_chapter.title }
                                </a>
                            )}
                        </div>
                        <div class="basis-0 flex-grow text-right">
                            {next_chapter && (
                                <a
                                    href={route('workbook', {workbook: workbook.id, chapter: next_chapter.id})}
                                    className="text-blue-500 hover:text-blue-700">
                                        Next: { next_chapter.title } &gt;
                                </a>
                            )}
                        </div>
                    </div>
                </div>

                <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex-grow basis-0">
                    <div className="border-b-2 border-gray-300 text-2xl font-bold py-2 px-4">
                        {previewDisplayTitle}
                    </div>
                    <div className="h-full flex flex-col">
                        <iframe
                            ref={previewPane}
                            frameborder="0"
                            className='w-full flex-grow'
                        />
                        <div className="h-12 w-full grow">
                            <div className='border-t border-b border-gray-500 py-2'>
                                Queries Executed: {queryLog.length}
                            </div>
                            <table className='w-full'>
                                <thead>
                                    <tr className='text-left'>
                                        <th>Query</th>
                                        <th>Bindings</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {queryLog.map((query, index) => (
                                        <tr key={index}>
                                            <td>{query.query}</td>
                                            <td>{query.bindings ? JSON.stringify(query.bindings) : ''}</td>
                                            <td>{query.time}</td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </WorkbookLayout>
    );
}
