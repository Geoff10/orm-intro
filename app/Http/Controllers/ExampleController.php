<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExampleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $module, string $exercise)
    {
        DB::connection()->enableQueryLog();

        $example = $this->getExample($module, $exercise);

        if ($example) {
            try {
                $results = view('results', [
                    'results' => $example(),
                ])->render();
            } catch (\Throwable $th) {
                $results = view('exception', [
                    'type' => get_class($th),
                    'message' => $th->getMessage(),
                ])->render();
            }

            $queryLog = collect(DB::getQueryLog())
                ->map(function ($query) {
                    $bindings = array_map(function ($binding) use (&$count) {
                        if ($binding instanceof \DateTimeInterface) {
                            $format = $binding->format('Y-m-d H:i:s');
                            return "'{$format}'";
                        }

                        if (is_string($binding)) {
                            return "'{$binding}'";
                        }

                        if (is_bool($binding)) {
                            return $binding ? 'true' : 'false';
                        }

                        if (is_null($binding)) {
                            return 'null';
                        }

                        return $binding;
                    }, $query['bindings']);

                    $query['sql'] = Str::replaceArray('?', $bindings, $query['query']);

                    return $query;
                });

            return response()->json([
                'results' => $results,
                'queries' => $queryLog,
            ]);
        }

        return abort(404);
    }

    private function getExample(string $module, string $exercise): ?callable
    {
        $modules = $this->modules();

        if (!isset($modules[$module])) {
            return null;
        }

        if (!isset($modules[$module][$exercise])) {
            return null;
        }

        return $modules[$module][$exercise];
    }

    private function modules(): array
    {
        return [
            'sqlSelectData' => [
                'sqlSelectByIdOrFail' => function (): array {
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
                'ormSelectByIdOrFail' => function (): array {
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
                'sqlSelectChooseColumns' => function (): array {
                    $data = DB::select('SELECT title, genre, release_date FROM books');

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
                'ormSelectChooseColumns' => function (): array {
                    $data = Book::select('title', 'genre', 'release_date')->get();

                    return [
                        'properties' => [
                            'Method' => 'Eloquent ORM',
                        ],
                        'table' => [
                            'headers' => array_keys($data->first()->toArray()),
                            'rows' => $data->toArray(),
                        ],
                    ];
                },
                'sqlFilterData' => function (): array {
                    $data = DB::select('SELECT * FROM books WHERE release_date < ? AND genre = ?', [
                        '1955-01-01',
                        'Fantasy'
                    ]);

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
                'ormFilterData' => function (): array {
                    $data = Book::where('release_date', '<', '1955-01-01')->where('genre', 'Fantasy')->get();

                    return [
                        'properties' => [
                            'Method' => 'Eloquent ORM',
                        ],
                        'table' => [
                            'headers' => array_keys($data->first()->toArray()),
                            'rows' => $data->toArray(),
                        ],
                    ];
                },
                'sqlFilterDataConditional' => function (): array {
                    $filters = [
                        'release_date' => '1955-01-01',
                        'genre' => 'Fantasy',
                    ];

                    $parameters = [];
                    $sql = 'SELECT * FROM books WHERE';

                    if (isset($filters['release_date'])) {
                        $sql .= ' release_date < :release_date AND';
                        $parameters['release_date'] = $filters['release_date'];
                    }

                    if (isset($filters['genre'])) {
                        $sql .= ' genre = :genre AND';
                        $parameters['genre'] = $filters['genre'];
                    }

                    $sql = rtrim($sql, ' AND');

                    $data = DB::select($sql, $parameters);

                    return [
                        'properties' => [
                            'Method' => 'SQL',
                        ],
                        'table' => [
                            'headers' => array_keys((array) $data[0]),
                            'rows' => $data,
                        ],
                        'sql' => $sql,
                        'parameters' => $parameters,
                    ];
                },
                'ormFilterDataConditional' => function (): array {
                    $filters = [
                        'release_date' => '1955-01-01',
                        'genre' => 'Fantasy',
                    ];

                    $query = Book::query();

                    if (isset($filters['release_date'])) {
                        $query->where('release_date', '<', $filters['release_date']);
                    }

                    if (isset($filters['genre'])) {
                        $query->where('genre', $filters['genre']);
                    }

                    $data = $query->get();

                    return [
                        'properties' => [
                            'Method' => 'Eloquent ORM',
                        ],
                        'table' => [
                            'headers' => array_keys($data->first()->toArray()),
                            'rows' => $data->toArray(),
                        ],
                        'sql' => $query->toSql(),
                        'parameters' => $query->getBindings(),
                    ];
                },
                'ormFilterDataUsingScope' => function (): array {
                    $data = Book::twentiethCentury()->get();

                    return [
                        'properties' => [
                            'Method' => 'Eloquent ORM with scope',
                        ],
                        'table' => [
                            'headers' => array_keys($data->first()->toArray()),
                            'rows' => $data->toArray(),
                        ],
                    ];
                },
                'sqlSortData' => function (): array {
                    $data = DB::select('SELECT * FROM books ORDER BY release_date');

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
                'ormSortData' => function (): array {
                    $data = Book::orderBy('release_date')->get();

                    return [
                        'properties' => [
                            'Method' => 'Eloquent ORM',
                        ],
                        'table' => [
                            'headers' => array_keys($data->first()->toArray()),
                            'rows' => $data->toArray(),
                        ],
                    ];
                },
                'sqlSortDataDescending' => function (): array {
                    $data = DB::select('SELECT * FROM books ORDER BY release_date DESC');

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
                'ormSortDataDescending' => function (): array {
                    $data = Book::orderBy('release_date', 'desc')->get();

                    return [
                        'properties' => [
                            'Method' => 'Eloquent ORM',
                        ],
                        'table' => [
                            'headers' => array_keys($data->first()->toArray()),
                            'rows' => $data->toArray(),
                        ],
                    ];
                },
                'sqlInsertData' => function (): array {
                    DB::beginTransaction();

                    DB::insert('INSERT INTO books (title, author_id, release_date, genre) VALUES (?, ?, ?, ?)', [
                        'New book',
                        1,
                        now(),
                        'Non-fiction',
                    ]);

                    $data = DB::select('SELECT * FROM books ORDER BY id DESC');

                    DB::rollBack();

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
                'ormInsertData' => function (): array {
                    DB::beginTransaction();

                    Book::create([
                        'title' => 'New book',
                        'author_id' => 1,
                        'release_date' => now(),
                        'genre' => 'Non-fiction',
                    ]);

                    $data = Book::orderBy('id', 'desc')->get();

                    DB::rollBack();

                    return [
                        'properties' => [
                            'Method' => 'Eloquent ORM',
                        ],
                        'table' => [
                            'headers' => array_keys($data->first()->toArray()),
                            'rows' => $data->toArray(),
                        ],
                    ];
                },
                'sqlInsertDataGetLastInsertId' => function (): array {
                    DB::beginTransaction();

                    DB::insert('INSERT INTO books (title, author_id, release_date, genre) VALUES (?, ?, ?, ?)', [
                        'New book',
                        1,
                        now(),
                        'Non-fiction',
                    ]);

                    $data = [['id' => DB::getPdo()->lastInsertId()]];

                    DB::rollBack();

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
                'ormInsertDataGetLastInsertId' => function (): array {
                    DB::beginTransaction();

                    $data = Book::create([
                        'title' => 'New book',
                        'author_id' => 1,
                        'release_date' => now(),
                        'genre' => 'Non-fiction',
                    ]);

                    $data = [$data->toArray()];

                    DB::rollBack();

                    return [
                        'properties' => [
                            'Method' => 'Eloquent ORM',
                        ],
                        'table' => [
                            'headers' => array_keys($data[0]),
                            'rows' => $data,
                        ],
                    ];
                },
                'sqlInsertDataGetLastInsertRecord' => function (): array {
                    DB::beginTransaction();

                    DB::insert('INSERT INTO books (title, author_id, release_date, genre) VALUES (?, ?, ?, ?)', [
                        'New book',
                        1,
                        now(),
                        'Non-fiction',
                    ]);

                    $data = DB::select('SELECT * FROM books ORDER BY id DESC LIMIT 1');

                    DB::rollBack();

                    return [
                        'properties' => [
                            'Method' => 'SQL',
                        ],
                        'table' => [
                            'headers' => array_keys((array) $data[0]),
                            'rows' => [$data[0]],
                        ],
                    ];
                },
                'sqlBulkInsertData' => function (): array {
                    $books = [
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
                    ];

                    DB::beginTransaction();

                    foreach ($books as $book) {
                        DB::insert('INSERT INTO books (title, author_id, release_date, genre) VALUES (?, ?, ?, ?)', [
                            $book['title'],
                            $book['author'],
                            $book['release_date'],
                            $book['genre'],
                        ]);
                    }

                    $data = DB::select('SELECT * FROM books ORDER BY id DESC');

                    DB::rollBack();

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
                'ormBulkInsertData' => function (): array {
                    $books = [
                        [
                            'title' => 'New book',
                            'author_id' => 1,
                            'release_date' => date('Y-m-d'),
                            'genre' => 'Non-fiction',
                        ],
                        [
                            'title' => 'New SQL book',
                            'author_id' => 2,
                            'release_date' => date('Y-m-d'),
                            'genre' => 'Non-fiction',
                        ],
                        [
                            'title' => 'New ORM book',
                            'author_id' => 3,
                            'release_date' => date('Y-m-d'),
                            'genre' => 'Non-fiction',
                        ],
                    ];

                    DB::beginTransaction();

                    foreach ($books as $book) {
                        Book::create($book);
                    }

                    $data = Book::orderBy('id', 'desc')->get();

                    DB::rollBack();

                    return [
                        'properties' => [
                            'Method' => 'Eloquent ORM',
                        ],
                        'table' => [
                            'headers' => array_keys($data->first()->toArray()),
                            'rows' => $data->toArray(),
                        ],
                    ];
                },
                'sqlBulkInsertDataEfficiently' => function (): array {
                    $books = [
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
                    ];

                    DB::beginTransaction();

                    $placeholders = [];
                    $bookValues = [];

                    foreach ($books as $book) {
                        $placeholders[] = '(?, ?, ?, ?)';
                        $bookValues[] = $book['title'];
                        $bookValues[] = $book['author'];
                        $bookValues[] = $book['release_date'];
                        $bookValues[] = $book['genre'];
                    }

                    DB::insert('INSERT INTO books (title, author_id, release_date, genre) VALUES ' . implode(', ', $placeholders), $bookValues);

                    $data = DB::select('SELECT * FROM books ORDER BY id DESC');

                    DB::rollBack();

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
                'ormBulkInsertDataEfficiently' => function (): array {
                    $books = [
                        [
                            'title' => 'New book',
                            'author_id' => 1,
                            'release_date' => date('Y-m-d'),
                            'genre' => 'Non-fiction',
                        ],
                        [
                            'title' => 'New SQL book',
                            'author_id' => 2,
                            'release_date' => date('Y-m-d'),
                            'genre' => 'Non-fiction',
                        ],
                        [
                            'title' => 'New ORM book',
                            'author_id' => 3,
                            'release_date' => date('Y-m-d'),
                            'genre' => 'Non-fiction',
                        ],
                    ];

                    DB::beginTransaction();

                    Book::insert($books);

                    $data = Book::orderBy('id', 'desc')->get();

                    DB::rollBack();

                    return [
                        'properties' => [
                            'Method' => 'Eloquent ORM',
                        ],
                        'table' => [
                            'headers' => array_keys($data->first()->toArray()),
                            'rows' => $data->toArray(),
                        ],
                    ];
                },
                'sqlSelectBooksAndAuthors' => function (): array {
                    $data = DB::select('SELECT books.id, authors.name, books.title, books.genre, books.release_date FROM books INNER JOIN authors ON books.author_id = authors.id');

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
                'ormSelectBooksAndAuthors' => function (): array {
                    $data = Book::all();

                    $data = $data->map(function ($book) {
                        return [
                            'id' => $book->id,
                            'author' => $book->author->name,
                            'title' => $book->title,
                            'genre' => $book->genre,
                            'release_date' => $book->release_date,
                        ];
                    });

                    return [
                        'properties' => [
                            'Method' => 'Eloquent ORM',
                        ],
                        'table' => [
                            'headers' => array_keys($data->first()),
                            'rows' => $data->toArray(),
                        ],
                    ];
                },
                'ormSelectBooksAndAuthorsEagerLoading' => function (): array {
                    $data = Book::with('author')->get();

                    $data = $data->map(function ($book) {
                        return [
                            'id' => $book->id,
                            'author' => $book->author->name,
                            'title' => $book->title,
                            'genre' => $book->genre,
                            'release_date' => $book->release_date,
                        ];
                    });

                    return [
                        'properties' => [
                            'Method' => 'Eloquent ORM with eager loading',
                        ],
                        'table' => [
                            'headers' => array_keys($data->first()),
                            'rows' => $data->toArray(),
                        ],
                    ];
                },
            ],
        ];
    }
}
