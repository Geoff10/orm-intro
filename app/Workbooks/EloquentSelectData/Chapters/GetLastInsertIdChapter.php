<?php

declare(strict_types=1);

namespace App\Workbooks\EloquentSelectData\Chapters;

use App\Workbooks\Chapter;

class GetLastInsertIdChapter extends Chapter
{
    public function id(): string
    {
        return 'getLadstInsertId';
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
                "content" => "Inserting Data: Get Last Insert ID",
            ],
            [
                "type" => "p",
                "content" => "Sometimes you need to get the ID of the last inserted record. This is useful if you need to insert a record into another table that has a foreign key to the first table.",
            ],
            [
                "type" => "p",
                "content" => "Here is the data that needs to be inserted into the database.",
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
                "title" => "SQL: Insert Data and Get Last Insert ID",
                "text" => [
                    "\$query = \$this->db->prepare('INSERT INTO books (title, author_id, release_date, genre) VALUES (:title, :author_id, :release_date, :genre);');",
                    '$query->execute($book);',
                    '',
                    'return $this->db->lastInsertId();',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'sqlInsertDataGetLastInsertId']),
            ],
            [
                "type" => "h3",
                "content" => "ORM",
            ],
            [
                "type" => "runnableCodeBlock",
                "title" => "ORM: Insert Data and Get Last Insert ID",
                "text" => [
                    'return Book::create($book);',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'ormInsertDataGetLastInsertId']),
            ],
            [
                "type" => "h3",
                "content" => "SQL: Get Last Inserted Record",
            ],
            [
                "type" => "runnableCodeBlock",
                "title" => "SQL: Insert Data and Get Last Inserted Record",
                "text" => [
                    "\$query = \$this->db->prepare('INSERT INTO books (title, author_id, release_date, genre) VALUES (:title, :author_id, :release_date, :genre);');",
                    '$query->execute($book);',
                    '',
                    '$lastInsertId = $this->db->lastInsertId();',
                    '',
                    "\$query = \$this->db->prepare('SELECT * FROM books WHERE id = :id');",
                    '$query->setFetchMode(PDO::FETCH_ASSOC);',
                    "\$query->execute(['id' => \$lastInsertId]);",
                    '',
                    'return $query->fetch();',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'sqlInsertDataGetLastInsertRecord']),
            ],
        ];
    }
}
