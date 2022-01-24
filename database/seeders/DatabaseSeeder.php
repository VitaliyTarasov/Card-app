<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\Card;
use App\Models\CardList;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::factory()->count(10)->create();

        $board1 = Board::create([
            'title' => 'Supplements',
            'color' => 'teal',
            'user_id' => 1
        ]);
        $board2 = Board::create([
            'title' => 'Work',
            'color' => 'brown',
            'user_id' => 2
        ]);
        $board3 = Board::create([
            'title' => 'Chores',
            'color' => 'blue',
            'user_id' => 1
        ]);

        collect([$board1, $board2, $board3])->each(function (Board $board){
            $list1 = CardList::create([
                'title' => 'To-do',
                'board_id' => $board->id
            ]);
            $list2 = CardList::create([
                'title' => 'In progress',
                'board_id' => $board->id
            ]);
            $list3 = CardList::create([
                'title' => 'Done',
                'board_id' => $board->id
            ]);

            collect([$list1, $list2, $list3])->each(function (CardList $list) use ($board){
                $order = 1;
                collect(['Buy food', 
                'Study PHP', 
                'Write a book', 
                'Do a backflip', 
                'Do sports', 
                'Clean up the room', 
                'Pay the bills'
                ])->random(random_int(1,4))->each(function (string $task) use ($board, $list, &$order){
                    $list->cards()->save(
                        Card::make(['title' => $task, 'order' => $order++, 'user_id' => $board->user_id])
                    );
                });
            });
        });
    }
}
