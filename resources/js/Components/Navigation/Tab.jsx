export default function Tab({ title, active, onClick }) {
    const baseClasses = 'px-4 py-2 font-semibold text-xs uppercase tracking-widest ' +
        'dark:text-gray-100 ' +
        'hover:text-blue-700 hover:border-b-2 hover:border-blue-700 ' +
        'dark:hover:text-blue-500 dark:hover:border-b-2 dark:hover:border-blue-500 ';

    const activeClasses = 'border-b-2 border-blue-500 text-blue-500 ' +
        'dark:text-blue-300 dark:border-blue-300';

    return (
        <button
            className={`${baseClasses} ${active && activeClasses}`}
            onClick={onClick}>
            {title}
        </button>
    );
}
