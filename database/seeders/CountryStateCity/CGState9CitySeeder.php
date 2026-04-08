<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CGState9CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 865,
'name' => 'Dolisie'
],[
'state_id' => 865,
'name' => 'Mossendjo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
