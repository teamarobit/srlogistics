<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AOStateCNOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 151,
'name' => 'Camabatela'
],[
'state_id' => 151,
'name' => 'N’dalatando'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
