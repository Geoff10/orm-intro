<?php

declare(strict_types=1);

namespace App\Workbooks\EloquentSelectData\Chapters;

use App\Models\Book;
use App\Workbooks\Chapter;

class BulkInsertingDataEfficientlyChapter extends Chapter
{
    public function id(): string
    {
        return 'bulkInsertingDataEfficiently';
    }

    public function title(): string
    {
        return 'Inserting Multiple Data Rows (More Efficiently)';
    }

    public function content(): array
    {
        return [
            [
                "type" => "h2",
                "content" => "Inserting Multiple Rows of Data (More Efficiently)",
            ],
            [
                "type" => "p",
                "content" => "Here is the same array of data on multiple books that needs to be inserted into the database.",
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
                "title" => "SQL: Insert Multiple Data Rows (More Efficiently)",
                "text" => [
                    '$placeholders = [];',
                    '$bookValues = [];',
                    '',
                    "foreach (\$books as \$book) {",
                    "\t\$placeholders[] = '(?, ?, ?, ?)';",
                    "\t\$bookValues[] = \$book['title'];",
                    "\t\$bookValues[] = \$book['author'];",
                    "\t\$bookValues[] = \$book['release_date'];",
                    "\t\$bookValues[] = \$book['genre'];",
                    "}",
                    '',
                    "\$query = \$pdo->prepare('INSERT INTO books (title, author, release_date, genre) VALUES ' . implode(', ', \$placeholders));",
                    "\$query->execute(\$bookValues);",
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'sqlBulkInsertDataEfficiently']),
            ],
            [
                "type" => "h3",
                "content" => "ORM",
            ],
            [
                "type" => "runnableCodeBlock",
                "title" => "ORM: Insert Multiple Data Rows (More Efficiently)",
                "text" => [
                    'Book::insert($books);'
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'ormBulkInsertDataEfficiently']),
            ],
            // Todo: Add a another section on achieving this with one DB call
        ];
    }
}
