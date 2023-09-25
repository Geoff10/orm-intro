<?php

declare(strict_types=1);

namespace App\Workbooks\EloquentSelectData\Chapters;

use App\Workbooks\Chapter;

class FilteringDataChapter extends Chapter
{
    public function id(): string
    {
        return 'filteringData';
    }

    public function title(): string
    {
        return 'Filtering Records';
    }

    public function content(): array
    {
        return [
            [
                "type" => "h2",
                "content" => "Filtering Data",
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
                "title" => "SQL: Filter Data",
                "text" => [
                    "\$query = \$this->db->prepare('SELECT * FROM books WHERE release_date < \"1955-01-01\" AND genre = \"Fantasy\";');",
                    '$query->setFetchMode(PDO::FETCH_ASSOC);',
                    '$query->execute();',
                    '',
                    'return $query->fetchAll();',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'sqlFilterData']),
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
                "title" => "ORM: Filter Data",
                "text" => [
                    'return Book::where("release_date", "<", "1955-01-01")',
                    "\t->where(\"genre\", \"Fantasy\")",
                    "\t->get();",
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'ormFilterData']),
            ],
        ];
    }
}
