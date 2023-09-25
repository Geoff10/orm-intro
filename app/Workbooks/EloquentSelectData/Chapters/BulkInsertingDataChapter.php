<?php

declare(strict_types=1);

namespace App\Workbooks\EloquentSelectData\Chapters;

use App\Workbooks\Chapter;

class BulkInsertingDataChapter extends Chapter
{
    public function id(): string
    {
        return 'bulkInsertingData';
    }

    public function title(): string
    {
        return 'Inserting Multiple Data Rows';
    }

    public function content(): array
    {
        return [
            [
                "type" => "h2",
                "content" => "Inserting Multiple Rows of Data",
            ],
            [
                "type" => "p",
                "content" => "Here is an array of data on multiple books that needs to be inserted into the database.",
            ],
            [
                "type" => "codeBlock",
                "text" => "\$books = [
    [
        'title' => 'New book',
        'author' => 1,
        'release_date' => date('Y-m-d'),
        'genre' => 'Non-fiction',
    ],
    [
        'title' => 'New SQL book',
        'author' => 2,
        'release_date' => date('Y-m-d'),
        'genre' => 'Non-fiction',
    ],
    [
        'title' => 'New ORM book',
        'author' => 3,
        'release_date' => date('Y-m-d'),
        'genre' => 'Non-fiction',
    ],
]",
            ],
            [
                "type" => "h3",
                "content" => "SQL",
            ],
            [
                "type" => "runnableCodeBlock",
                "title" => "SQL: Insert Multiple Data Rows",
                "text" => [
                    "\$query = \$this->db->prepare('INSERT INTO books (title, author, release_date, genre) VALUES (:title, :author, :release_date, :genre);');",
                    'foreach ($books as $book) {',
                    "\t\$query->execute(\$book);",
                    '}',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'sqlBulkInsertData']),
            ],
            [
                "type" => "h3",
                "content" => "ORM",
            ],
            [
                "type" => "runnableCodeBlock",
                "title" => "ORM: Insert Multiple Data Rows",
                "text" => [
                    'foreach ($books as $book) {',
                    "\tBook::create(\$book);",
                    '}',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'ormBulkInsertData']),
            ],
            // Todo: Add a another section on achieving this with one DB call
        ];
    }
}
