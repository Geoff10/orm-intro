export default function RunnableCodeBlockParameter({ param, options, updateOptions }) {
    const optionId = Math.random().toString(36).substring(2, 15);
    switch (param.type) {
        case 'checkbox':
            return <div key={param.id}>
                <div>{param.label}</div>
                {param.options.map((option, optionIndex) => {
                    return <div key={optionIndex} className="inline-block">
                        <input
                            type="checkbox"
                            id={param.id + '-' + option}
                            name={param.id}
                            checked={options[param.id].includes(option)}
                            onChange={(e) => updateOptions({ id: param.id, action: e.target.checked ? 'add' : 'remove', value: option })}
                        />
                        <label htmlFor={param.id + '-' + option} className='ml-1 mr-4'>{option}</label>
                    </div>
                })}
            </div>;
        case 'select':
            return <div key={param.id} className={param.id}>
                <label className="block" htmlFor={param.id + '-' + optionId}>{param.label}</label>
                <select
                    id={param.id + '-' + optionId}
                    name={param.id}
                    value={options[param.id]}
                    onChange={(e) => updateOptions({ id: param.id, action: 'set', value: e.target.value })}
                >
                    {param.options.map((option, optionIndex) => {
                        return <option key={optionIndex} value={option}>{option}</option>
                    })}
                </select>
            </div>;
    }
}
