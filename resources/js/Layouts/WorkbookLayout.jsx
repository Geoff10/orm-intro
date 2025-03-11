import NavLink from '@/Components/NavLink';

export default function Workbook({ title, children }) {
    return (
        <div className="h-screen w-screen flex flex-col">
            <nav className="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
                <div className="mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between items-center h-16">
                        <div className="space-x-8 sm:-my-px sm:ml-10 flex text-xl">
                            {title ?? 'Workbook'}
                        </div>
                        <div className="flex">
                            <div className="space-x-8 sm:-my-px sm:ml-10 flex">
                                <NavLink href={route('workbook', { workbook: 'eloquentSelectData', chapter: 'selectData' })}>
                                    Eloquent
                                </NavLink>
                                <NavLink href={route('workbook', { workbook: 'queuingJobs', chapter: 'whyWeQueue' })}>
                                    Queues
                                </NavLink>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            {/* <div className="min-h-screen flex sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
                {children}
            </div> */}
            <div className="bg-gray-100 dark:bg-gray-900 p-1 flex-grow overflow-y-auto">
                {children}
            </div>
        </div>
    );
}
