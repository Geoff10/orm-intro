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
            'Jane Austen' => [
                [
                    'title' => 'Pride and Prejudice',
                    'genre' => 'Romance',
                    'release_date' => '1813-01-28',
                ],
                [
                    'title' => 'Emma',
                    'genre' => 'Romance',
                    'release_date' => '1815-12-23',
                ],
                [
                    'title' => 'Persuasion',
                    'genre' => 'Romance',
                    'release_date' => '1817-12-01',
                ],
                [
                    'title' => 'Sense and Sensibility',
                    'genre' => 'Romance',
                    'release_date' => '1811-10-30',
                ]
            ],
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
            'Emily Bronte' => [
                [
                    'title' => 'Wuthering Heights',
                    'genre' => 'Gothic Fiction',
                    'release_date' => '1847-12-19',
                ],
            ],
            'Harper Lee' => [
                [
                    'title' => 'To Kill a Mockingbird',
                    'genre' => 'Southern Gothic',
                    'release_date' => '1960-07-11',
                ],
            ],
            'Chimaamanda Ngozi Adichie' => [
                [
                    'title' => 'Purple Hibiscus',
                    'genre' => 'Fiction',
                    'release_date' => '2003-10-30',
                ],
                [
                    'title' => 'Half of a Yellow Sun',
                    'genre' => 'Historical Fiction',
                    'release_date' => '2006-09-12',
                ],
                [
                    'title' => 'The Thing Around Your Neck',
                    'genre' => 'Short Stories',
                    'release_date' => '2009-04-22',
                ],
                [
                    'title' => 'Americanah',
                    'genre' => 'Fiction',
                    'release_date' => '2013-05-14',
                ],
            ],
            'Haruki Murakami' => [
                [
                    'title' => 'Norwegian Wood',
                    'genre' => 'Fiction',
                    'release_date' => '1987-09-01',
                ],
                [
                    'title' => 'The Wind-Up Bird Chronicle',
                    'genre' => 'Fiction',
                    'release_date' => '1994-10-17',
                ],
                [
                    'title' => 'Kafka on the Shore',
                    'genre' => 'Fiction',
                    'release_date' => '2002-01-01',
                ],
                [
                    'title' => '1Q84',
                    'genre' => 'Fiction',
                    'release_date' => '2009-05-29',
                ],
            ],
            'Molly-Mae Hague' => [
                [
                    'title' => 'Be You',
                    'genre' => 'Autobiography',
                    'release_date' => '2021-05-20',
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
