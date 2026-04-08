<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AGState06CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 165,
'name' => 'Falmouth'
],[
'state_id' => 165,
'name' => 'Liberta'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
