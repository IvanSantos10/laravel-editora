<?php

use CodeEduBook\Models\Chapter;
use Illuminate\Database\Seeder;
use CodeEduBook\Models\Book;

class ChaptersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $books = Book::all();
        foreach ($books as $book) {
            factory(Chapter::class,5)->make()->each(function ($chapter) use ($book) {
                $chapter->book_id = $book->id;
                $chapter->save();
            });
        }
    }
}
