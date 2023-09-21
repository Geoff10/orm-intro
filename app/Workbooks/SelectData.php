<?php

declare(strict_types=1);

namespace App\Workbooks;

class SelectData extends Workbook
{
    public function title(): string
    {
        return 'Select Data';
    }

    public function content(): array
    {
        return [
            [
                "type" => "h1",
                "content" => "Selecting Data"
            ],
            [
                "type" => "h2",
                "content" => "Fetching all data",
            ],
            [
                "type" => "h3",
                "content" => "SQL",
            ],
            [
                "type" => "p",
                "content" => "The SQL statement to fetch all data from a table is:",
            ],
            [
                "type" => "runnableCodeBlock",
                "title" => "SQL: Select All",
                "text" => [
                    "\$query = \$this->db->prepare('SELECT * FROM species;');",
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
            [
                "type" => "p",
                "content" => "The ORM statement to fetch all data from a table is:",
            ],
            [
                "type" => "runnableCodeBlock",
                "title" => "ORM: Select All",
                "text" => [
                    'return Book::get();',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'ormSelectAll']),
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
                "title" => "SQL: Select By ID",
                "text" => [
                    "\$query = \$this->db->prepare('SELECT * FROM species WHERE `id` = :id');",
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
            // TODO: Add a button to go to the next workbook
        ];
    }
}
