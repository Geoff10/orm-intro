<?php

declare(strict_types=1);

namespace App\Workbooks\EloquentSelectData\Chapters;

use App\Models\Book;
use App\Workbooks\Chapter;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

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
        $selectableIds = Book::pluck('id')->toArray();

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
                "params" => [
                    [
                        "type" => "select",
                        "label" => "Select the ID of the book to fetch.",
                        "id" => "id",
                        "options" => $selectableIds,
                        "default" => 1,
                    ],
                ],
                "text" => [
                    "\$query = \$this->db->prepare('SELECT * FROM books WHERE `id` = :id');",
                    '$query->setFetchMode(PDO::FETCH_ASSOC);',
                    "\$query->execute(['id' => 1]);",
                    '',
                    'return $query->fetch();',
                ],
                "code" => function () use ($selectableIds): array {
                    $params = func_get_args()[0] ?? [];

                    $id = $params['id'] ?? 1;

                    if ((int) $id == $id) {
                        $id = (int) $id;
                    }

                    if (!is_int($id) || !in_array($id, $selectableIds)) {
                        $id = 1;
                    }

                    $data = DB::select('SELECT * FROM books WHERE id = ?', [$id]);

                    return [
                        'properties' => [
                            'Method' => 'SQL',
                        ],
                        'table' => [
                            'headers' => array_keys((array) $data[0]),
                            'rows' => $data,
                        ],
                    ];
                },
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
                "params" => [
                    [
                        "type" => "select",
                        "label" => "Select the ID of the book to fetch.",
                        "id" => "ormId",
                        "options" => $selectableIds,
                        "default" => 1,
                    ],
                ],
                "code" => function () use ($selectableIds): array {
                    $params = func_get_args()[0] ?? [];

                    $id = $params['ormId'] ?? 1;

                    if ((int) $id == $id) {
                        $id = (int) $id;
                    }

                    if (!is_int($id) || !in_array($id, $selectableIds)) {
                        $id = 1;
                    }

                    $data = Book::find($id);

                    return [
                        'properties' => [
                            'Method' => 'SQL',
                        ],
                        'table' => [
                            'headers' => array_keys($data->toArray()),
                            'rows' => [$data->toArray()],
                        ],
                    ];
                },
                // "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'ormSelectById']),
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
                    "\$query->execute(['id' => -1]);",
                    '',
                    '$result = $query->fetch();',
                    '',
                    'if (!$result) {',
                    '    throw new ModelNotFoundException("Id not found");',
                    '}',
                    '',
                    'return $result;',
                ],
                "code" => function (): array {
                    $params = func_get_args();
                    if (count($params) === 0) {
                        return [];
                    }

                    $result = DB::select('SELECT * FROM books WHERE id = ?', [-1]);

                    if (!$result) {
                        throw new ModelNotFoundException('Id not found');
                    }

                    return [
                        'properties' => [
                            'Method' => 'SQL',
                        ],
                        'table' => [
                            'headers' => array_keys([]),
                            'rows' => [],
                        ],
                    ];
                },
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
                    'return Book::findOrFail(-1);',
                ],
                "code" => function (): array {
                    $params = func_get_args();
                    if (count($params) === 0) {
                        return [];
                    }

                    $data = Book::findOrFail(-1);

                    return [
                        'properties' => [
                            'Method' => 'Eloquent ORM',
                        ],
                        'table' => [
                            'headers' => array_keys($data->toArray()),
                            'rows' => [$data->toArray()],
                        ],
                    ];
                },
                // "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'ormSelectByIdOrFail']),
            ],
        ];
    }
}
