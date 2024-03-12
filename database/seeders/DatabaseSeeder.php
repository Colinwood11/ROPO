<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        $tables = DB::select('SELECT 
        TABLE_NAME
        FROM information_schema.TABLES 
        WHERE TABLE_SCHEMA = \'ropp_eu_org\'');
        foreach ($tables as $table)
        {
            //print_r($table);
            DB::statement('TRUNCATE `'.$table->TABLE_NAME.'`');
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        /*SQL style database populator */
        //print_r(Carbon::createFromDate(rand(1950,1999),rand(1,12),1)->addDays(rand(0,30))->format('Y-m-d'));
        $Database = 
        [
            'users'=>
            [
                'key' => ['username','email','password','status','role','birthday','last_login'],                 
                'value' =>
                [
                    /*1*/['Admin','admin@restaurant.it',Hash::make('password'),'normal',4,Carbon::createFromDate(rand(1950,1999),rand(1,12),1)->addDays(rand(0,30))->format('Y-m-d'),Carbon::now()], 
                    /*2*/['cashier','cashier@restaurant.it',Hash::make('password'),'normal',3,Carbon::createFromDate(rand(1950,1999),rand(1,12),1)->addDays(rand(0,30))->format('Y-m-d'),Carbon::now()],
                    /*3*/['waiter1','waiter1@restaurant.it',Hash::make('password'),'normal',2,Carbon::createFromDate(rand(1950,1999),rand(1,12),1)->addDays(rand(0,30))->format('Y-m-d'),Carbon::now()],
                    /*4*/['waiter2','waiter2@restaurant.it',Hash::make('password'),'normal',2,Carbon::createFromDate(rand(1950,1999),rand(1,12),1)->addDays(rand(0,30))->format('Y-m-d'),Carbon::now()],
                    /*5*/['waiter3','waiter3@restaurant.it',Hash::make('password'),'normal',2,Carbon::createFromDate(rand(1950,1999),rand(1,12),1)->addDays(rand(0,30))->format('Y-m-d'),Carbon::now()],
                    /*6*/['client1','client1@restaurant.it',Hash::make('password'),'normal',1,Carbon::createFromDate(rand(1950,1999),rand(1,12),1)->addDays(rand(0,30))->format('Y-m-d'),Carbon::now()],
                    /*7*/['client2','client2@restaurant.it',Hash::make('password'),'normal',1,Carbon::createFromDate(rand(1950,1999),rand(1,12),1)->addDays(rand(0,30))->format('Y-m-d'),Carbon::now()],
                ]
            ],

            'table_res'=>
            [
                'key' => ['number','num_person','status','code'],                 
                'value' =>
                [
                    ['1',4,'active','0000'],
                    ['2',4,'active',null],
                    ['3',4,'active',null],
                    ['4',4,'active',null],
                    ['5',4,'active',null],
                    ['6',2,'active',null],
                    ['7',2,'active',null],
                    ['8',2,'active',null],
                    ['9',2,'active',null],
                    ['10',2,'active',null],
                    ['11',2,'active',null],
                    ['12',2,'active',null],
                    ['13',2,'active',null],
                    ['14',2,'active',null],
                    ['15',6,'active',null],
                    ['16',2,'active',null],
                    ['18',4,'active',null],
                    ['19',6,'active',null],
                    ['20',4,'active',null],
                    ['21',2,'active',null],
                    ['22',2,'active',null],
                    ['23',4,'active',null],
                    ['24',2,'active',null],
                    ['25',2,'active',null],
                    ['26',2,'active',null],
                    ['27',2,'active',null],
                    ['28',2,'active',null],
                    ['30',2,'active',null],
                    ['31',6,'active',null],
                    ['32',6,'active',null],
                    ['33',6,'active',null],
                    ['34',6,'active',null],
                    ['35',6,'active',null],
                    ['645',6,'active',substr(str_shuffle(str_repeat("0123456789",4)), 0, 4)],

                ]
            ],

            'faq' =>
            [
                'key' => [ 'question', 'answer'],
                'value' =>
                [
                    ['Lorem ipsum dolor sit amet','Nullam risus ligula, elementum ut lorem ac, dictum maximus nisi. Donec bibendum massa vitae metus gravida, sit amet blandit nisi pulvinar.' ],
                    ['In hac habitasse platea dictumst','Fusce mattis, tortor at fermentum fringilla, elit leo blandit augue, et aliquet lacus odio ac magna. Curabitur auctor at libero vel ultricies.' ],
                ]
    
            ],

            'dish' =>
            [
                'key' => [ 'id','img', 'name','description','status','printer','number_code'],
                'value' =>
                [
                    ['1','default.jpg','ONIGIRI PHILADELPHIA (1pz)','Non ci sono descrizione al momento','normal','1','1'],
                    ['2','default.jpg',' ONIGIRI SALMONE (1pz)','Non ci sono descrizione al momento','normal','1','2'],
                    ['3','default.jpg','CIAMBELLA (1pz)','Non ci sono descrizione al momento','normal','1','3'],
                    ['4','default.jpg','NIGIRI SALMONE','Non ci sono descrizione al momento','normal','1','4'],
                    ['5','default.jpg','NIIGIRI TONNO','Non ci sono descrizione al momento','normal','2','5'],
                    ['6','default.jpg','NIGIRI BRANZINO NIGIRI EBI ','Non ci sono descrizione al momento','normal','2','6'],
                    ['7','default.jpg','NIGIRI AVOCADO','Non ci sono descrizione al momento','normal','2','7'],
                    ['8','default.jpg','NIGIRI GRANCHIO','Non ci sono descrizione al momento','normal','2','8'],
                    ['9','default.jpg','NIGIRI POLLO','Non ci sono descrizione al momento','normal','2','9'],
                    ['10','default.jpg','KENZU','Non ci sono descrizione al momento','normal','1','10'],
                    ['11','default.jpg',' NIENCIA','Non ci sono descrizione al momento','normal','1','11'],
                    ['12','default.jpg','TRUE','Non ci sono descrizione al momento','normal','1','12'],
                    ['13','default.jpg',' NIGIRI EBI','Non ci sono descrizione al momento','normal','0','13'],
                    ['14','default.jpg','GUNKAN SALMONE','Non ci sono descrizione al momento','normal' ,'0','14'],
                    ['15','default.jpg',' GUNKAN TONNO','Non ci sono descrizione al momento','normal','0','15'],
                    ['16','default.jpg','SPICY TONNO','Non ci sono descrizione al momento','normal','0','16'],
                    ['17','default.jpg','SPICY SALMONE','Non ci sono descrizione al momento','normal','0','17'],
                    ['18','default.jpg','TONNO PHILADELPHIA','Non ci sono descrizione al momento','normal','0','19'],
                    ['19','default.jpg','SALMONE PHILADELPHIA','Non ci sono descrizione al momento','normal','0','20'],
                    ['20','default.jpg','GUNKAN ZUCCHINE','Non ci sono descrizione al momento','normal','0','21'],
                    ['21','default.jpg','GUNKAN CETRIOLO','Non ci sono descrizione al momento','normal','0','22'],
                    ['22','default.jpg','HOSOMAKI CETRIOLO','Non ci sono descrizione al momento','normal','0','23'],
                    ['23','default.jpg','HOSOMAKI AVOCADO HOSOMAKI','Non ci sono descrizione al momento','normal','0','24'],
                    ['24','default.jpg','HOSOMAKI TONNO','Non ci sono descrizione al momento','normal','0','25'],
                    ['25','default.jpg','HOSOMAKI SALMONE','Non ci sono descrizione al momento','normal','0','26'],
                    ['26','default.jpg','HOSOMAKI EBI','Non ci sono descrizione al momento','normal','0','27'],
                    ['27','default.jpg','HOSOMAKI SAKE TEMPURA ','Non ci sono descrizione al momento','normal','0','28'],
                    ['28','default.jpg','HOSOMAKI MISTO FRITTO','Non ci sono descrizione al momento','normal','0','29'],
                    ['29','default.jpg','HOSOMAKI COLORE','Non ci sono descrizione al momento','normal','0','30'],
                    ['30','default.jpg','FUTOMAKI SPECIAL','Non ci sono descrizione al momento','normal','0','31'],
                    ['31','default.jpg','FUTOMAKI SALMONE','Non ci sono descrizione al momento','normal','0','32'],
                    ['32','default.jpg','FUTOMAKI TONNO','Non ci sono descrizione al momento','normal','0','33'],
                    ['33','default.jpg','FUTOMAKI EBI','Non ci sono descrizione al momento','normal','0','34'],
                    ['34','default.jpg','CALIFORNIA','Non ci sono descrizione al momento','normal','0','35'],
                    ['35','default.jpg','VEGETARIANO','Non ci sono descrizione al momento','normal','0','36'],
                    ['36','default.jpg','ARCOBALENO','Non ci sono descrizione al momento','normal','0','37'],
                    ['37','default.jpg','SPICY SALMON','Non ci sono descrizione al momento','normal','0','38'],
                    ['38','default.jpg','SPICY TONNO','Non ci sono descrizione al momento','normal','0','39'],
                    ['39','default.jpg','SAKE MAKI','Non ci sono descrizione al momento','normal','0','39a'],
                    ['40','default.jpg','TUNA MAKI','Non ci sono descrizione al momento','normal','0','40'],
                    ['41','default.jpg','MIURA','Non ci sono descrizione al momento','normal','0','41'],
                    ['42','default.jpg','BIANCO ROLL','Non ci sono descrizione al momento','normal','0','42'],
                    ['43','default.jpg','BLACK ROLL','Non ci sono descrizione al momento','normal','0','43'],
                    ['44','default.jpg','MANDORLE ROLL','Non ci sono descrizione al momento','normal','0','44'],
                    ['45','default.jpg','BLACK SALMONE ROLL','Non ci sono descrizione al momento','normal','0','45'],
                    ['46','default.jpg','SOTTILE ROLL','Non ci sono descrizione al momento','normal','0','46'],
                    ['47','default.jpg','URAMAKI MISTO','Non ci sono descrizione al momento','normal','0','47'],
                    ['48','default.jpg','DRAGON ROLL','Non ci sono descrizione al momento','normal','0','48'],
                    ['49','default.jpg','TIGER ROLL','Non ci sono descrizione al momento','normal','0','49'],
                    ['50','default.jpg','EBITEN ROLL','Non ci sono descrizione al momento','normal','0','50'],
                    ['51','default.jpg','FRUTTA ROLL','Non ci sono descrizione al momento','normal','0','51'],
                    ['52','default.jpg','TEMAKI SPICY SALMON','Non ci sono descrizione al momento','normal','0','52'],
                    ['53','default.jpg','TEMAKI SPICY TONNO','Non ci sono descrizione al momento','normal','0','53'],
                    ['54','default.jpg','TEMAKI TONNO','Non ci sono descrizione al momento','normal','0','54'],
                    ['55','default.jpg','TEMAKI SALMONE','Non ci sono descrizione al momento','normal','0','55'],
                    ['56','default.jpg','TEMAKI EBI','Non ci sono descrizione al momento','normal','0','56'],
                    ['57','default.jpg','TEMAKI DRAGON','Non ci sono descrizione al momento','normal','0','57'],
                    ['58','default.jpg','TEMAKI PHILADELPHIA','Non ci sono descrizione al momento','normal','0','58'],
                    ['59','default.jpg','TEMAKI CALIFORNIA','Non ci sono descrizione al momento','normal','0','59'],
                    ['60','default.jpg','TEMAKI VEGETARIANO','Non ci sono descrizione al momento','normal','0','60'],
                    ['61','default.jpg','SALMONE TARTAR','Non ci sono descrizione al momento','normal','0','61'],
                    ['62','default.jpg','TONNO TARTAR','Non ci sono descrizione al momento','normal','0','62'],
                    ['63','default.jpg','CHIRASHI MISTO','Non ci sono descrizione al momento','normal','0','63'],
                    ['64','default.jpg','CARPACCIO','Non ci sono descrizione al momento','normal','0','64'],
                    ['65','default.jpg','TONNO','Non ci sono descrizione al momento','normal','0','65'],
                    ['66','default.jpg','SALMONE','Non ci sono descrizione al momento','normal','0','66'],
                    ['67','default.jpg','BRANZINO','Non ci sono descrizione al momento','normal','0','67'],
                    ['68','default.jpg','EBI','Non ci sono descrizione al momento','normal','0','68'],
                    ['69','default.jpg','SHIBU','Non ci sono descrizione al momento','normal','0','69'],
                    ['70','default.jpg','MISTO1','Non ci sono descrizione al momento','normal','0','70'],
                    ['71','default.jpg','MISTO2','Non ci sono descrizione al momento','normal','0','71'],
                    ['72','default.jpg','MISTO3','Non ci sono descrizione al momento','normal','0','72'],
                    ['73','default.jpg','MISTO4','Non ci sono descrizione al momento','normal','0','73'],
                    ['74','default.jpg','TEMARI SISHI','Non ci sono descrizione al momento','normal','0','74'],
                    ['75','default.jpg','BARCA1','Non ci sono descrizione al momento','normal','0','75'],
                    ['76','default.jpg','BARCA2','Non ci sono descrizione al momento','normal','0','76'],
                    ['77','default.jpg','BARCA3','Non ci sono descrizione al momento','normal','0','77'],
                    ['78','default.jpg','BARCA4','Non ci sono descrizione al momento','normal','0','78'],
                    ['79','default.jpg','GAMBERETTI TEMPURA','Non ci sono descrizione al momento','normal','0','79'],
                    ['80','default.jpg','GAMBERONI TEMPURA','Non ci sono descrizione al momento','normal','0','80'],
                    ['81','default.jpg','POLLO TEMPURA','Non ci sono descrizione al momento','normal','0','81'],
                    ['82','default.jpg','VERDURA TEMPURA','Non ci sono descrizione al momento','normal','0','82'],
                    ['83','default.jpg','TEMPURA MISTA','Non ci sono descrizione al momento','normal','0','c1'],
                    ['84','default.jpg','MISTO1INVOLTINI PRIMAVERA','Non ci sono descrizione al momento','normal','0','c2'],
                    ['85','default.jpg','INVOLTTINI CHESI','Non ci sono descrizione al momento','normal','0','c3'],
                    ['86','default.jpg','NUVOLETTE DI GAMBERI','Non ci sono descrizione al momento','normal','0','c4'],
                    ['87','default.jpg','WANTON FRITTO','Non ci sono descrizione al momento','normal','0','c5'],
                    ['88','default.jpg','RAVIOLI CON VERDURE','Non ci sono descrizione al momento','normal','0','c6'],
                    ['89','default.jpg','RAVIOLI AL VAPORE','Non ci sono descrizione al momento','normal','0','c7'],
                    ['90','default.jpg','RAVIOLI ALLA GRIGLIA','Non ci sono descrizione al momento','normal','0','c8'],
                    ['91','default.jpg','RAVIOLI CON GAMBERI','Non ci sono descrizione al momento','normal','0','c9'],
                    ['92','default.jpg','RAVIOLI DI XIAO MAI','Non ci sono descrizione al momento','normal','0','c10'],
                    ['93','default.jpg','RAVIOLI MISTO','Non ci sono descrizione al momento','normal','0','c11'],
                    ['94','default.jpg','TOAST DI GAMBERI FRITTO','Non ci sono descrizione al momento','normal','0','c12'],
                    ['95','default.jpg','ALGHE FRITTO','Non ci sono descrizione al momento','normal','0','c13'],
                    ['96','default.jpg','ALGHE FRESCHE','Non ci sono descrizione al momento','normal','0','c14'],
                    ['97','default.jpg','VERDURE MISTE FRITTE','Non ci sono descrizione al momento','normal','0','c15'],
                    ['98','default.jpg','ANTIPASTO MISTO CALTO FRITTO','Non ci sono descrizione al momento','normal','0','c16'],
                    ['99','default.jpg','ANTIPASTO MISTO DI FREDDO','Non ci sono descrizione al momento','normal','0','c17'],
                    ['100','default.jpg','INSALATA CON TONNO','Non ci sono descrizione al momento','normal','0','c18'],
                    ['101','default.jpg','INSALATA CON POLLO E MAIS','Non ci sono descrizione al momento','normal','0','c19'],
                    ['102','default.jpg','INSALATA MIX','Non ci sono descrizione al momento','normal','0','c20'],
                    ['103','default.jpg','MAIONESE CON MAIS E GAMBE','Non ci sono descrizione al momento','normal','0','c21'],
                    ['104','default.jpg','POLPETTINE DI GAMBERI','Non ci sono descrizione al momento','normal','0','c22'],
                    ['105','default.jpg','PATATE AL PEPE','Non ci sono descrizione al momento','normal','0','c23'],
                    ['106','default.jpg','PATATE CON SALSA TAILAND','Non ci sono descrizione al momento','normal','0','c24'],
                    ['107','default.jpg','ZUPPA AGROPICCANTE','Non ci sono descrizione al momento','normal','0','c25'],
                    ['108','default.jpg','ZUPPA MISO','Non ci sono descrizione al momento','normal','0','c26'],
                    ['109','default.jpg','ZUPPA DI POLLO MAIS','Non ci sono descrizione al momento','normal','0','c27'],
                    ['110','default.jpg','ZUPPA DI GAMBRI','Non ci sono descrizione al momento','normal','0','c28'],
                    ['111','default.jpg','ZUPPA DI GRCHIO ASPARAGI','Non ci sono descrizione al momento','normal','0','c29'],
                    ['112','default.jpg','RISO SPECIAL','Non ci sono descrizione al momento','normal','0','c30'],
                    ['113','default.jpg','RISO CON VERDURE MISTO','Non ci sono descrizione al momento','normal','0','c31'],
                    ['114','default.jpg','RISO ALLA CANTONESE','Non ci sono descrizione al momento','normal','0','c32'],
                    ['115','default.jpg','RISO CON GAMBERI','Non ci sono descrizione al momento','normal','0','c33'],
                    ['116','default.jpg','RISO AL CURRY','Non ci sono descrizione al momento','normal','0','c34'],
                    ['117','default.jpg','RISO CON PINOLI E ANANAS','Non ci sono descrizione al momento','normal','0','c35'],
                    ['118','default.jpg','SPAGHETTI DI RISO CON VERDURA','Non ci sono descrizione al momento','normal','0','c36'],
                    ['119','default.jpg','FRUTTI DI MARE ALLA PIASTRA','Non ci sono descrizione al momento','normal','0','c37'],
                    ['120','default.jpg','UDON CON VERDURE','Non ci sono descrizione al momento','normal','0','c38'],
                    ['121','default.jpg','RAMEN DI VITELLO','Non ci sono descrizione al momento','normal','0','c39'],
                    ['122','default.jpg','NOODLES','Non ci sono descrizione al momento','normal','0','c40'],
                    ['123','default.jpg','HIYASHHI CHUKA','Non ci sono descrizione al momento','normal','0','c41'],
                    ['124','default.jpg','GNOCCHI DI RISO CON CARNE','Non ci sono descrizione al momento','normal','0','c42'],
                    ['125','default.jpg','GNOCCHI DI RISO CON PESCE','Non ci sono descrizione al momento','normal','0','c43'],
                    ['126','default.jpg','SPAGHETTI DI SALTATI CON VERDURE','Non ci sono descrizione al momento','normal','0','c44'],
                    ['127','default.jpg','SPAGHETTI DI SALTATI CON GAMBERI','Non ci sono descrizione al momento','normal','0','c45'],
                    ['128','default.jpg','SPAGHETTI SON FRUTTI DI MARE ALLA PIASTRA','Non ci sono descrizione al momento','normal','0','c46'],
                    ['129','default.jpg','SPAGHETTI DI SOLA CON VERDURE','Non ci sono descrizione al momento','normal','0','c47'],
                    ['130','default.jpg','SPAGHETTI DI SOLA CON GAMBERI','Non ci sono descrizione al momento','normal','0','c48'],
                    ['131','default.jpg','SPAGHETTI DI SOLA CON FRUTTI DI MARE ALLA PIASTRA','Non ci sono descrizione al momento','normal','0','c49'],
                    ['132','default.jpg','SPAGHETTI DI SOLA SALSA CHILLI','Non ci sono descrizione al momento','normal','0','c50'],
                    ['133','default.jpg','PANE CINESE FRITTE','Non ci sono descrizione al momento','normal','0','c51'],
                    ['134','default.jpg','RISO BIANCO','Non ci sono descrizione al momento','normal','0','c52'],
                    ['135','default.jpg','POLLO CON FUNGHI E BAMBU','Non ci sono descrizione al momento','normal','0','c53'],
                    ['136','default.jpg','POLLO AL CURRY','Non ci sono descrizione al momento','normal','0','c54'],
                    ['137','default.jpg','POLLO AL LIMONE','Non ci sono descrizione al momento','normal','0','c55'],
                    ['138','default.jpg','POLLO ALLE MANDORLE','Non ci sono descrizione al momento','normal','0','c56'],
                    ['139','default.jpg','POLLO ANANAS','Non ci sono descrizione al momento','normal','0','c57'],
                    ['140','default.jpg','POLLO CON VERDURE MISTO','Non ci sono descrizione al momento','normal','0','c58'],
                    ['141','default.jpg','POLLO IN SALSA PICCANTE','Non ci sono descrizione al momento','normal','0','c59'],
                    ['142','default.jpg','POLLO IN SALSA AGRODOLCE','Non ci sono descrizione al momento','normal','0','c60'],
                    ['143','default.jpg','POLLO CON PEPERONY','Non ci sono descrizione al momento','normal','0','c61'],
                    ['144','default.jpg','TRE DELIZIE IN TEGAMINO','Non ci sono descrizione al momento','normal','0','c62'],
                    ['145','default.jpg','POLLO FRITTO','Non ci sono descrizione al momento','normal','0','c63'],
                    ['146','default.jpg','POLLO ALLA PIASTRA','Non ci sono descrizione al momento','normal','0','c64'],
                    ['147','default.jpg','MANZO CON FUNGHI E BANBU','Non ci sono descrizione al momento','normal','0','c65'],
                    ['148','default.jpg','MANZO AL CURRY','Non ci sono descrizione al momento','normal','0','c66'],
                    ['149','default.jpg','MANZO IN SALSA DI OSTRICA','Non ci sono descrizione al momento','normal','0','c67'],
                    ['150','default.jpg','MANZO CON CIPOLLE','Non ci sono descrizione al momento','normal','0','c68'],
                    ['151','default.jpg','MANZO CON PEPEROIN','Non ci sono descrizione al momento','normal','0','c69'],
                    ['152','default.jpg','MANZO CON VERDURE MISTE IN TEGAMINO','Non ci sono descrizione al momento','normal','0','c70'],
                    ['153','default.jpg','MANZO CON SALSA PICCANTE','Non ci sono descrizione al momento','normal','0','c71'],
                    ['154','default.jpg','MANZO ALLA PIASTRA','Non ci sono descrizione al momento','normal','0','c72'],
                    ['155','default.jpg','MAIALE CON FUNGHI E BAMBÙ','Non ci sono descrizione al momento','normal','0','c73'],
                    ['156','default.jpg','MAIALE IN SALSA AGRODOLCE','Non ci sono descrizione al momento','normal','0','c74'],
                    ['157','default.jpg','MAIALE CON VERDURE MISTE','Non ci sono descrizione al momento','normal','0','c75'],
                    ['158','default.jpg','MAIALE IN SALSA CHILI','Non ci sono descrizione al momento','normal','0','c76'],
                    ['159','default.jpg','MAIALE CON PEPERON','Non ci sono descrizione al momento','normal','0','c77'],
                    ['160','default.jpg','ANATRA SALSA PICCANTE ','Non ci sono descrizione al momento','normal','0','c78'],
                    ['161','default.jpg','ANATRA CON FUNGHI E BAMBÙ','Non ci sono descrizione al momento','normal','0','c79'],
                    ['162','default.jpg','ANATRA AL CURRY','Non ci sono descrizione al momento','normal','0','c80'],
                    ['163','default.jpg','ANATRA ARROSTO','Non ci sono descrizione al momento','normal','0','c81'],
                    ['164','default.jpg',' ANATRA VERDURE MISTE','Non ci sono descrizione al momento','normal','0','c82'],
                    ['165','default.jpg','ANATRA ALLA PIASTRA','Non ci sono descrizione al momento','normal','0','c83'],
                    ['166','default.jpg','GAMBERETTI CON FUNGHI E BAMBU','Non ci sono descrizione al momento','normal','0','c84'],
                    ['167','default.jpg','GAMBERETTI AL CURRY','Non ci sono descrizione al momento','normal','0','c85'],
                    ['168','default.jpg','GAMBERETTI IN SALSA AGRODOLCE','Non ci sono descrizione al momento','normal','0','c86'],
                    ['169','default.jpg','GAMBERETTI CON FUNGHI E BAMBÚ','Non ci sono descrizione al momento','normal','0','c87'],
                    ['170','default.jpg','GAMBERETTI IN SALSA PICCAN','Non ci sono descrizione al momento','normal','0','c88'],
                    ['171','default.jpg','GAMBERETTI CON ASPARAGI','Non ci sono descrizione al momento','normal','0','c89'],
                    ['172','default.jpg','GAMBERETTI FRITTI','Non ci sono descrizione al momento','normal','0','c90'],
                    ['173','default.jpg','GAMBERETTICOLORI','Non ci sono descrizione al momento','normal','0','c91'],
                    ['174','default.jpg','GAMBERETTI AL LIMOME','Non ci sono descrizione al momento','normal','0','c92'],
                    ['175','default.jpg','SPIEDINI RI GAMBERI','Non ci sono descrizione al momento','normal','0','c93'],
                    ['176','default.jpg','GAMBERETTI CON VERDURE MISTE','Non ci sono descrizione al momento','normal','0','c94'],
                    ['177','default.jpg','GAMBERETTI AL PEPE','Non ci sono descrizione al momento','normal','0','c95'],
                    ['178','default.jpg','GAMBERETTI ALLA PIASTRA','Non ci sono descrizione al momento','normal','0','c96'],
                    ['179','default.jpg','GAMBERONI IN SALSA CHILI','Non ci sono descrizione al momento','normal','0','c97'],
                    ['180','default.jpg','GAMBERONI STUFATI CON VERDUR ','Non ci sono descrizione al momento','normal','0','c98'],
                    ['181','default.jpg','GAMBERONI AL VAPORE','Non ci sono descrizione al momento','normal','0','c99'],
                    ['182','default.jpg','GAMBERONI ALLA PIASTRA','Non ci sono descrizione al momento','normal','0','c100'],
                    ['183','default.jpg','GAMBERONI ALLA PEPE','Non ci sono descrizione al momento','normal','0','c101'],
                    ['184','default.jpg','CALAMARI IN SALSA CHILI','Non ci sono descrizione al momento','normal','0','c102'],
                    ['185','default.jpg','CALAMARI E GAMBERI ALLA PIASTRA','Non ci sono descrizione al momento','normal','0','c103'],
                    ['186','default.jpg','FRUTTI DI MARE FRITTE','Non ci sono descrizione al momento','normal','0','c104'],
                    ['187','default.jpg','PESCE MISTO IN TEGAMINO','Non ci sono descrizione al momento','normal','0','c105'],
                    ['188','default.jpg','NIDO DI RONDINE ','Non ci sono descrizione al momento','normal','0','c106'],
                    ['189','default.jpg','FELICE DELLA FAMIGL','Non ci sono descrizione al momento','normal','0','c107'],
                    ['190','default.jpg','BISTECCA DI MAZZO','Non ci sono descrizione al momento','normal','0','c108'],
                    ['191','default.jpg','BISTECCA DI POLLO','Non ci sono descrizione al momento','normal','0','c109'],
                    ['192','default.jpg','ARROSTICINI DI AGNELLO','Non ci sono descrizione al momento','normal','0','c110'],
                    ['193','default.jpg','ARROSTICINI DI POLLO','Non ci sono descrizione al momento','normal','0','c111'],
                    ['194','default.jpg','TAO FU ALLA GRIGLIA','Non ci sono descrizione al momento','normal','0','c112'],
                    ['195','default.jpg','CALAMARI ALLA GRIGLIA','Non ci sono descrizione al momento','normal','0','c113'],
                    ['196','default.jpg','PESCE BIANCO ALLA GRIGLIA','Non ci sono descrizione al momento','normal','0','c114'],
                    ['197','default.jpg','GAMBERONI ALLA GRIGLIA','Non ci sono descrizione al momento','normal','0','c115'],
                    ['198','default.jpg','SALMONE ALLA GRIGLIA','Non ci sono descrizione al momento','normal','0','c116'],
                    ['199','default.jpg','TONNO ALLA GRIGLIA','Non ci sono descrizione al momento','normal','0','c117'],
                    ['200','default.jpg','STRISCE DI PATATE AGROPICCANTE','Non ci sono descrizione al momento','normal','0','c118'],
                    ['201','default.jpg','TAO FU SALSA CHILI','Non ci sono descrizione al momento','normal','0','c119'],
                    ['202','default.jpg','TAO FU STUFATI CON VERDURE','Non ci sono descrizione al momento','normal','0','c120'],
                    ['203','default.jpg','OMELETTE DI GAMBERI','Non ci sono descrizione al momento','normal','0','c121'],
                    ['204','default.jpg','OMELETTE DI GRANCHIO','Non ci sono descrizione al momento','normal','0','c122'],
                    ['205','default.jpg','VERDURE BAMBU','Non ci sono descrizione al momento','normal','0','c123'],
                    ['206','default.jpg','VERDURE SPECIALE','Non ci sono descrizione al momento','normal','0','c124'],
                    ['207','default.jpg','FUNGHI E BAMBU','Non ci sono descrizione al momento','normal','0','c125'],
                    ['208','default.jpg','TARTUFO BIANCO','Non ci sono descrizione al momento','normal','0','c126'],
                    ['209','default.jpg','TARTUFO CACAO','Non ci sono descrizione al momento','normal','0',null],
                    ['210','default.jpg','NUTELLA FRITTO','Non ci sono descrizione al momento','normal','0',null],
                    ['211','default.jpg','GELATO FRITTO ','Non ci sono descrizione al momento','normal','0',null],
                    ['212','default.jpg','DOLCE DI COCCO','Non ci sono descrizione al momento','normal','0',null],
                    ['213','default.jpg','FRUTTA FRITTO','Non ci sono descrizione al momento','normal','0',null],
                    ['214','default.jpg','FRUTTA CINESE MISTO','Non ci sono descrizione al momento','normal','0',null],
                    ['215','default.jpg','FRUTTA CARAMELLATA','Non ci sono descrizione al momento','normal','0',null],
                    ['216','default.jpg','DOLCE DI RISO VAPORE','Non ci sono descrizione al momento','normal','0',null],
                    ['217','default.jpg','SWEET PESCHE VAPORE ','Non ci sono descrizione al momento','normal','0',null],
                    ['218','default.jpg','SORBETTO LIMONE','Non ci sono descrizione al momento','normal','0',null],
                    ['219','default.jpg','BISCOTTINI DELLA FORTUNA','Non ci sono descrizione al momento','normal','0',null],
                    ['220','default.jpg','ACQUA NATURALE/FRIZZANTE 1 LT','Non ci sono descrizione al momento','normal','0',null],
                    ['221','default.jpg','COCA COLA 0.33L','Non ci sono descrizione al momento','normal','0',null],
                    ['222','default.jpg','COCA COLA 1L ','Non ci sono descrizione al momento','normal','0',null],
                    ['223','default.jpg','THE LIMONE 0.33L','Non ci sono descrizione al momento','normal','0',null],
                    ['224','default.jpg','THE PESCA 0.33L','Non ci sono descrizione al momento','normal','0',null],
                    ['225','default.jpg','SPRITE 0.33L','Non ci sono descrizione al momento','normal','0',null],
                    ['226','default.jpg','FANTA 0.33L','Non ci sono descrizione al momento','normal','0',null],
                    ['227','default.jpg','PEPSI 0.33L','Non ci sono descrizione al momento','normal','0',null],
                    ['228','default.jpg','RED BULL','Non ci sono descrizione al momento','normal','0',null],
                    ['229','default.jpg','CAFFE','Non ci sono descrizione al momento','normal','0',null],
                    ['230','default.jpg','BIRRA TSINGTAO 0.66L','Non ci sono descrizione al momento','normal','0',null],
                    ['231','default.jpg','BIRRA MORETTI 0.66L','Non ci sono descrizione al momento','normal','0',null],
                    ['232','default.jpg','BIRRA ASAHI 0.5L','Non ci sono descrizione al momento','normal','0',null],
                    ['233','default.jpg','VINO BIANCO SFUSO 0.5L','Non ci sono descrizione al momento','normal','0',null],
                    ['234','default.jpg','VINO ROSSO SFUSO 0.5L','Non ci sono descrizione al momento','normal','0',null],
                    ['235','default.jpg','TERRE PICENE FALERIO','Non ci sono descrizione al momento','normal','0',null],
                    ['236','default.jpg','MATEUS ROSE','Non ci sono descrizione al momento','normal','0',null],
                    ['237','default.jpg','VILLA ANGELA','Non ci sono descrizione al momento','normal','0',null],
                    ['238','default.jpg','CIUCIU PASSERINA','Non ci sono descrizione al momento','normal','0',null],
                    ['239','default.jpg','CIUCIU MERLETTAIE ','Non ci sono descrizione al momento','normal','0',null],
                    ['240','default.jpg','GAROFOLI MACRINA','Non ci sono descrizione al momento','normal','0',null],
                ]
    
            ],
            'menu'=>
            [
                'key' => ['id','name','start_time','end_time','status','fixed_price','weight'],
                'value' =>
                [
                    
                    ['1','Asporto','00:00','23:59','1','0',0],
                    ['2','Carta','00:00','23:59','1','5.00',2],
                    ['3','Dinner','00:00','23:59','1','20.00',4],
                    ['4','Breakfast','00:00','23:59','1','15.00',3],
                ]
            ],
            'dish_menu'=>
            [
                'key' => ['dish_id','menu_id','price','discounted_price','start_discount','end_discount'],
                'value' =>
                [
                    ['1','2','0',null,null,null],
                    ['1','1','10.50','8.50',Carbon::now()->subDays(rand(0,30)),Carbon::now()->addDays(rand(0,30))],
                    ['1','3','11.00',null,null,null],
                    ['1','4','12.00',null,null,null],

                    ['2','1','5.00','1.00',Carbon::now()->subDays(rand(0,10)),Carbon::now()->addDays(rand(0,15))],
                    ['2','2','10.50','8.50',Carbon::now()->subDays(rand(0,19)),Carbon::now()->addDays(rand(0,17))],
                    ['2','3','15.50','10.00',Carbon::now()->subDays(rand(0,18)),Carbon::now()->addDays(rand(0,16))],
                    ['2','4','15.50','10.00',Carbon::now()->subDays(rand(0,18)),Carbon::now()->addDays(rand(0,16))], 

                    ['3','1','0',null,null,null],
                    ['3','2','13.50','8.50',Carbon::now()->subDays(rand(0,20)),Carbon::now()->addDays(rand(0,26))],
                    ['3','3','20.00',null,null,null],
                    ['3','4','30.00','25.00',Carbon::now()->subDays(rand(0,18)),Carbon::now()->addDays(rand(0,16))],

                    ['4','1','0',null,null,null],
                    ['4','2','25.50',null,null,null],
                    ['4','3','30.00',null,null,null],
                    ['4','4','35.00',null,null,null],
                    
                    ['5','1','0',null,null,null],
                    ['5','2','20.50','16.50',Carbon::now()->subDays(rand(0,5)),Carbon::now()->addDays(rand(0,5))],
                    ['5','3','35.00','14.50',Carbon::now()->subDays(rand(0,3)),Carbon::now()->addDays(rand(0,8))],
                    ['5','4','40.00','25.00',Carbon::now()->subDays(rand(0,10)),Carbon::now()->addDays(rand(0,15))],

                    ['6','1','0',null,null,null],
                    ['6','2','50.99','35.00',Carbon::now()->subDays(rand(0,15)),Carbon::now()->addDays(rand(0,25))],
                    ['6','3','60.99','40.00',Carbon::now()->subDays(rand(0,13)),Carbon::now()->addDays(rand(0,18))],
                    ['6','4','75.00','65.00',Carbon::now()->subDays(rand(0,15)),Carbon::now()->addDays(rand(0,25))],

                    ['7','1','50.00',null,null,null],
                    ['7','2','95.00',null,null,null],
                    ['7','3','100.00',null,null,null],
                    ['7','4','110.00','95.00',Carbon::now()->subDays(rand(0,30)),Carbon::now()->addDays(rand(0,30))],

                    ['8','1','0',null,null,null],
                    ['8','2','5.99','1.99',Carbon::now()->subDays(rand(0,10)),Carbon::now()->addDays(rand(0,15))],
                    ['8','3','6.99','2.99',Carbon::now()->subDays(rand(0,10)),Carbon::now()->addDays(rand(0,15))],
                    ['8','4','35.00',null,null,null],
                    
                    ['9','1','0',null,null,null],
                    ['9','2','35.00','25.00',Carbon::now()->subDays(rand(0,12)),Carbon::now()->addDays(rand(0,14))],
                    ['9','3','40.00','35.00',Carbon::now()->subDays(rand(0,13)),Carbon::now()->addDays(rand(0,15))],
                    ['9','4','41.00','35.00',Carbon::now()->subDays(rand(0,21)),Carbon::now()->addDays(rand(0,30))],

                    ['10','1','0',null,null,null],
                    ['10','2','13.5','10.5',Carbon::now()->subDays(rand(0,10)),Carbon::now()->addDays(rand(0,15))],
                    ['10','3','15.00',null,null,null],
                    ['10','4','17.00','15.00',Carbon::now()->subDays(rand(0,20)),Carbon::now()->addDays(rand(0,30))],
                    
                    ['11','1','0',null,null,null],
                    ['11','2','8.00',null,null,null],
                    ['11','3','9.00',null,null,null],
                    ['11','4','10.00',null,null,null],

                    ['12','1','0',null,null,null],
                    ['12','2','10.00',null,null,null],
                    ['12','3','10.99',null,null,null],
                    ['12','4','10.00',null,null,null],


                    ['13','1','0.99',null,null,null],
                    ['13','2','0.99','0.01',Carbon::now()->subDays(rand(0,2)),Carbon::now()->addDays(rand(0,3))],
                    ['13','3','0.99',null,null,null],
                    ['13','4','0.99',null,null,null],


                    ['14','1','2.00',null,null,null],
                    ['14','2','2.00',null,null,null],
                    ['14','3','2.00',null,null,null],
                    ['14','4','2.00',null,null,null],


                    ['15','1','4.00',null,null,null],
                    ['15','2','4.00',null,null,null],
                    ['15','3','4.00',null,null,null],
                    ['15','4','4.00',null,null,null],


                    ['16','1','5.00',null,null,null],
                    ['16','2','5.00','0.99',Carbon::now()->subDays(rand(0,2)),Carbon::now()->addDays(rand(0,3))],
                    ['16','3','5.00',null,null,null],
                    ['16','4','5.00',null,null,null],


                    ['17','1','15.00','10.00',Carbon::now()->subDays(rand(0,5)),Carbon::now()->addDays(rand(0,10))],
                    ['17','2','15.00','10.00',Carbon::now()->subDays(rand(0,5)),Carbon::now()->addDays(rand(0,10))],
                    ['17','3','15.00','10.00',Carbon::now()->subDays(rand(0,5)),Carbon::now()->addDays(rand(0,10))],
                    ['17','4','15.00','10.00',Carbon::now()->subDays(rand(0,5)),Carbon::now()->addDays(rand(0,10))],

                    ['18','1','10.00',null,null,null],
                    ['18','2','10.00',null,null,null],
                    ['18','3','10.00',null,null,null],
                    ['18','4','10.00',null,null,null],

                ]
            ],
            'dish_variant' =>
            [
                'key' => ['name'],
                'value' =>
                [
                    ['red pepper'],
                    ['white pepper'],
                    ['salt'],
                    ['sugar'],
                    ['vinegar'],
                    ['soy sauce'],
                ]
    
            ],

            'variant' =>
            [
                'key' => ['dish_id','dish_variant_name'],
                'value' =>
                [
                    ['1','salt'],
                    ['1','sugar'],
                    ['1','red pepper'],
                    ['1','vinegar'],
                    ['1','soy sauce'],

                    ['2','salt'],
                    ['2','sugar'],
                    ['2','red pepper'],
                    ['2','white pepper'],

                    ['3','salt'],
                    ['3','sugar'],
                    ['3','red pepper'],
                    ['3','vinegar'],

                    ['4','salt'],
                    ['4','sugar'],
                    ['4','red pepper'],
                    ['4','white pepper'],
                ]
    
            ],

            'category' =>
            [
                'key' => ['Catname'],
                'value' =>
                [
                    ['Carne'], //1
                    ['Verdure'], //2
                    ['Bevante'], //3
                    ['Tipo'] //4
                ]
    
            ],

            'subcategory' =>
            [
                'key' => ['id','name','Category_id','weight'],
                'value' =>
                [
                    [1, 'maiale', 1, 0],
                    [2, 'cinese', 4, 0],
                    [3, 'shushi', 4, 0],
                    [4, 'mandorle', 2, 0],
                    [5, 'pinoli', 2, 3],
                    [6, 'mais', 2, 4],
                    [7, 'toufu', 2, 5],
                    [8, 'cavoli', 2, 0],
                    [9, 'spinaci', 2, 0],
                    [10, 'salmone', 1, 0],
                    [11, 'tonno', 1, 0],
                    [12, 'avocado', 2, 0],
                    [13, 'gambero', 1, 0],
                    [14, 'anatra', 1, 0],
                    [15, 'cetriolo', 2, 0],
                    [16, 'analcolica', 3, 0],
                    [17, 'alcolica', 3, 0],
                    [18, 'granchio', 1, 0],
                    [19, 'cipolline', 2, 0],
                    [20, 'pollo', 1, 0],
                    [21, 'alghe', 2, 0],
                    [22, 'zucchine', 2, 0],
                    [23, 'insalata', 2, 0],
                    [24, 'peperoni', 2, 0],
                    [25, 'calamari', 1, 0],
                    [26, 'uova', 1, 0],
                    [27, 'funghi', 2, 0],
                    [28, 'asparagi', 2, 0],
                    [29, 'carote', 2, 0],
                    [30, 'piselli', 2, 0],
                    [31, 'ananas', 2, 0],
                    [32, 'bambu', 2, 0],
                    [33, 'limone', 2, 0],
                    [34, 'arachidi', 2, 0],
                    [35, 'manzo', 1, 0],
                    [36, 'branzino', 1, 0],
                    [37, 'salmone', 1, 0]
                    
                    ]
    
            ],

            'type' =>
            [
                'key' => ['dish_id','subcategory_id'],
                'value' =>
                [
                    ['1','3'],
                    ['2','3'],
                    ['3','3'],
                    ['4','3'],
                    ['5','3'],
                    ['6','3'],
                    ['7','3'],
                    ['8','3'],
                    ['9','3'],
                    ['10','3'],
                    ['11','3'],
                    ['12','3'],
                    ['13','3'],
                    ['14','3'],
                    ['15','3'],
                    ['16','3'],
                    ['17','3'],
                    ['18','3'],
                    ['19','3'],
                    ['20','3'],
                    ['21','3'],
                    ['22','3'],
                    ['23','3'],
                    ['24','3'],
                    ['25','3'],
                    ['26','3'],
                    ['27','3'],
                    ['28','3'],
                    ['29','3'],
                    ['30','3'],
                    ['31','3'],
                    ['32','3'],
                    ['33','3'],
                    ['34','3'],
                    ['35','3'],
                    ['36','3'],
                    ['37','3'],
                    ['38','3'],
                    ['39','3'],
                    ['40','3'],
                    ['41','3'],
                    ['42','3'],
                    ['43','3'],
                    ['44','3'],
                    ['45','3'],
                    ['46','3'],
                    ['47','3'],
                    ['48','3'],
                    ['49','3'],
                    ['50','3'],
                    ['51','3'],
                    ['52','3'],
                    ['53','3'],
                    ['54','3'],
                    ['55','3'],
                    ['56','3'],
                    ['57','3'],
                    ['58','3'],
                    ['59','3'],
                    ['60','3'],
                    ['61','3'],
                    ['62','3'],
                    ['63','3'],
                    ['64','3'],
                    ['65','3'],
                    ['66','3'],
                    ['67','3'],
                    ['68','3'],
                    ['69','3'],
                    ['70','3'],
                    ['71','3'],
                    ['72','3'],
                    ['73','3'],
                    ['74','3'],
                    ['75','3'],
                    ['76','3'],
                    ['77','3'],
                    ['78','3'],
                    ['79','3'],
                    ['80','3'],
                    ['81','3'],
                    ['82','3'],
                    ['83','3'],//end
                    ['84','2'],
                    ['85','2'],
                    ['86','2'],
                    ['87','2'],
                    ['88','2'],
                    ['89','2'],
                    ['90','2'],
                    ['91','2'],
                    ['92','2'],
                    ['93','2'],
                    ['94','2'],
                    ['95','2'],
                    ['96','2'],
                    ['97','2'],
                    ['98','2'],
                    ['99','2'],
                    ['100','2'],
                    ['101','2'],
                    ['102','2'],
                    ['103','2'],
                    ['104','2'],
                    ['105','2'],
                    ['106','2'],
                    ['107','2'],
                    ['108','2'],
                    ['109','2'],
                    ['110','2'],
                    ['111','2'],
                    ['112','2'],
                    ['113','2'],
                    ['114','2'],
                    ['115','2'],
                    ['116','2'],
                    ['117','2'],
                    ['118','2'],
                    ['119','2'],
                    ['120','2'],
                    ['121','2'],
                    ['122','2'],
                    ['123','2'],
                    ['124','2'],
                    ['125','2'],
                    ['126','2'],
                    ['127','2'],
                    ['128','2'],
                    ['129','2'],
                    ['130','2'],
                    ['131','2'],
                    ['132','2'],
                    ['133','2'],
                    ['134','2'],
                    ['135','2'],
                    ['136','2'],
                    ['137','2'],
                    ['138','2'],
                    ['139','2'],
                    ['140','2'],
                    ['141','2'],
                    ['142','2'],
                    ['143','2'],
                    ['144','2'],
                    ['145','2'],
                    ['146','2'],
                    ['147','2'],
                    ['148','2'],
                    ['149','2'],
                    ['150','2'],
                    ['151','2'],
                    ['152','2'],
                    ['153','2'],
                    ['154','2'],
                    ['155','2'],
                    ['156','2'],
                    ['157','2'],
                    ['158','2'],
                    ['159','2'],
                    ['160','2'],
                    ['161','2'],
                    ['162','2'],
                    ['163','2'],
                    ['164','2'],
                    ['165','2'],
                    ['166','2'],
                    ['167','2'],
                    ['168','2'],
                    ['169','2'],
                    ['170','2'],
                    ['171','2'],
                    ['172','2'],
                    ['173','2'],
                    ['174','2'],
                    ['175','2'],
                    ['176','2'],
                    ['177','2'],
                    ['178','2'],
                    ['179','2'],
                    ['180','2'],
                    ['181','2'],
                    ['182','2'],
                    ['183','2'],
                    ['184','2'],
                    ['185','2'],
                    ['186','2'],
                    ['187','2'],
                    ['188','2'],
                    ['189','2'],
                    ['190','2'],
                    ['191','2'],
                    ['192','2'],
                    ['193','2'],
                    ['194','2'],
                    ['195','2'],
                    ['196','2'],
                    ['197','2'],
                    ['198','2'],
                    ['199','2'],
                    ['200','2'],
                    ['211','2'],
                    ['212','2'],
                    ['213','2'],
                    ['214','2'],
                    ['215','2'],
                    ['216','2'],
                    ['217','2'],
                    ['218','2'],
                    ['219','2'],
                    ['220','16'],
                    ['221','16'],
                    ['222','16'],
                    ['223','16'],
                    ['224','16'],
                    ['225','16'],
                    ['226','16'],
                    ['227','16'],
                    ['228','16'],
                    ['229','16'],
                    ['230','17'],
                    ['231','17'],
                    ['232','17'],
                    ['233','17'],
                    ['234','17'],
                    ['235','17'],
                    ['236','17'],
                    ['237','17'],
                    ['238','17'],
                    ['239','17'],
                    ['240','17'],
                ]
    
            ],

            'table_history'=>
            [
                'key' => ['start_time','end_time','table_discount','table_id','num_person'],                 
                'value' =>
                [
                    [Carbon::now()->subHours(random_int(1, 3)),Carbon::now()->addHours(random_int(0, 2)),0,1,rand(1,5)],//1
                    [Carbon::now()->subHours(random_int(1, 3)),Carbon::now()->addHours(random_int(0, 2)),0,1,rand(1,5)],//2
                    [Carbon::now()->subHours(random_int(1, 3)),Carbon::now()->addHours(random_int(0, 2)),0,2,rand(1,5)],//3
                    [Carbon::now()->subHours(random_int(1, 3)),Carbon::now()->addHours(random_int(0, 2)),0,2,rand(1,5)],//4
                    [Carbon::now()->subHours(random_int(1, 3)),Carbon::now()->addHours(random_int(0, 2)),0,3,rand(1,5)],//5
                    [Carbon::now()->subHours(random_int(1, 3)),Carbon::now()->addHours(random_int(0, 2)),0,4,rand(1,5)],//6
                    [Carbon::now()->subHours(random_int(1, 3)),Carbon::now()->addHours(random_int(0, 2)),0,6,rand(1,5)],//7
                    [Carbon::now()->subHours(random_int(1, 3)),Carbon::now()->addHours(random_int(0, 2)),0,3,rand(1,5)],//8
                    [Carbon::now()->subHours(random_int(1, 3)),Carbon::now()->addHours(random_int(0, 2)),0,4,rand(1,5)],//9
                    [Carbon::now()->subHours(random_int(1, 3)),Carbon::now()->addHours(random_int(0, 2)),0,6,rand(1,5)],//10
                    [Carbon::now()->subHours(random_int(1, 3)),Carbon::now()->addHours(random_int(0, 2)),0,3,rand(1,5)],//11
                    [Carbon::now()->subHours(random_int(1, 3)),Carbon::now()->addHours(random_int(0, 2)),0,4,rand(1,5)],//12
                    [Carbon::now()->subHours(random_int(1, 3)),Carbon::now()->addHours(random_int(0, 2)),0,6,rand(1,5)],//13
                    [Carbon::now()->subHours(random_int(1, 3)),Carbon::now()->addHours(random_int(0, 2)),0,7,rand(1,5)],//14
                    [Carbon::now()->subHours(random_int(1, 3)),Carbon::now()->addHours(random_int(0, 2)),0,7,rand(1,5)],//15

                    [Carbon::now()->subMinutes(random_int(8, 60)),null,0,1,2],//16
                    [Carbon::now()->subMinutes(random_int(8, 60)),null,0,4,3],//17
                    [Carbon::now()->subMinutes(random_int(8, 60)),null,0,5,4],//18
                    [Carbon::now()->subMinutes(random_int(8, 60)),null,0,6,3],//19
                    [Carbon::now()->subMinutes(random_int(8, 60)),null,0,7,5],//20
                ]
            ],
            'OrderingNow'=>
            [
                'key' => ['id','order_at','price','status','menu','dish_id','number','user_id','table_history_id'],                 
                'value' =>
                [
                    ['8',Carbon::now(),'10.50','pending','2','1','1','1','20'],
                    ['9',Carbon::now(),'11.50','pending','2','3','1','1','20'],
                    ['10',Carbon::now(),'12.50','pending','2','6','1','1','20'],
                    ['11',Carbon::now(),'0','pending','1','6','1','1','20'],
                    ['12',Carbon::now(),'0','pending','1','6','1','1','20'],
                    ['13',Carbon::now(),'15.50','pending','2','6','1','1',null],
                    ['22',"2021-08-16 00:17:07","0.00","pending",'1','2','1',NULL,'16'],
                    ['23',"2021-08-16 00:17:07","1.00","pending",'1','2','2',NULL,'16'],
                    ['24',"2021-08-16 00:17:07","8.50","pending",'2','1','2',NULL,'16'],
                    ['25',"2021-08-16 00:17:07","8.50","pending",'2','1','1',NULL,'16']
                ]
            ],

            'printer_queue'=>
            [
                'key' => ['id','printed_at','printer','order_ids','table_number','status','old','type'],                 
                'value' =>
                [
                    ['1',Carbon::now()->subMinutes(random_int(8, 60)),'0','1,2,3,4','10','2','1','0'],
                    ['2',Carbon::now()->subMinutes(random_int(8, 60)),'0','5,6,7','11','2','1','0'],
                    ['3',null,'0','8,9,10','12','0','0','0'],
                    ['4',null,'1','11,12,13','25A','0','0','0'],
                    ['7',null,'1','11,12,13','10','0','0','1'],
                ]
            ],

            'address'=>
            [
                'key' => ['address_id','region','city','province','via','number','name','phone','surname','user_id'],                 
                'value' =>
                [
                    [1,'abc','como','acc','casd','10','rosi',3778141176,'james',1],
                    [2,'abc','como','acc','afasd','11','fabio',3779852360,'david',1],
                    [3,'cba','Fermo','acc','wfvas','12','fabio',3778523641,'jane',1],
                    [4,'bca','Ferrara','acc','wasd','13','fabio',3779874630,'ann',1],
                    [5,'qwe','Genova','acc','awsdasd','14','fabio',3779842365,'daniel',1],
                    [6,'ewq','Isernia','acc','iwasds','15','fabio',3779517538,'john',2],
                    [7,'eqw','Massa','acc','drgdg','16','fabio',3778452159,'sarah',2],
                    [8,'eqw','Massa','acc','jkhkj','17','fabio',3778452159,'sarah',2],
                    [9,'OOF','Lecco','acc','lvncc','18','fabio',3778819565,'mary',1],
                ]
            ],
                     
            'ordering'=>
            [
                'key' => ['id','order_at','price','status','menu','dish_id','user_id','variant','table_history_id'],                 
                'value' =>
                [
                   ['1','2021-7-25 15:57:30',65412.22,'wait','pack',1,1,'58644',1],
                   ['2','2021-7-26 15:57:35',65472.22,'wait','pack',2,2,'58554',1],
                   ['3','2021-7-26 16:57:35',67772.99,'wait','pack',3,3,'586',2],
                   ['4','2021-7-26 15:57:50',65852.55,'wait','pack',4,4,'644',2],
                   ['5','2021-7-26 15:59:00',87451.88,'wait','pack',5,5,'58644',3],
                   ['6','2021-7-26 16:00:35',85785.22,'wait','pack',6,6,'8574',4],
                   ['7','2021-7-26 15:05:35',65472.22,'wait','pack',7,7,'5864',6],
                ]
            ],          
            'settings'=>
            [
                'key' => ['name','value'],                 
                'value' =>
                [
                    ['sad1',110],
                    ['sad2',10],
                    ['speed',1000],
                    ['ababb',20],
                    ['oof','jhkh'],
                    ['baba',10],
                    ['sadad',50],
                    ['fghjhjk',154],
                    ['rfghnm',52,],
                    ['oknjokij',489],
                ]
            ],
            'appointment'=>
            [
                'key' => ['id','user_id','time','number_person'],                 
                'value' =>
                [
                    ['1',1,'2021-7-25 15:57:35',3],
                    ['2',2,'2021-7-26 15:57:35',7],
                    ['3',3,'2021-7-26 16:57:35',3],
                    ['4',4,'2021-7-26 15:57:50',7],
                    ['5',5,'2021-7-26 15:59:00',3],
                    ['6',6,'2021-7-26 16:00:35',7],
                    ['7',7,'2021-7-26 15:05:40',5],
                ]
            ],
           'ordervariant'=>
            [
                'key' => ['ordering_id','dish_variant_name','dose'],                 
                'value' =>
                [
                    ['8','red pepper',58],
                    ['9','white pepper',-12],
                    ['10','salt',31],
                    ['11','sugar',50],
                    ['12','vinegar',23],
                    ['13','soy sauce',-5],
                   
                ]
            ],
            'namelang'=>
            [
                'key' => ['name'],                 
                'value' =>
                [
                    ['asdad'],
                    ['abcd'],
                    ['OOF'],
                    ['FOO'],
                    ['QQWWEE'],
                    ['yujie'],
                    ['uyuiui'],
                    ['acd'],
                    ['ababab'],
                    ['babababab'],
                    ['mcrrcq'],
                    ['lznb'],
                    ['awdad'],
                    ['ababba'],
                    ['fabio'],
                ]
            ],
            'langvar'=>
            [
            'key' => ['name','lang','value'],                 
                'value' =>
                [
                    ['asdad','651','651'],
                    ['abcd','648','989'],
                    ['OOF','987','321'],
                    ['FOO','95','9521'],
                    ['QQWWEE','970','1598'],
                    ['yujie','az','857'],
                    ['uyuiui','101010','520'],
                    ['acd','angnn','1314'],
                    ['ababab','cmn','8426'],
                    ['babababab','op','6598'],
                    ['mcrrcq','7642','68468'],
                    ['acd','6662','1563'],
                    ['lznb','9812','8484'],
                    ['awdad','haha','null'],
                    ['ababba','agga','null'],
                    ['fabio','ouiiuyh','101010'],
                ]
             ],
            'province'=>
            [
                'key'=> ['id_province', 'nome_province', 'sigla_province', 'regione_province'],
                'value' =>
                [
                    [1, 'Agrigento', 'AG', 'Sicilia'],
                    [2, 'Alessandria', 'AL', 'Piemonte'],
                    [3, 'Ancona', 'AN', 'Marche'],
                    [4, 'Arezzo', 'AR', 'Toscana'],
                    [5, 'Ascoli Piceno', 'AP', 'Marche'],
                    [6, 'Asti', 'AT', 'Piemonte'],
                    [7, 'Avellino', 'AV', 'Campania'],
                    [8, 'Bari', 'BA', 'Puglia'],
                    [9, 'Barletta-Andria-Trani', 'BT', 'Puglia'],
                    [10, 'Belluno', 'BL', 'Veneto'],
                    [11, 'Benevento', 'BN', 'Campania'],
                    [12, 'Bergamo', 'BG', 'Lombardia'],
                    [13, 'Biella', 'BI', 'Piemonte'],
                    [14, 'Bologna', 'BO', 'Emilia-Romagna'],
                    [15, 'Bolzano', 'BZ', 'Trentino-Alto Adige'],
                    [16, 'Brescia', 'BS', 'Lombardia'],
                    [17, 'Brindisi', 'BR', 'Puglia'],
                    [18, 'Cagliari', 'CA', 'Sardegna'],
                    [19, 'Caltanissetta', 'CL', 'Sicilia'],
                    [20, 'Campobasso', 'CB', 'Molise'],
                    [21, 'Carbonia-Iglesias', 'CI', 'Sardegna'],
                    [22, 'Caserta', 'CE', 'Campania'],
                    [23, 'Catania', 'CT', 'Sicilia'],
                    [24, 'Catanzaro', 'CZ', 'Calabria'],
                    [25, 'Chieti', 'CH', 'Abruzzo'],
                    [26, 'Como', 'CO', 'Lombardia'],
                    [27, 'Cosenza', 'CS', 'Calabria'],
                    [28, 'Cremona', 'CR', 'Lombardia'],
                    [29, 'Crotone', 'KR', 'Calabria'],
                    [30, 'Cuneo', 'CN', 'Piemonte'],
                    [31, 'Enna', 'EN', 'Sicilia'],
                    [32, 'Fermo', 'FM', 'Marche'],
                    [33, 'Ferrara', 'FE', 'Emilia-Romagna'],
                    [34, 'Firenze', 'FI', 'Toscana'],
                    [35, 'Foggia', 'FG', 'Puglia'],
                    [36, 'Forlì-Cesena', 'FC', 'Emilia-Romagna'],
                    [37, 'Frosinone', 'FR', 'Lazio'],
                    [38, 'Genova', 'GE', 'Liguria'],
                    [39, 'Gorizia', 'GO', 'Friuli-Venezia Giulia'],
                    [40, 'Grosseto', 'GR', 'Toscana'],
                    [41, 'Imperia', 'IM', 'Liguria'],
                    [42, 'Isernia', 'IS', 'Molise'],
                    [43, 'L\'Aquila', 'AQ', 'Abruzzo'],
                    [44, 'La Spezia', 'SP', 'Liguria'],
                    [45, 'Latina', 'LT', 'Lazio'],
                    [46, 'Lecce', 'LE', 'Puglia'],
                    [47, 'Lecco', 'LC', 'Lombardia'],
                    [48, 'Livorno', 'LI', 'Toscana'],
                    [49, 'Lodi', 'LO', 'Lombardia'],
                    [50, 'Lucca', 'LU', 'Toscana'],
                    [51, 'Macerata', 'MC', 'Marche'],
                    [52, 'Mantova', 'MN', 'Lombardia'],
                    [53, 'Massa e Carrara', 'MS', 'Toscana'],
                    [54, 'Matera', 'MT', 'Basilicata'],
                    [55, 'Medio Campidano', 'VS', 'Sardegna'],
                    [56, 'Messina', 'ME', 'Sicilia'],
                    [57, 'Milano', 'MI', 'Lombardia'],
                    [58, 'Modena', 'MO', 'Emilia-Romagna'],
                    [59, 'Monza e Brianza', 'MB', 'Lombardia'],
                    [60, 'Napoli', 'NA', 'Campania'],
                    [61, 'Novara', 'NO', 'Piemonte'],
                    [62, 'Nuoro', 'NU', 'Sardegna'],
                    [63, 'Ogliastra', 'OG', 'Sardegna'],
                    [64, 'Olbia-Tempio', 'OT', 'Sardegna'],
                    [65, 'Oristano', 'OR', 'Sardegna'],
                    [66, 'Padova', 'PD', 'Veneto'],
                    [67, 'Palermo', 'PA', 'Sicilia'],
                    [68, 'Parma', 'PR', 'Emilia-Romagna'],
                    [69, 'Pavia', 'PV', 'Lombardia'],
                    [70, 'Perugia', 'PG', 'Umbria'],
                    [71, 'Pesaro e Urbino', 'PU', 'Marche'],
                    [72, 'Pescara', 'PE', 'Abruzzo'],
                    [73, 'Piacenza', 'PC', 'Emilia-Romagna'],
                    [74, 'Pisa', 'PI', 'Toscana'],
                    [75, 'Pistoia', 'PT', 'Toscana'],
                    [76, 'Pordenone', 'PN', 'Friuli-Venezia Giulia'],
                    [77, 'Potenza', 'PZ', 'Basilicata'],
                    [78, 'Prato', 'PO', 'Toscana'],
                    [79, 'Ragusa', 'RG', 'Sicilia'],
                    [80, 'Ravenna', 'RA', 'Emilia-Romagna'],
                    [81, 'Reggio Calabria(metropolitana]', 'RC', 'Calabria'],
                    [82, 'Reggio Emilia', 'RE', 'Emilia-Romagna'],
                    [83, 'Rieti', 'RI', 'Lazio'],
                    [84, 'Rimini', 'RN', 'Emilia-Romagna'],
                    [85, 'Roma', 'RM', 'Lazio'],
                    [86, 'Rovigo', 'RO', 'Veneto'],
                    [87, 'Salerno', 'SA', 'Campania'],
                    [88, 'Sassari', 'SS', 'Sardegna'],
                    [89, 'Savona', 'SV', 'Liguria'],
                    [90, 'Siena', 'SI', 'Toscana'],
                    [91, 'Siracusa', 'SR', 'Sicilia'],
                    [92, 'Sondrio', 'SO', 'Lombardia'],
                    [93, 'Taranto', 'TA', 'Puglia'],
                    [94, 'Teramo', 'TE', 'Abruzzo'],
                    [95, 'Terni', 'TR', 'Umbria'],
                    [96, 'Torino', 'TO', 'Piemonte'],
                    [97, 'Trapani', 'TP', 'Sicilia'],
                    [98, 'Trento', 'TN', 'Trentino-Alto Adige'],
                    [99, 'Treviso', 'TV', 'Veneto'],
                    [100, 'Trieste', 'TS', 'Friuli-Venezia Giulia'],
                    [101, 'Udine', 'UD', 'Friuli-Venezia Giulia'],
                    [102, 'Aosta', 'AO', 'Valle d\'Aosta'],
                    [103, 'Varese', 'VA', 'Lombardia'],
                    [104, 'Venezia', 'VE', 'Veneto'],
                    [105, 'Verbano-Cusio-Ossola', 'VB', 'Piemonte'],
                    [106, 'Vercelli', 'VC', 'Piemonte'],
                    [107, 'Verona', 'VR', 'Veneto'],
                    [108, 'Vibo Valentia', 'VV', 'Calabria'],
                    [109, 'Vicenza', 'VI', 'Veneto'],
                    [110, 'Viterbo', 'VT', 'Lazio']
                ]
            ]
        ];

        foreach ($Database as $table => $content)
        {
            foreach  ($content['value'] as $row)
            {
                print_r ($content['key']);
                print_r ($row);
                DB::table($table)->insert(array_combine($content['key'],$row)); 
            }
            
        }

    }
}
