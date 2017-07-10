<?php

use Anacreation\Etvtest\Models\QuestionType;
use Illuminate\Database\Seeder;

class CreateQuestionTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $types = [
            [
                'label' => 'Single Multiple Choice',
                'code'  => 'SingleMultipleChoice',
            ],
            [
                'label' => 'Multiple Multiple Choice',
                'code'  => 'MultipleMultipleChoice',
            ],
        ];

        foreach ($types as $type) {
            QuestionType::create($type);
        }
    }
}
