<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Seed for development and production
        $this->call(ItemSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(PayoutChannelSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(WidgetSeeder::class);
        $this->call(PageCategorySeeder::class);

        // Seed only for development
        if (config("app.env") != "production") {
            $this->call(CreatorSeeder::class);
            $this->call(UserPageSeeder::class);
            $this->call(WidgetSettingSeeder::class);
            $this->call(GoalSeeder::class);
            $this->call(UserBalanceSeeder::class);
            $this->call(InvoiceSeeder::class);
            $this->call(SupportSeeder::class);
            $this->call(SupportDetailSeeder::class);
            $this->call(UserItemSeeder::class);
            $this->call(ContentSeeder::class);
        }

    }
}
