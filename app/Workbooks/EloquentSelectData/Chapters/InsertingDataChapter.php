<?php

declare(strict_types=1);

namespace App\Workbooks\EloquentSelectData\Chapters;

use App\Workbooks\Chapter;

class InsertingDataChapter extends Chapter
{
    public function id(): string
    {
        return 'insertingData';
    }

    public function title(): string
    {
        return 'Inserting Data';
    }

    public function content(): array
    {
        return [
            [
                "type" => "h2",
                "content" => "Inserting Data",
            ],
            [
                "type" => "p",
                "content" => "Here is an array of data that needs to be inserted into the database.",
            ],
            [
                "type" => "codeBlock",
                "text" => "\$book = [
    'title' => 'New book',
    'author' => 1,
    'release_date' => date('Y-m-d'),
    'genre' => 'Non-fiction',
]",
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
                    "\$query = \$this->db->prepare('INSERT INTO books (title, author, release_date, genre) VALUES (:title, :author, :release_date, :genre);');",
                    '$query->execute($book);',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'sqlInsertData']),
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
                    'Book::create($book);',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'ormInsertData']),
            ],
            // Todo: Add a another section on getting the ID of the inserted record
        ];
    }
}
