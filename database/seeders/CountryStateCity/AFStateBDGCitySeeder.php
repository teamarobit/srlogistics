<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AFStateBDGCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 2,
'name' => 'Ghormach'
],[
'state_id' => 2,
'name' => 'Qala i Naw'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
