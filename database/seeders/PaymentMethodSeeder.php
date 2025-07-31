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
            
            // Delete existing payment methods first
            PaymentMethod::query()->delete();
            
            $providers = [
                // Midtrans Payment Methods (Unified)
                [
                    "name" => "Credit Card",
                    "payment_type" => "credit_card",
                    "bank_name" => null,
                    "image" => "pg_credit_card.svg",
                    "type" => 3,
                    "order" => 1
                ],
                [
                    "name" => "Bank Transfer",
                    "payment_type" => "bank_transfer",
                    "bank_name" => null,
                    "image" => "pg_bank_transfer.svg",
                    "type" => 3,
                    "order" => 2
                ],
                [
                    "name" => "Gopay",
                    "payment_type" => "gopay",
                    "bank_name" => null,
                    "image" => "pg_gopay.svg",
                    "type" => 3,
                    "order" => 3
                ],
                [
                    "name" => "OVO",
                    "payment_type" => "ovo",
                    "bank_name" => null,
                    "image" => "pg_ovo.svg",
                    "type" => 3,
                    "order" => 4
                ],
                [
                    "name" => "Dana",
                    "payment_type" => "dana",
                    "bank_name" => null,
                    "image" => "pg_dana.svg",
                    "type" => 3,
                    "order" => 5
                ],
                [
                    "name" => "LinkAja",
                    "payment_type" => "linkaja",
                    "bank_name" => null,
                    "image" => "pg_linkaja.svg",
                    "type" => 3,
                    "order" => 6
                ],
                [
                    "name" => "ShopeePay",
                    "payment_type" => "shopeepay",
                    "bank_name" => null,
                    "image" => "pg_shopeepay.svg",
                    "type" => 3,
                    "order" => 7
                ],
                [
                    "name" => "QRIS",
                    "payment_type" => "qris",
                    "bank_name" => null,
                    "image" => "pg_qris.svg",
                    "type" => 3,
                    "order" => 8
                ],
            ];

            foreach ($providers as $provider) {
                PaymentMethod::create($provider);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
