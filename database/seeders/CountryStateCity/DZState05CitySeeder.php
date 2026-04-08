<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState05CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 125,
'name' => 'Arris'
],[
'state_id' => 125,
'name' => 'Aïn Touta'
],[
'state_id' => 125,
'name' => 'Barika'
],[
'state_id' => 125,
'name' => 'Batna'
],[
'state_id' => 125,
'name' => 'Boumagueur'
],[
'state_id' => 125,
'name' => 'Merouana'
],[
'state_id' => 125,
'name' => 'Râs el Aïoun'
],[
'state_id' => 125,
'name' => 'Tazoult-Lambese'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
