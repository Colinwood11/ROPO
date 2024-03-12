<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SeederUser extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::statement('TRUNCATE `users`');
        /*SQL style database populator */
        //print_r(Carbon::createFromDate(rand(1950,1999),rand(1,12),1)->addDays(rand(0,30))->format('Y-m-d'));
        $Database = 
        [
            'users'=>
            [
                'key' => ['username','email','password','status','role','birthday','last_login'],                 
                'value' =>
                [
                    /*1*/['Admin','admin@restaurant.it',Hash::make('J3ySs~E3-'),'normal',4,Carbon::createFromDate(rand(1950,1999),rand(1,12),1)->addDays(rand(0,30))->format('Y-m-d'),Carbon::now()], 
                    /*2*/['cashier','cashier@restaurant.it',Hash::make('4*Hpq+\'g'),'normal',3,Carbon::createFromDate(rand(1950,1999),rand(1,12),1)->addDays(rand(0,30))->format('Y-m-d'),Carbon::now()],
                    /*3*/['waiter1','waiter1@restaurant.it',Hash::make('6L<!AZpQb'),'normal',2,Carbon::createFromDate(rand(1950,1999),rand(1,12),1)->addDays(rand(0,30))->format('Y-m-d'),Carbon::now()],
                    /*4*/['waiter2','waiter2@restaurant.it',Hash::make('bYAnf)%42'),'normal',2,Carbon::createFromDate(rand(1950,1999),rand(1,12),1)->addDays(rand(0,30))->format('Y-m-d'),Carbon::now()],
                    /*5*/['waiter3','waiter3@restaurant.it',Hash::make('4Y2jk\}fB'),'normal',2,Carbon::createFromDate(rand(1950,1999),rand(1,12),1)->addDays(rand(0,30))->format('Y-m-d'),Carbon::now()],
                    /*6*/['client1','client1@restaurant.it',Hash::make('d+8%MZt4f'),'normal',1,Carbon::createFromDate(rand(1950,1999),rand(1,12),1)->addDays(rand(0,30))->format('Y-m-d'),Carbon::now()],
                    /*7*/['client2','client2@restaurant.it',Hash::make('??6PBf(B['),'normal',1,Carbon::createFromDate(rand(1950,1999),rand(1,12),1)->addDays(rand(0,30))->format('Y-m-d'),Carbon::now()],
                ]
            ],

        ];

        foreach ($Database as $table => $content)
        {
            foreach  ($content['value'] as $row)
            {
                DB::table($table)->insert(array_combine($content['key'],$row)); 
            }
            
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
