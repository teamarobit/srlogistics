<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CDStateNKCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 882,
'name' => 'Beni'
],[
'state_id' => 882,
'name' => 'Butembo'
],[
'state_id' => 882,
'name' => 'Goma'
],[
'state_id' => 882,
'name' => 'Sake'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
