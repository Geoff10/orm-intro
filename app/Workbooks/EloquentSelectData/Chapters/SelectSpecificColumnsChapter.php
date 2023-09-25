<?php

declare(strict_types=1);

namespace App\Workbooks\EloquentSelectData\Chapters;

use App\Workbooks\Chapter;

class SelectSpecificColumnsChapter extends Chapter
{
    public function id(): string
    {
        return 'selectSpecificColumns';
    }

    public function title(): string
    {
        return 'Select Data With Specific Columns';
    }

    public function content(): array
    {
        return [
            [
                "type" => "h1",
                "content" => "Selecting Data By ID"
            ],
            [
                "type" => "h2",
                "content" => "Find a record by ID",
            ],
            [
                "type" => "h3",
                "content" => "SQL",
            ],
            [
                "type" => "p",
                "content" => "The SQL statement to fetch a record by ID from a table is:",
            ],
            [
                "type" => "runnableCodeBlock",
                "title" => "SQL: Choose Columns to Select",
                "text" => [
                    "\$query = \$this->db->prepare('SELECT title, genre, release_date FROM species;');",
                    '$query->setFetchMode(PDO::FETCH_ASSOC);',
                    '$query->execute();',
                    '',
                    'return $query->fetchAll();',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'sqlSelectChooseColumns']),
            ],
            [
                "type" => "h3",
                "content" => "ORM",
            ],
            [
                "type" => "p",
                "content" => "The ORM statement to fetch a record by ID from a table is:",
            ],
            [
                "type" => "runnableCodeBlock",
                "title" => "ORM: Choose Columns to Select",
                "text" => [
                    'return Book::select("title", "genre", "release_date")->get();',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'ormSelectChooseColumns']),
            ],
        ];
    }
}
