<?php

declare(strict_types=1);

namespace App\Workbooks\EloquentSelectData\Chapters;

use App\Workbooks\Chapter;

class ConditionallyFilteringDataChapter extends Chapter
{
    public function id(): string
    {
        return 'conditionallyFilteringData';
    }

    public function title(): string
    {
        return 'Conditionally Filtering Records';
    }

    public function content(): array
    {
        return [
            [
                "type" => "h2",
                "content" => "Conditionally Filtering Data",
            ],
            [
                "type" => "p",
                "content" => "Often, we don't know what data we want to filter on until the user has submitted a form.
                For example, we might have a form with a number of filters that the user can select from. We can then
                use these filters to filter the data that we fetch from the database.",
            ],
            [
                "type" => "codeBlock",
                "text" => "\$filters = [
    'release_date' => '2020-01-01',
    'genre' => 'Fantasy',
]",
            ],
            [
                "type" => "h3",
                "content" => "SQL",
            ],
            [
                "type" => "runnableCodeBlock",
                "title" => "SQL: Filter Data",
                "text" => [
                    "\$parameters = [];",
                    "\$sql = 'SELECT * FROM books WHERE'",
                    '',
                    "if (isset(\$filters['release_date'])) {",
                    "\t\$sql .= ' release_date < :release_date AND';",
                    "\t\$parameters['release_date'] = \$filters['release_date'];",
                    "}",
                    '',
                    "if (isset(\$filters['genre'])) {",
                    "\t\$sql .= ' genre = :genre AND';",
                    "\t\$parameters['genre'] = \$filters['genre'];",
                    "}",
                    '',
                    "\$sql = rtrim(\$sql, ' AND');",
                    '',
                    "\$query = \$this->db->prepare(\$sql);",
                    '$query->setFetchMode(PDO::FETCH_ASSOC);',
                    '$query->execute($parameters);',
                    '',
                    'return $query->fetchAll();',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'sqlFilterDataConditional']),
            ],
            [
                "type" => "h3",
                "content" => "ORM",
            ],
            [
                "type" => "runnableCodeBlock",
                "title" => "ORM: Filter Data",
                "text" => [
                    '$query = Book::query();',
                    'if (isset($filters[\'release_date\'])) {',
                    "\t\$query->where('release_date', '<', \$filters['release_date']);",
                    '}',
                    'if (isset($filters[\'genre\'])) {',
                    "\t\$query->where('genre', \$filters['genre']);",
                    '}',
                    'return $query->get();',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'ormFilterDataConditional']),
            ],
        ];
    }
}
