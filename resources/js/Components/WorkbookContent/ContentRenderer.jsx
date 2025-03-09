import RunnableCodeBlock from '@/Components/Code/RunnableCodeBlock';
import { CodeBlock, dracula } from "react-code-blocks";

export default function ContentRenderer({ content, loadPreviewDisplay }) {
    return (
        <>
            {content.map((item, index) => {
                switch (item.type) {
                    case 'h1':
                        return <h1 key={index} className='text-3xl my-2'>{item.content}</h1>
                    case 'h2':
                        return <h2 key={index} className='text-2xl my-2'>{item.content}</h2>
                    case 'h3':
                        return <h3 key={index} className='font-bold text-lg my-2'>{item.content}</h3>
                    case 'p':
                        return <p key={index} className='my-2'>{item.content}</p>
                    case 'runnableCodeBlock':
                        return <RunnableCodeBlock
                            key={index}
                            text={item.text.join("\n")}
                            params={item.params}
                            previewCallback={(options) => loadPreviewDisplay(item.route, item.title, options)} />
                    case 'codeBlock':
                        return <div className="font-mono" key={index}>
                            <CodeBlock
                                language='php'
                                showLineNumbers
                                theme={dracula}
                                wrapLines
                                text={item.text}
                                className='rounded-b-none'
                            />
                        </div>
                    default:
                        return <p key={index} className='my-2'>{item.content}</p>
                }
            })}
        </>
    );
}
