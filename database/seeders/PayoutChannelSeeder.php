<?php

namespace Database\Seeders;

use App\Models\PayoutChannel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PayoutChannelSeeder extends Seeder
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
                    "title" => "GOPAY",
                    "channel_code" => "gopay",
                    "type" => 1
                ],
                [
                    "title" => "DANA",
                    "channel_code" => "dana",
                    "type" => 1
                ],
                [
                    "title" => "OVO",
                    "channel_code" => "ovo",
                    "type" => 1
                ],
                [
                    "title" => "Shopeepay",
                    "channel_code" => "shopeepay",
                    "type" => 1
                ],
                [
                    "title" => "LINKAJA",
                    "channel_code" => "linkaja",
                    "type" => 1
                ],
                [
                    "title" => "ACEH",
                    "channel_code" => "aceh",
                    "type" => 2
                ],
                [
                    "title" => "ACEH SYARIAH",
                    "channel_code" => "aceh_syar",
                    "type" => 2
                ],
                [
                    "title" => "PEMBANGUNAN DAERAH BALI",
                    "channel_code" => "bali",
                    "type" => 2
                ],
                [
                    "title" => "BANTEN",
                    "channel_code" => "banten",
                    "type" => 2
                ],
                [
                    "title" => "BCA",
                    "channel_code" => "bca",
                    "type" => 2
                ],
                [
                    "title" => "BCA DIGITAL",
                    "channel_code" => "bcad",
                    "type" => 2
                ],
                [
                    "title" => "BCA SYARIAH",
                    "channel_code" => "bca_syar",
                    "type" => 2
                ],
                [
                    "title" => "BPD BENGKULU",
                    "channel_code" => "bengkulu",
                    "type" => 2
                ],
                [
                    "title" => "BJB",
                    "channel_code" => "bjb",
                    "type" => 2
                ],
                [
                    "title" => "BJB SYARIAH",
                    "channel_code" => "bjb_syar",
                    "type" => 2
                ],
                [
                    "title" => "BNI",
                    "channel_code" => "bni",
                    "type" => 2
                ],
                [
                    "title" => "BRI",
                    "channel_code" => "bri",
                    "type" => 2
                ],
                [
                    "title" => "BSI",
                    "channel_code" => "bsi",
                    "type" => 2
                ],
                [
                    "title" => "BTN",
                    "channel_code" => "btn",
                    "type" => 2
                ],
                [
                    "title" => "BTN SYARIAH",
                    "channel_code" => "btn_syar",
                    "type" => 2
                ],
                [
                    "title" => "BTPN",
                    "channel_code" => "btpn",
                    "type" => 2
                ],
                [
                    "title" => "BTPN SYARIAH",
                    "channel_code" => "btpn_syar",
                    "type" => 2
                ],
                [
                    "title" => "BUKOPIN",
                    "channel_code" => "bukopin",
                    "type" => 2
                ],
                [
                    "title" => "BUKOPIN SYARIAH",
                    "channel_code" => "bukopin_syar",
                    "type" => 2
                ],
                [
                    "title" => "CIMB",
                    "channel_code" => "cimb",
                    "type" => 2
                ],
                [
                    "title" => "CIMB SYARIAH",
                    "channel_code" => "cimb_syar",
                    "type" => 2
                ],
                [
                    "title" => "CIMB Rekening Ponsel",
                    "channel_code" => "cimb_rekening_ponsel",
                    "type" => 2
                ],
                [
                    "title" => "CITIBANK",
                    "channel_code" => "citibank",
                    "type" => 2
                ],
                [
                    "title" => "DANAMON",
                    "channel_code" => "danamon",
                    "type" => 2
                ],
                [
                    "title" => "DANAMON SYARIAH",
                    "channel_code" => "danamon_syar",
                    "type" => 2
                ],
                [
                    "title" => "DIY",
                    "channel_code" => "diy",
                    "type" => 2
                ],
                [
                    "title" => "DIY SYARIAH",
                    "channel_code" => "diy_syar",
                    "type" => 2
                ],
                [
                    "title" => "DKI",
                    "channel_code" => "diy",
                    "type" => 2
                ],
                [
                    "title" => "DKI SYARIAH",
                    "channel_code" => "dki_syar",
                    "type" => 2
                ],
                [
                    "title" => "HANA",
                    "channel_code" => "hana",
                    "type" => 2
                ],
                [
                    "title" => "HSBC",
                    "channel_code" => "hsbc",
                    "type" => 2
                ],
                [
                    "title" => "ICBC",
                    "channel_code" => "icbc",
                    "type" => 2
                ],
                [
                    "title" => "JAGO",
                    "channel_code" => "jago",
                    "type" => 2
                ],
                [
                    "title" => "JAMBI",
                    "channel_code" => "jambi",
                    "type" => 2
                ],
                [
                    "title" => "JATENG",
                    "channel_code" => "jateng",
                    "type" => 2
                ],
                [
                    "title" => "JATENG SYARIAH",
                    "channel_code" => "jateng_syar",
                    "type" => 2
                ],
                [
                    "title" => "JATIM",
                    "channel_code" => "jateng",
                    "type" => 2
                ],
                [
                    "title" => "JATIM SYARIAH",
                    "channel_code" => "jatim_syar",
                    "type" => 2
                ],
                [
                    "title" => "KALBAR",
                    "channel_code" => "kalbar",
                    "type" => 2
                ],
                [
                    "title" => "KALBAR SYARIAH",
                    "channel_code" => "kalbar_syar",
                    "type" => 2
                ],
                [
                    "title" => "KALSEl",
                    "channel_code" => "kalsel",
                    "type" => 2
                ],
                [
                    "title" => "KALSEl SYARIAH",
                    "channel_code" => "kalsel_syar",
                    "type" => 2
                ],
                [
                    "title" => "KALTENG",
                    "channel_code" => "kalteng",
                    "type" => 2
                ],
                [
                    "title" => "KALTIM",
                    "channel_code" => "kaltim",
                    "type" => 2
                ],
                [
                    "title" => "KALTIM SYARIAH",
                    "channel_code" => "kaltim_syar",
                    "type" => 2
                ],
                [
                    "title" => "LAMPUNG",
                    "channel_code" => "lampung",
                    "type" => 2
                ],
                [
                    "title" => "MALUKU",
                    "channel_code" => "maluku",
                    "type" => 2
                ],
                [
                    "title" => "MANDIRI",
                    "channel_code" => "mandiri",
                    "type" => 2
                ],
                [
                    "title" => "MANDIRI TASPEN",
                    "channel_code" => "mandiri_taspen",
                    "type" => 2
                ],
                [
                    "title" => "MAYBANK",
                    "channel_code" => "maybank",
                    "type" => 2
                ],
                [
                    "title" => "MAYBANK SYARIAH",
                    "channel_code" => "maybank_syar",
                    "type" => 2
                ],
                [
                    "title" => "MEGA",
                    "channel_code" => "mega_tbk",
                    "type" => 2
                ],
                [
                    "title" => "MEGA SYARIAH",
                    "channel_code" => "mega_syar",
                    "type" => 2
                ],
                [
                    "title" => "MNC",
                    "channel_code" => "mnc",
                    "type" => 2
                ],
                [
                    "title" => "MUAMALAT",
                    "channel_code" => "muamalat",
                    "type" => 2
                ],
                [
                    "title" => "NIAGA SYARIAH",
                    "channel_code" => "niaga_syar",
                    "type" => 2
                ],
                [
                    "title" => "NTB",
                    "channel_code" => "ntb",
                    "type" => 2
                ],
                [
                    "title" => "NTT",
                    "channel_code" => "ntt",
                    "type" => 2
                ],
                [
                    "title" => "OCBC SYARIAH",
                    "channel_code" => "ocbc",
                    "type" => 2
                ],
                [
                    "title" => "OCBC SYARIAH",
                    "channel_code" => "ocbc_syar",
                    "type" => 2
                ],
                [
                    "title" => "OK",
                    "channel_code" => "ok",
                    "type" => 2
                ],
                [
                    "title" => "PANIN",
                    "channel_code" => "panin",
                    "type" => 2
                ],
                [
                    "title" => "PANIN SYARIAH",
                    "channel_code" => "panin_syar",
                    "type" => 2
                ],
                [
                    "title" => "PAPUA",
                    "channel_code" => "papua",
                    "type" => 2
                ],
                [
                    "title" => "PERMATA",
                    "channel_code" => "permata",
                    "type" => 2
                ],
                [
                    "title" => "PERMATA SYARIAH",
                    "channel_code" => "permata_syar",
                    "type" => 2
                ],
                [
                    "title" => "PRIMA MASTER",
                    "channel_code" => "prima_master",
                    "type" => 2
                ],
                [
                    "title" => "QNB",
                    "channel_code" => "qnb",
                    "type" => 2
                ],
                [
                    "title" => "RIAU",
                    "channel_code" => "riau",
                    "type" => 2
                ],
                [
                    "title" => "RIAU SYARIAH",
                    "channel_code" => "riau_syar",
                    "type" => 2
                ],
                [
                    "title" => "SAHABAT SAMPOERNA",
                    "channel_code" => "sahabat_sampoerna",
                    "type" => 2
                ],
                [
                    "title" => "SEABANK",
                    "channel_code" => "seabank",
                    "type" => 2
                ],
                [
                    "title" => "SINARMAS",
                    "channel_code" => "sinarmas",
                    "type" => 2
                ],
                [
                    "title" => "SINARMAS SYARIAH",
                    "channel_code" => "sinarmas_syar",
                    "type" => 2
                ],
                [
                    "title" => "SULSELBAR",
                    "channel_code" => "sulselbar",
                    "type" => 2
                ],
                [
                    "title" => "SULSELBAR SYARIAH",
                    "channel_code" => "sulselbar_syar",
                    "type" => 2
                ],
                [
                    "title" => "SULTENG",
                    "channel_code" => "sulteng",
                    "type" => 2
                ],
                [
                    "title" => "SULTENGGARA",
                    "channel_code" => "sultenggara",
                    "type" => 2
                ],
                [
                    "title" => "SULUT",
                    "channel_code" => "sulut",
                    "type" => 2
                ],
                [
                    "title" => "SUMBAR",
                    "channel_code" => "sumbar",
                    "type" => 2
                ],
                [
                    "title" => "SUMSEL BABEL",
                    "channel_code" => "sumsel_babel",
                    "type" => 2
                ],
                [
                    "title" => "SUMSEL BABEL SYARIAH",
                    "channel_code" => "sumsel_babel_syar",
                    "type" => 2
                ],
                [
                    "title" => "SUMUT",
                    "channel_code" => "sumut",
                    "type" => 2
                ],
                [
                    "title" => "SUMUT SYARIAH",
                    "channel_code" => "sumut_syar",
                    "type" => 2
                ],
            ];

            for ($i=0; $i < count($data); $i++) { 
                PayoutChannel::updateOrCreate(
                    ['channel_code' => $data[$i]['channel_code']],
                    $data[$i]
                );
            }
            // DB::table("payout_channels")->insert($data);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
