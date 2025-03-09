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
        let history = state.history;

        const index = jobs.findIndex((item) => item.jobId === job.jobId);

        let historyItem = {
            jobId: job.jobId,
            timestamp: new Date().toISOString(),
            newStatus: job.status,
        }

        if (index !== -1) {
            historyItem.oldStatus = jobs[index].status;
            historyItem.message = job.status === 'queued' ?
                'Job has been put back in the queue' :
                `Job status changed to ${job.status}`;

            jobs[index] = job;
        } else {
            historyItem.oldStatus = null;
            historyItem.message = 'Job has been added to the queue';

            jobs.push(job);
        }

        if (historyItem.newStatus !== historyItem.oldStatus) {
            history.push(historyItem);
        }

        return { ...state, jobs, history };
    }

    const [queueLog, setQueueLog] = useReducer(queueLogReducer, { jobs: [], history: [] });

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
                    <Inspector queueLog={queueLog} />
                </div>
            </div>
        </WorkbookLayout>
    );
}
