import { Link } from '@inertiajs/react';

export default function WorkbookNavigation({ workbook, previous_chapter, next_chapter }) {
    return (<div className="flex justify-between border-t border-gray-300 mt-2">
        <div className="basis-0 flex-grow text-left">
            {previous_chapter && (
                <Link
                    href={route('workbook', { workbook: workbook.id, chapter: previous_chapter.id })}
                    className="text-blue-500 hover:text-blue-700">
                    &lt; Back: {previous_chapter.title}
                </Link>
            )}
        </div>
        <div className="basis-0 flex-grow text-right">
            {next_chapter && (
                <Link
                    href={route('workbook', { workbook: workbook.id, chapter: next_chapter.id })}
                    className="text-blue-500 hover:text-blue-700">
                    Next: {next_chapter.title} &gt;
                </Link>
            )}
        </div>
    </div>)
}
