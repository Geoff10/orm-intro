<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Workbooks\Chapter;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PreviewController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $workbook, string $chapter, int $exercise)
    {
        DB::connection()->enableQueryLog();

        $chapterClass = "App\\Workbooks\\{$workbook}\\Chapters\\{$chapter}Chapter";
        if (!is_subclass_of($chapterClass, Chapter::class)) {
            return abort(404);
        }

        $content = (new $chapterClass())->getContent();
        $block = $content[$exercise] ?? null;

        if (!$block || $block['type'] !== 'runnableCodeBlock' || !isset($block['code'])) {
            return abort(404);
        }

        $example = $block['code'];

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
}
