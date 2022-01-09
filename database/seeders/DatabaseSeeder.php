<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use phpseclib3\File\ASN1\Maps\Time;
use Ramsey\Uuid\Type\Integer;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       DB::table('users')->insert([
           'name'=>Str::random(10),
           'email' => Str::random(10).'@gmail.com',
           'password' => Hash::make('password'),
           'number'=>rand(min([1000000000]),max([1999999999])),
           'idt'=>rand(min([0]),max([1])),
       ]);

    }
}
