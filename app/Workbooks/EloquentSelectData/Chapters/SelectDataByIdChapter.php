<?php

declare(strict_types=1);

namespace App\Workbooks\EloquentSelectData\Chapters;

use App\Workbooks\Chapter;

class SelectDataByIdChapter extends Chapter
{
    public function id(): string
    {
        return 'selectDataById';
    }

    public function title(): string
    {
        return 'Select Data By ID';
    }

    public function content(): array
    {
        return [
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
                "title" => "SQL: Select By ID",
                "text" => [
                    "\$query = \$this->db->prepare('SELECT * FROM books WHERE `id` = :id');",
                    '$query->setFetchMode(PDO::FETCH_ASSOC);',
                    "\$query->execute(['id' => \$id]);",
                    '',
                    'return $query->fetch();',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'sqlSelectById']),
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
                "title" => "ORM: Select By ID",
                "text" => [
                    'return Book::find(1);',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'ormSelectById']),
            ],
            [
                "type" => "h2",
                "content" => "Find a record by ID or fail",
            ],
            [
                "type" => "h3",
                "content" => "SQL",
            ],
            [
                "type" => "p",
                "content" => "The SQL statement to fetch a record by ID from a table, and fail if it doesn't exist, is:",
            ],
            [
                "type" => "runnableCodeBlock",
                "title" => "SQL: Select By ID or Fail",
                "text" => [
                    "\$query = \$this->db->prepare('SELECT * FROM books WHERE `id` = :id');",
                    '$query->setFetchMode(PDO::FETCH_ASSOC);',
                    "\$query->execute(['id' => \$id]);",
                    '',
                    '$result = $query->fetch();',
                    '',
                    'if (!$result) {',
                    '    throw new ModelNotFoundException("Id not found");',
                    '}',
                    '',
                    'return $result;',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'sqlSelectByIdOrFail']),
            ],
            [
                "type" => "h3",
                "content" => "ORM",
            ],
            [
                "type" => "p",
                "content" => "The ORM statement to fetch a record by ID from a table, and fail if it doesn't exist, is:",
            ],
            [
                "type" => "runnableCodeBlock",
                "title" => "ORM: Select By ID or Fail",
                "text" => [
                    'return Book::findOrFail(1);',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'ormSelectByIdOrFail']),
            ],
        ];
    }
}
