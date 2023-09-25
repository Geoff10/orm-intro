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
    'author_id' => 1,
    'release_date' => date('Y-m-d'),
    'genre' => 'Non-fiction',
]",
            ],
            [
                "type" => "h3",
                "content" => "SQL",
            ],
            [
                "type" => "runnableCodeBlock",
                "title" => "SQL: Insert Data",
                "text" => [
                    "\$query = \$this->db->prepare('INSERT INTO books (title, author_id, release_date, genre) VALUES (:title, :author_id, :release_date, :genre);');",
                    '$query->execute($book);',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'sqlInsertData']),
            ],
            [
                "type" => "h3",
                "content" => "ORM",
            ],
            [
                "type" => "runnableCodeBlock",
                "title" => "ORM: Insert Data",
                "text" => [
                    'Book::create($book);',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'ormInsertData']),
            ],
        ];
    }
}
