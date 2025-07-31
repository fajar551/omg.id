<?php

namespace Database\Seeders;

use App\Models\PageCategory;
use Illuminate\Database\Seeder;

class PageCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $data = [
                [
                    "title" => 'Animation'
                ],
                [
                    "title" => 'Art'
                ],
                [
                    "title" => 'Blogging'
                ],
                [
                    "title" => 'Commics & Cartoons'
                ],
                [
                    "title" => 'Commissions'
                ],
                [
                    "title" => 'Cosplay'
                ],
                [
                    "title" => 'Dance And Theatre'
                ],
                [
                    "title" => 'Design'
                ],
                [
                    "title" => 'Drawing And Painting'
                ],
                [
                    "title" => 'Education'
                ],
                [
                    "title" => 'Food And Drink'
                ],
                [
                    "title" => 'Fundraising'
                ],
                [
                    "title" => 'Gaming'
                ],
                [
                    "title" => 'Health And Fitness'
                ],
                [
                    "title" => 'Lifestyle'
                ],
                [
                    "title" => 'Money'
                ],
                [
                    "title" => 'Music'
                ],
                [
                    "title" => 'News'
                ],
                [
                    "title" => 'Photography'
                ],
                [
                    "title" => 'Podcast'
                ],
                [
                    "title" => 'Science And Tech'
                ],
                [
                    "title" => 'Social'
                ],
                [
                    "title" => 'Software'
                ],
                [
                    "title" => 'Translator'
                ],
                [
                    "title" => 'Video And Film'
                ],
                [
                    "title" => 'Writing'
                ],
                [
                    "title" => 'Other'
                ],
            ];

            for ($i = 0; $i < count($data); $i++) {
                PageCategory::updateOrCreate(
                    $data[$i]
                );
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            //throw $th;
        }
    }
}
