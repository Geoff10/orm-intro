import WorkbookLayout from '@/Layouts/WorkbookLayout';
import InputLabel from '@/Components/InputLabel';
import Radio from '@/Components/Radio';
import { Head } from '@inertiajs/react';
import { useState } from 'react';
import { CodeBlock, dracula } from "react-code-blocks";

export default function SelectData({ }) {
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
            title: "SQL: Select All",
            previewUrl: route('example', {module, exercise: 'sqlSelectById'})
        },
        ormSelectById: {
            title: "ORM: Select All",
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

    const changePreviewDisplay = (e) => {
        const target = e.target;

        if (target) {
            if (previewDisplayConfig[target.value]) {
                setPreviewDisplay(target.value);
            }
        }
    }

    const [previewDisplay, setPreviewDisplay] = useState('sqlSelectAll')

    return (
        <WorkbookLayout
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>}
        >
            <Head title="Selecting Data" />

            <div className="flex justify-between h-full w-full gap-x-3">
                <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex-grow p-4">
                    <h1 className='text-2xl my-2'>Selecting Data</h1>
                    <h2 className='text-lg my-2'>Fetching all data</h2>
                    <h3 className='font-bold my-2'>SQL</h3>
                    <CodeBlock
                        language='php'
                        showLineNumbers
                        theme={dracula}
                        wrapLines
                        text={sqlSelectAll.join("\n")}
                    />

                    <h3 className='font-bold my-2'>ORM</h3>
                    <CodeBlock
                        language='php'
                        showLineNumbers
                        theme={dracula}
                        wrapLines
                        text={ormSelectAll.join("\n")}
                    />

                    <h3 className='font-bold my-2'>Preview</h3>
                    <InputLabel className='inline-block mr-6'>
                        <Radio
                            name="previewDisplayInput"
                            onChange={changePreviewDisplay}
                            value='sqlSelectAll'
                            checked={previewDisplay === 'sqlSelectAll' ? 'checked' : ''}
                        />
                        SQL
                    </InputLabel>
                    <InputLabel className='inline-block mr-6'>
                        <Radio
                            name="previewDisplayInput"
                            onChange={changePreviewDisplay}
                            value='ormSelectAll'
                            checked={previewDisplay === 'ormSelectAll' ? 'checked' : ''}
                        />
                        ORM
                    </InputLabel>

                    <div>
                        {previewDisplay}
                        <br />
                        {previewDisplayConfig[previewDisplay].previewUrl}
                    </div>
                </div>

                <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex-grow">
                    <div className="border-b-2 border-gray-300 text-2xl font-bold py-2 px-4">
                        {previewDisplayConfig[previewDisplay].title}
                    </div>
                    <div className="h-full">
                        <iframe
                            src={previewDisplayConfig[previewDisplay].previewUrl}
                            frameborder="0"
                            className='w-full h-full'
                        />
                    </div>
                </div>
            </div>

            {/* <div className="p-6 text-gray-900 dark:text-gray-100">You're not logged in!</div> */}
        </WorkbookLayout>
    );
}
