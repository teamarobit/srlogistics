<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class FIState12CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1267,
'name' => 'Hietalahti'
],[
'state_id' => 1267,
'name' => 'Isokyrö'
],[
'state_id' => 1267,
'name' => 'Jakobstad'
],[
'state_id' => 1267,
'name' => 'Kaskinen'
],[
'state_id' => 1267,
'name' => 'Korsholm'
],[
'state_id' => 1267,
'name' => 'Korsnäs'
],[
'state_id' => 1267,
'name' => 'Kristinestad'
],[
'state_id' => 1267,
'name' => 'Kronoby'
],[
'state_id' => 1267,
'name' => 'Laihia'
],[
'state_id' => 1267,
'name' => 'Larsmo'
],[
'state_id' => 1267,
'name' => 'Malax'
],[
'state_id' => 1267,
'name' => 'Nykarleby'
],[
'state_id' => 1267,
'name' => 'Oravais'
],[
'state_id' => 1267,
'name' => 'Pedersöre'
],[
'state_id' => 1267,
'name' => 'Replot'
],[
'state_id' => 1267,
'name' => 'Ristinummi'
],[
'state_id' => 1267,
'name' => 'Teeriniemi'
],[
'state_id' => 1267,
'name' => 'Vaasa'
],[
'state_id' => 1267,
'name' => 'Vähäkyrö'
],[
'state_id' => 1267,
'name' => 'Vörå'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
