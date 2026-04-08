<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateGADCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 294,
'name' => 'Arıqdam'
],[
'state_id' => 294,
'name' => 'Arıqıran'
],[
'state_id' => 294,
'name' => 'Böyük Qaramurad'
],[
'state_id' => 294,
'name' => 'Kyadabek'
],[
'state_id' => 294,
'name' => 'Novosaratovka'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
