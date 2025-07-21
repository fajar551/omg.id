<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use DB;

class PaymentMethodSeeder extends Seeder
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
            
            $providers = [
                [
                    "name" => "Sahabat Sampoerna",
                    "payment_type" => "bank_transfer",
                    "bank_name" => "sahabat_sampoerna",
                    "image" => "pg_sampoerna.png",
                    "type" => 2
                ],
                [
                    "name" => "Dana",
                    "payment_type" => "dana",
                    "bank_name" => null,
                    "image" => "pg_dana.png",
                    "type" => 1
                ],
                [
                    "name" => "Ovo",
                    "payment_type" => "ovo",
                    "bank_name" => null,
                    "image" => "pg_ovo.png",
                    "type" => 1
                ],
                [
                    "name" => "Gopay",
                    "payment_type" => "gopay",
                    "bank_name" => null,
                    "image" => "pg_gopay.png",
                    "type" => 1
                ],
                [
                    "name" => "Link aja",
                    "payment_type" => "linkaja",
                    "bank_name" => null,
                    "image" => "pg_linkaja.png",
                    "type" => 1
                ],
                [
                    "name" => "Shopee Pay",
                    "payment_type" => "shopeepay",
                    "bank_name" => null,
                    "image" => "pg_shopeepay.png",
                    "type" => 1
                ],
                [
                    "name" => "Qris",
                    "payment_type" => "qris",
                    "bank_name" => null,
                    "image" => "pg_qris.png",
                    "type" => 1
                ],
            ];

            foreach ($providers as $key => $provider) {
                PaymentMethod::updateOrCreate(
                    ['id' => $key],
                    $provider,
                );
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
