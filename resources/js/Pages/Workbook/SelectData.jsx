import WorkbookLayout from '@/Layouts/WorkbookLayout';
import RunnableCodeBlock from '@/Components/Code/RunnableCodeBlock';
import { Head } from '@inertiajs/react';
import { useState, useRef } from 'react';
import axios from 'axios';

export default function SelectData({ }) {
    const previewPane = useRef(null);

    const module = 'sqlSelectData';
    const workbookContent = [
        {
            type: 'h1',
            content: 'Selecting Data',
        },
        {
            type: 'h2',
            content: 'Fetching all data',
        },
        {
            type: 'h3',
            content: 'SQL',
        },
        {
            type: 'runnableCodeBlock',
            title: 'SQL: Select All',
            text: [
                "$query = $this->db->prepare('SELECT * FROM species;');",
                '$query->setFetchMode(PDO::FETCH_ASSOC);',
                '$query->execute();',
                '',
                'return $query->fetchAll();',
            ],
            route: route('example', {module, exercise: 'sqlSelectAll'}),
        },
        {
            type: 'h3',
            content: 'ORM',
        },
        {
            type: 'runnableCodeBlock',
            title: 'ORM: Select All',
            text: [
                'return Species::get();',
            ],
            route: route('example', {module, exercise: 'ormSelectAll'}),
        },
        {
            type: 'h2',
            content: 'Find a record by ID',
        },
        {
            type: 'h3',
            content: 'SQL',
        },
        {
            type: 'runnableCodeBlock',
            title: 'SQL: Select By ID',
            text: [
                "$query = $this->db->prepare('SELECT * FROM species WHERE `id` = :id');",
                '$query->setFetchMode(PDO::FETCH_ASSOC);',
                "$query->execute(['id' => $id]);",
                '',
                'return $query->fetch();',
            ],
            route: route('example', {module, exercise: 'sqlSelectById'}),
        },
        {
            type: 'h3',
            content: 'ORM',
        },
        {
            type: 'runnableCodeBlock',
            title: 'ORM: Select By ID',
            text: [
                'return Book::find(1);',
            ],
            route: route('example', {module, exercise: 'ormSelectById'}),
        },
    ];

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

    const [previewDisplayTitle, setPreviewDisplayTitle] = useState('SQL: Select All')
    const [queryLog, setQueryLog] = useState([]);

    return (
        <WorkbookLayout
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>}
        >
            <Head title="Selecting Data" />

            <div className="flex justify-between h-full w-full gap-x-3">
                <div className="bg-white dark:bg-gray-800 overflow-y-auto shadow-sm sm:rounded-lg flex-grow basis-0 p-4">
                    {workbookContent.map((item, index) => {
                        switch (item.type) {
                            case 'h1':
                                return <h1 key={index} className='text-2xl my-2'>{item.content}</h1>
                            case 'h2':
                                return <h2 key={index} className='text-lg my-2'>{item.content}</h2>
                            case 'h3':
                                return <h3 key={index} className='font-bold my-2'>{item.content}</h3>
                            case 'p':
                                return <p key={index} className='my-2'>{item.content}</p>
                            case 'runnableCodeBlock':
                                return <RunnableCodeBlock
                                    key={index}
                                    text={item.text.join("\n")}
                                    previewCallback={() => loadPreviewDisplay(item.route, item.title)}
                                />
                            default:
                                return <p key={index} className='my-2'>{item.content}</p>
                        }
                    })}
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
