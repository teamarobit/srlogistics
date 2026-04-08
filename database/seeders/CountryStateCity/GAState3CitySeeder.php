<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GAState3CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1402,
'name' => 'Lambaréné'
],[
'state_id' => 1402,
'name' => 'Ndjolé'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
