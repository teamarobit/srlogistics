<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class FIState10CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1259,
'name' => 'Enontekiö'
],[
'state_id' => 1259,
'name' => 'Inari'
],[
'state_id' => 1259,
'name' => 'Ivalo'
],[
'state_id' => 1259,
'name' => 'Kemi'
],[
'state_id' => 1259,
'name' => 'Kemijärvi'
],[
'state_id' => 1259,
'name' => 'Keminmaa'
],[
'state_id' => 1259,
'name' => 'Kittilä'
],[
'state_id' => 1259,
'name' => 'Kolari'
],[
'state_id' => 1259,
'name' => 'Muonio'
],[
'state_id' => 1259,
'name' => 'Pelkosenniemi'
],[
'state_id' => 1259,
'name' => 'Pello'
],[
'state_id' => 1259,
'name' => 'Posio'
],[
'state_id' => 1259,
'name' => 'Pyhäjärvi'
],[
'state_id' => 1259,
'name' => 'Ranua'
],[
'state_id' => 1259,
'name' => 'Rovaniemi'
],[
'state_id' => 1259,
'name' => 'Salla'
],[
'state_id' => 1259,
'name' => 'Savukoski'
],[
'state_id' => 1259,
'name' => 'Simo'
],[
'state_id' => 1259,
'name' => 'Sodankylä'
],[
'state_id' => 1259,
'name' => 'Tervola'
],[
'state_id' => 1259,
'name' => 'Tornio'
],[
'state_id' => 1259,
'name' => 'Utsjoki'
],[
'state_id' => 1259,
'name' => 'Ylitornio'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
