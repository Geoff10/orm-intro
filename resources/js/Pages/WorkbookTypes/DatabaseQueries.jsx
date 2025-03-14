import WorkbookLayout from '@/Layouts/WorkbookLayout';
import ContentRenderer from '@/Components/WorkbookContent/ContentRenderer';
import WorkbookNavigation from '@/Components/WorkbookContent/WorkbookNavigation';
import Inspector from '@/Components/Inspector/Inspector';
import { Head } from '@inertiajs/react';
import { useState, useRef } from 'react';
import axios from 'axios';

export default function SelectData({ workbook, chapter, previous_chapter, next_chapter }) {
    const previewPane = useRef(null);

    const [previewDisplayTitle, setPreviewDisplayTitle] = useState('');
    const [queryLog, setQueryLog] = useState([]);

    const loadPreviewDisplay = (url, title, options) => {
        axios.get(url, { params: options })
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
                <div className="bg-white dark:bg-gray-800 overflow-y-auto shadow-sm sm:rounded-lg grow basis-0 p-4">
                    <ContentRenderer content={chapter.content} loadPreviewDisplay={loadPreviewDisplay} />
                    <WorkbookNavigation workbook={workbook} previous_chapter={previous_chapter} next_chapter={next_chapter} />
                </div>

                <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg grow basis-0 flex flex-col">
                    <div className="border-b-2 border-gray-300 text-2xl font-bold py-2 px-4">
                        {previewDisplayTitle}
                    </div>
                    <iframe
                        ref={previewPane}
                        frameBorder="0"
                        className='w-full grow'
                    />
                    <Inspector queryLog={queryLog} />
                </div>
            </div>
        </WorkbookLayout>
    );
}
