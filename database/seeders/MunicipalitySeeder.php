<?php

namespace Database\Seeders;

use App\Models\Municipality;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MunicipalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $municipalities = [
            [
                'code'=> 580,
                'name'=> 'Aabenraa'
            ],
            [
                'code'=> 851,
                'name'=> 'Aalborg'
            ],
            [
                'code'=> 751,
                'name'=> 'Aarhus'
            ],
            [
                'code'=> 165,
                'name'=> 'Albertslund'
            ],
            [
                'code'=> 201,
                'name'=> 'Allerød'
            ],
            [
                'code'=> 420,
                'name'=> 'Assens'
            ],
            [
                'code'=> 960,
                'name'=> 'Avannaata'
            ],
            [
                'code'=> 151,
                'name'=> 'Ballerup'
            ],
            [
                'code'=> 530,
                'name'=> 'Billund'
            ],
            [
                'code'=> 400,
                'name'=> 'Bornholm'
            ],
            [
                'code'=> 153,
                'name'=> 'Brøndby'
            ],
            [
                'code'=> 810,
                'name'=> 'Brønderslev'
            ],
            [
                'code'=> 411,
                'name'=> 'Christiansø'
            ],
            [
                'code'=> 155,
                'name'=> 'Dragør'
            ],
            [
                'code'=> 240,
                'name'=> 'Egedal'
            ],
            [
                'code'=> 561,
                'name'=> 'Esbjerg'
            ],
            [
                'code'=> 430,
                'name'=> 'Faaborg-Midtfyn'
            ],
            [
                'code'=> 563,
                'name'=> 'Fanø'
            ],
            [
                'code'=> 710,
                'name'=> 'Favrskov'
            ],
            [
                'code'=> 320,
                'name'=> 'Faxe'
            ],
            [
                'code'=> 210,
                'name'=> 'Fredensborg'
            ],
            [
                'code'=> 607,
                'name'=> 'Fredericia'
            ],
            [
                'code'=> 147,
                'name'=> 'Frederiksberg'
            ],
            [
                'code'=> 813,
                'name'=> 'Frederikshavn'
            ],
            [
                'code'=> 250,
                'name'=> 'Frederikssund'
            ],
            [
                'code'=> 190,
                'name'=> 'Furesø'
            ],
            [
                'code'=> 157,
                'name'=> 'Gentofte'
            ],
            [
                'code'=> 159,
                'name'=> 'Gladsaxe'
            ],
            [
                'code'=> 161,
                'name'=> 'Glostrup'
            ],
            [
                'code'=> 253,
                'name'=> 'Greve'
            ],
            [
                'code'=> 270,
                'name'=> 'Gribskov'
            ],
            [
                'code'=> 961,
                'name'=> 'Grønland'
            ],
            [
                'code'=> 376,
                'name'=> 'Guldborgsund'
            ],
            [
                'code'=> 510,
                'name'=> 'Haderslev'
            ],
            [
                'code'=> 260,
                'name'=> 'Halsnæs'
            ],
            [
                'code'=> 766,
                'name'=> 'Hedensted'
            ],
            [
                'code'=> 217,
                'name'=> 'Helsingør'
            ],
            [
                'code'=> 163,
                'name'=> 'Herlev'
            ],
            [
                'code'=> 657,
                'name'=> 'Herning'
            ],
            [
                'code'=> 219,
                'name'=> 'Hillerød'
            ],
            [
                'code'=> 860,
                'name'=> 'Hjørring'
            ],
            [
                'code'=> 316,
                'name'=> 'Holbæk'
            ],
            [
                'code'=> 661,
                'name'=> 'Holstebro'
            ],
            [
                'code'=> 615,
                'name'=> 'Horsens'
            ],
            [
                'code'=> 167,
                'name'=> 'Hvidovre'
            ],
            [
                'code'=> 169,
                'name'=> 'Høje Taastrup'
            ],
            [
                'code'=> 223,
                'name'=> 'Hørsholm'
            ],
            [
                'code'=> 756,
                'name'=> 'Ikast-Brande'
            ],
            [
                'code'=> 183,
                'name'=> 'Ishøj'
            ],
            [
                'code'=> 849,
                'name'=> 'Jammerbugt'
            ],
            [
                'code'=> 326,
                'name'=> 'Kalundborg'
            ],
            [
                'code'=> 440,
                'name'=> 'Kerteminde'
            ],
            [
                'code'=> 621,
                'name'=> 'Kolding'
            ],
            [
                'code'=> 955,
                'name'=> 'Kujalleq'
            ],
            [
                'code'=> 101,
                'name'=> 'København'
            ],
            [
                'code'=> 259,
                'name'=> 'Køge'
            ],
            [
                'code'=> 482,
                'name'=> 'Langeland'
            ],
            [
                'code'=> 350,
                'name'=> 'Lejre'
            ],
            [
                'code'=> 665,
                'name'=> 'Lemvig'
            ],
            [
                'code'=> 360,
                'name'=> 'Lolland'
            ],
            [
                'code'=> 173,
                'name'=> 'Lyngby-Taarbæk'
            ],
            [
                'code'=> 825,
                'name'=> 'Læsø'
            ],
            [
                'code'=> 846,
                'name'=> 'Mariagerfjord'
            ],
            [
                'code'=> 410,
                'name'=> 'Middelfart'
            ],
            [
                'code'=> 773,
                'name'=> 'Morsø'
            ],
            [
                'code'=> 707,
                'name'=> 'Norddjurs'
            ],
            [
                'code'=> 480,
                'name'=> 'Nordfyns'
            ],
            [
                'code'=> 450,
                'name'=> 'Nyborg'
            ],
            [
                'code'=> 370,
                'name'=> 'Næstved'
            ],
            [
                'code'=> 727,
                'name'=> 'Odder'
            ],
            [
                'code'=> 461,
                'name'=> 'Odense'
            ],
            [
                'code'=> 306,
                'name'=> 'Odsherred'
            ],
            [
                'code'=> 959,
                'name'=> 'Qeqertalik'
            ],
            [
                'code'=> 957,
                'name'=> 'Qeqqata'
            ],
            [
                'code'=> 730,
                'name'=> 'Randers'
            ],
            [
                'code'=> 840,
                'name'=> 'Rebild'
            ],
            [
                'code'=> 760,
                'name'=> 'Ringkøbing-Skjern'
            ],
            [
                'code'=> 329,
                'name'=> 'Ringsted'
            ],
            [
                'code'=> 265,
                'name'=> 'Roskilde'
            ],
            [
                'code'=> 230,
                'name'=> 'Rudersdal'
            ],
            [
                'code'=> 175,
                'name'=> 'Rødovre'
            ],
            [
                'code'=> 741,
                'name'=> 'Samsø'
            ],
            [
                'code'=> 956,
                'name'=> 'Sermersooq'
            ],
            [
                'code'=> 740,
                'name'=> 'Silkeborg'
            ],
            [
                'code'=> 746,
                'name'=> 'Skanderborg'
            ],
            [
                'code'=> 779,
                'name'=> 'Skive'
            ],
            [
                'code'=> 330,
                'name'=> 'Slagelse'
            ],
            [
                'code'=> 269,
                'name'=> 'Solrød'
            ],
            [
                'code'=> 340,
                'name'=> 'Sorø'
            ],
            [
                'code'=> 336,
                'name'=> 'Stevns'
            ],
            [
                'code'=> 671,
                'name'=> 'Struer'
            ],
            [
                'code'=> 479,
                'name'=> 'Svendborg'
            ],
            [
                'code'=> 706,
                'name'=> 'Syddjurs'
            ],
            [
                'code'=> 540,
                'name'=> 'Sønderborg'
            ],
            [
                'code'=> 787,
                'name'=> 'Thisted'
            ],
            [
                'code'=> 185,
                'name'=> 'Tårnby'
            ],
            [
                'code'=> 550,
                'name'=> 'Tønder'
            ],
            [
                'code'=> 187,
                'name'=> 'Vallensbæk'
            ],
            [
                'code'=> 573,
                'name'=> 'Varde'
            ],
            [
                'code'=> 575,
                'name'=> 'Vejen'
            ],
            [
                'code'=> 630,
                'name'=> 'Vejle'
            ],
            [
                'code'=> 820,
                'name'=> 'Vesthimmerlands'
            ],
            [
                'code'=> 791,
                'name'=> 'Viborg'
            ],
            [
                'code'=> 390,
                'name'=> 'Vordingborg'
            ],
            [
                'code'=> 492,
                'name'=> 'Ærø'
            ]
        ];

        Municipality::insert($municipalities);
    }
}
