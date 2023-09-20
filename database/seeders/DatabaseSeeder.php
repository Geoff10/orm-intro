<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Author;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'J.R.R. Tolkien' => [
                [
                    'title' => 'The Fellowship of the Ring',
                    'genre' => 'Fantasy',
                    'release_date' => '1954-07-29',
                ],
                [
                    'title' => 'The Two Towers',
                    'genre' => 'Fantasy',
                    'release_date' => '1954-11-11',
                ],
                [
                    'title' => 'The Return of the King',
                    'genre' => 'Fantasy',
                    'release_date' => '1955-10-20',
                ],
            ],
        ];

        foreach ($data as $authorName => $books) {
            $author = Author::create([
                'name' => $authorName,
            ]);

            foreach ($books as $book) {
                $author->books()->create($book);
            }
        }
    }
}
