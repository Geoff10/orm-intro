<?php

declare(strict_types=1);

namespace App\Workbooks\EloquentSelectData\Chapters;

use App\Workbooks\Chapter;

class SelectDataChapter extends Chapter
{
    public function id(): string
    {
        return 'selectData';
    }

    public function title(): string
    {
        return 'Select Data';
    }

    public function content(): array
    {
        return [
            [
                "type" => "h2",
                "content" => "Fetching all data",
            ],
            [
                "type" => "h3",
                "content" => "SQL",
            ],
            // [
            //     "type" => "p",
            //     "content" => "The SQL statement to fetch all data from a table is:",
            // ],
            [
                "type" => "runnableCodeBlock",
                "title" => "SQL: Select All",
                "text" => [
                    "\$query = \$this->db->prepare('SELECT * FROM books;');",
                    '$query->setFetchMode(PDO::FETCH_ASSOC);',
                    '$query->execute();',
                    '',
                    'return $query->fetchAll();',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'sqlSelectAll']),
            ],
            [
                "type" => "h3",
                "content" => "ORM",
            ],
            // [
            //     "type" => "p",
            //     "content" => "The ORM statement to fetch all data from a table is:",
            // ],
            [
                "type" => "runnableCodeBlock",
                "title" => "ORM: Select All",
                "text" => [
                    'return Book::get();',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'ormSelectAll']),
            ],
        ];
    }
}
