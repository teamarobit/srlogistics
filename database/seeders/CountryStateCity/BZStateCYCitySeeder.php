<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BZStateCYCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 451,
'name' => 'Belmopan'
],[
'state_id' => 451,
'name' => 'Benque Viejo el Carmen'
],[
'state_id' => 451,
'name' => 'San Ignacio'
],[
'state_id' => 451,
'name' => 'Valley of Peace'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
