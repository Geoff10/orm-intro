import DatabaseQueries from "./DatabaseQueries";

export default function Inspector({ queryLog }) {
    return (
        <div className="h-24 w-full grow flex flex-col">
            <div>
                <button>Query</button>
            </div>
            <DatabaseQueries queryLog={queryLog} />
        </div>
    )
}
