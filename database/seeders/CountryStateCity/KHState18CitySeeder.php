<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class KHState18CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 675,
'name' => 'Sihanoukville'
],[
'state_id' => 675,
'name' => 'Srok Stueng Hav'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
