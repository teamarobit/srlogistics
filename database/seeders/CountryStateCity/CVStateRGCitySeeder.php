<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CVStateRGCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 726,
'name' => 'Ponta do Sol'
],[
'state_id' => 726,
'name' => 'Ribeira Grande'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
