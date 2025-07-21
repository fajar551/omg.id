<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\PaymentMethod;
use App\Src\Helpers\Constant;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use DB;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::beginTransaction();

            $faker = Factory::create('id_ID');
            $paymentMethods = PaymentMethod::select("id", "payment_type")->get()->toArray();

            for ($i = 1; $i <= Constant::SEEDER_LIMIT; $i++) { 
                $rand = $faker->numberBetween(0, count($paymentMethods) - 1);
                $pmId = $paymentMethods[$rand]["id"];
                $pmType = $paymentMethods[$rand]["payment_type"];

                Invoice::updateOrCreate(
                    ["id" => $i],
                    [
                        'payment_method_id' => $pmId,
                        'order_id' => 'PAYMENT-' . $i . date('YmdHis') .'-' .\Str::random(24),
                        'transaction_id' => $faker->numberBetween(1000000, 5000000),
                        'information_id'=> $faker->numberBetween(1000000, 5000000),
                        'email' => $faker->email,
                        'type' => 1,
                        'payment_type' => $pmType,
                        'gross_amount' => $grossAmount = $faker->numberBetween(0, 1000000),
                        'status' => 'SUCCEEDED',
                        'notes' => $faker->sentence(6, true),
                        'date_paid' => $datePaid = $faker->dateTimeThisMonth(),
                        'pg_fee' => '1.5',
                        'pg_amount' => $pgAmount = ($grossAmount * 1.5) / 100,
                        'platform_fee' => '3',
                        'platform_amount' => $platformAmount = ($grossAmount * 3) / 100,
                        'creator_amount' => $grossAmount - $pgAmount - $platformAmount,
                        'date_active' => Carbon::parse($datePaid)->addDays(3),
                    ]
                );
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
