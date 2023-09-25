<?php

declare(strict_types=1);

namespace App\Workbooks\EloquentSelectData\Chapters;

use App\Workbooks\Chapter;

class SortingDataChapter extends Chapter
{
    public function id(): string
    {
        return 'sortingData';
    }

    public function title(): string
    {
        return 'Sorting Data';
    }

    public function content(): array
    {
        return [
            [
                "type" => "h2",
                "content" => "Sorting Data",
            ],
            [
                "type" => "h3",
                "content" => "SQL",
            ],
            // [
            //     "type" => "p",
            //     "content" => "The SQL statement to sort all data from a table is:",
            // ],
            [
                "type" => "runnableCodeBlock",
                "title" => "SQL: Sort Data",
                "text" => [
                    "\$query = \$this->db->prepare('SELECT * FROM books ORDER BY release_date;');",
                    '$query->setFetchMode(PDO::FETCH_ASSOC);',
                    '$query->execute();',
                    '',
                    'return $query->fetchAll();',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'sqlSortData']),
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
                "title" => "ORM: Sort Data",
                "text" => [
                    'return Book::orderBy("release_date")->get();',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'ormSortData']),
            ],
            [
                "type" => "h2",
                "content" => "Controlling the sort order",
            ],
            [
                "type" => "p",
                "content" => "By default, the sort order is ascending, but sometimes we want to sort in descending order.",
            ],
            [
                "type" => "h3",
                "content" => "SQL",
            ],
            [
                "type" => "runnableCodeBlock",
                "title" => "SQL",
                "text" => [
                    "\$query = \$this->db->prepare('SELECT * FROM books ORDER BY release_date DESC;');",
                    '$query->setFetchMode(PDO::FETCH_ASSOC);',
                    '$query->execute();',
                    '',
                    'return $query->fetchAll();',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'sqlSortDataDescending']),
            ],
            [
                "type" => "h3",
                "content" => "ORM",
            ],
            [
                "type" => "runnableCodeBlock",
                "title" => "ORM",
                "text" => [
                    'return Book::orderBy("release_date", "desc")->get();',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'ormSortDataDescending']),
            ]
        ];
    }
}
