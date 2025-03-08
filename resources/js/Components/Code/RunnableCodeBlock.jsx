import { useReducer } from "react";
import { CodeBlock, dracula } from "react-code-blocks";
import RunnableCodeBlockParameter from "./RunnableCodeBlockParameter";

export default function RunnableCodeBlock({ className = '', title, text, previewCallback, params, children, ...props }) {
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
    ];

    function optionsReducer(state, action) {
        switch (action.action) {
            case 'add':
                return { ...state, [action.id]: [...state[action.id], action.value] };
            case 'remove':
                return { ...state, [action.id]: state[action.id].filter((option) => option !== action.value) };
            case 'set':
                return { ...state, [action.id]: action.value };
        }
    }

    let initialOptions = {};
    if (params) {
        params.forEach((param) => {
            initialOptions[param.id] = param.default;
        });
    }

    const [options, updateOptions] = useReducer(optionsReducer, initialOptions);

    return (
        <div className="border border-gray-400 rounded">
            <div>
                {params && params.map((param) => {
                    return <RunnableCodeBlockParameter
                        key={param.id}
                        param={param}
                        options={options}
                        updateOptions={updateOptions}
                    />
                })}
            </div>
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
            <div className="flex flex-row-reverse">
                <button
                    className={classes.join(' ') + className}
                    onClick={() => previewCallback({ params: options })}
                >Preview &gt;</button>
            </div>
        </div>
    );
}
