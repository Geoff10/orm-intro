import WorkbookLayout from '@/Layouts/WorkbookLayout';
import ContentRenderer from '@/Components/WorkbookContent/ContentRenderer';
import WorkbookNavigation from '@/Components/WorkbookContent/WorkbookNavigation';
import Inspector from '@/Components/Inspector/Inspector';
import { Head } from '@inertiajs/react';
import { useEffect, useReducer } from 'react';
import axios from 'axios';

export default function SelectData({ workbook, chapter, previous_chapter, next_chapter, uniqueSessionId }) {
    const queueLogReducer = (state, job) => {
        let jobs = state.jobs;

        const index = jobs.findIndex((item) => item.jobId === job.jobId);

        if (index !== -1) {
            let jobMessage = job.status === 'queued' ?
                'Job has been put back in the queue' :
                `Job status changed to ${job.status}`;

            jobs[index].history.push({
                timestamp: new Date().toISOString(),
                status: job.status,
                oldStatus: jobs[index].status,
                message: job.message ?? jobMessage,
            });
            jobs[index].status = job.status;
        } else {
            jobs = [{
                jobId: job.jobId,
                name: job.name,
                status: job.status,
                history: [
                    {
                        timestamp: new Date().toISOString(),
                        status: job.status,
                        oldStatus: null,
                        message: 'Job has been added to the queue',
                    }
                ]
            }, ...jobs];
        }

        return { ...state, jobs };
    }

    const [queueLog, setQueueLog] = useReducer(queueLogReducer, { jobs: [] });

    const loadPreviewDisplay = (url, title, options) => {
        axios.get(url, { params: options });
    }

    useEffect(() => {
        Echo.channel(`session.${uniqueSessionId}`)
            .listen('.JobStatusChanged', (job) => {
                setQueueLog(job);
            });
    }, []);

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
                    <Inspector queueLog={queueLog} fullHeight={true} />
                </div>
            </div>
        </WorkbookLayout>
    );
}
