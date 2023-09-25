import { CodeBlock, dracula } from "react-code-blocks";

export default function RunnableCodeBlock({ className = '', title, text, previewCallback, children, ...props }) {
    let classes = [
        'inline-flex items-center px-4 py-2',
        'bg-green-600 dark:bg-gray-200',
        'border border-transparent rounded-br',
        'font-semibold text-xs text-white dark:text-gray-800',
        'uppercase tracking-widest',
        'hover:bg-green-700 dark:hover:bg-white',
        'focus:bg-green-700 dark:focus:bg-white',
        'active:bg-gray-900 dark:active:bg-gray-300',
        'focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800',
        'transition ease-in-out duration-150',
    ]
    return (
        <div className="border border-gray-400 rounded">
            <div className="bg-gray-800 font-mono">
                <CodeBlock
                    language='php'
                    showLineNumbers
                    theme={dracula}
                    wrapLines
                    text={text}
                    className='rounded-b-none'
                />
            </div>
            <div class="flex flex-row-reverse">
                <button
                    className={classes.join(' ') + className}
                    onClick={previewCallback}
                >Preview &gt;</button>
            </div>
        </div>
    );
}
