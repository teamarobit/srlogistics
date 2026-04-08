<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IQStateSDCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1787,
'name' => 'Ad Dujayl'
],[
'state_id' => 1787,
'name' => 'Balad'
],[
'state_id' => 1787,
'name' => 'Bayjī'
],[
'state_id' => 1787,
'name' => 'Sāmarrā’'
],[
'state_id' => 1787,
'name' => 'Tikrīt'
],[
'state_id' => 1787,
'name' => 'Tozkhurmato'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
