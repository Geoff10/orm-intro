import WorkbookLayout from '@/Layouts/WorkbookLayout';
import RunnableCodeBlock from '@/Components/Code/RunnableCodeBlock';
import { Head } from '@inertiajs/react';
import { useState, useRef } from 'react';
import axios from 'axios';

export default function SelectData({ }) {
    const previewPane = useRef(null);
    const module = 'sqlSelectData';

    const previewDisplayConfig = {
        sqlSelectAll: {
            title: "SQL: Select All",
            previewUrl: route('example', {module, exercise: 'sqlSelectAll'})
        },
        ormSelectAll: {
            title: "ORM: Select All",
            previewUrl: route('example', {module, exercise: 'ormSelectAll'})
        },
        sqlSelectById: {
            title: "SQL: Select By ID",
            previewUrl: route('example', {module, exercise: 'sqlSelectById'})
        },
        ormSelectById: {
            title: "ORM: Select By ID",
            previewUrl: route('example', {module, exercise: 'ormSelectById'})
        },
    };

    const sqlSelectAll = [
        "$query = $this->db->prepare('SELECT * FROM species;');",
        '$query->setFetchMode(PDO::FETCH_ASSOC);',
        '$query->execute();',
        '',
        'return $query->fetchAll();',
    ];

    const ormSelectAll = [
        'return Species::get()->toArray();',
    ];

    const sqlSelectById = [
        "$query = $this->db->prepare('SELECT * FROM species WHERE `id` = :id');",
        '$query->setFetchMode(PDO::FETCH_ASSOC);',
        "$query->execute(['id' => $id]);",
        '',
        'return $query->fetch();',
    ];

    const ormSelectById = [
        'return Species::get()->toArray();',
    ];

    const changePreviewDisplay = (value) => {
        if (previewDisplayConfig[value]) {
            let config = previewDisplayConfig[value];

            axios.get(config.previewUrl)
                .then((response) => response.data)
                .then((data) => {
                    // console.log(data);
                    previewPane.current.contentWindow.document.open();
                    previewPane.current.contentWindow.document.write(data.results);
                    previewPane.current.contentWindow.document.close();

                    const queries = data.queries ?? [];
                    setQueryLog(queries);
                })

            setPreviewDisplay(value);
        }
    }

    const [previewDisplay, setPreviewDisplay] = useState('sqlSelectAll')
    let [queryLog, setQueryLog] = useState([]);

    return (
        <WorkbookLayout
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>}
        >
            <Head title="Selecting Data" />

            <div className="flex justify-between h-full w-full gap-x-3">
                <div className="bg-white dark:bg-gray-800 overflow-y-auto shadow-sm sm:rounded-lg flex-grow basis-0 p-4">
                    <h1 className='text-2xl my-2'>Selecting Data</h1>
                    <h2 className='text-lg my-2'>Fetching all data</h2>
                    <h3 className='font-bold my-2'>SQL</h3>
                    <RunnableCodeBlock
                        title='SQL'
                        text={sqlSelectAll.join("\n")}
                        previewCallback={() => changePreviewDisplay('sqlSelectAll')}
                    />

                    <h3 className='font-bold my-2'>ORM</h3>
                    <RunnableCodeBlock
                        title='SQL'
                        text={ormSelectAll.join("\n")}
                        previewCallback={() => changePreviewDisplay('ormSelectAll')}
                    />

                    <h2 className='text-lg my-2'>Find a record by ID</h2>
                    <h3 className='font-bold my-2'>SQL</h3>
                    <RunnableCodeBlock
                        title='SQL'
                        text={sqlSelectById.join("\n")}
                        previewCallback={() => changePreviewDisplay('sqlSelectById')}
                    />

                    <h3 className='font-bold my-2'>ORM</h3>
                    <RunnableCodeBlock
                        title='SQL'
                        text={ormSelectById.join("\n")}
                        previewCallback={() => changePreviewDisplay('ormSelectById')}
                    />

                </div>

                <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex-grow basis-0">
                    <div className="border-b-2 border-gray-300 text-2xl font-bold py-2 px-4">
                        {previewDisplayConfig[previewDisplay].title}
                    </div>
                    <div className="h-full flex flex-col">
                        <iframe
                            // src={previewDisplayConfig[previewDisplay].previewUrl}
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

            {/* <div className="p-6 text-gray-900 dark:text-gray-100">You're not logged in!</div> */}
        </WorkbookLayout>
    );
}
