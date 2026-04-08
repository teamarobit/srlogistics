<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AGState07CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 164,
'name' => 'All Saints'
],[
'state_id' => 164,
'name' => 'Parham'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
