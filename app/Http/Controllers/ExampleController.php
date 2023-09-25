<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

            return response()->json([
                'results' => $results,
                'queries' => DB::getQueryLog(),
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
                'sqlSelectAll' => function (): array {
                    $data = DB::select('SELECT * FROM books');

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
                'ormSelectAll' => function (): array {
                    $data = Book::get();

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
                'sqlSelectById' => function (): array {
                    $data = DB::select('SELECT * FROM books WHERE id = ?', [1]);

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
                'ormSelectById' => function (): array {
                    $data = Book::find(1);

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
            ],
        ];
    }
}
