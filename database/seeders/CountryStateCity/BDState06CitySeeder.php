<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BDState06CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 413,
'name' => 'Barguna'
],[
'state_id' => 413,
'name' => 'Barisal'
],[
'state_id' => 413,
'name' => 'Bhola'
],[
'state_id' => 413,
'name' => 'Bhāndāria'
],[
'state_id' => 413,
'name' => 'Burhānuddin'
],[
'state_id' => 413,
'name' => 'Gaurnadi'
],[
'state_id' => 413,
'name' => 'Jhalokati'
],[
'state_id' => 413,
'name' => 'Lālmohan'
],[
'state_id' => 413,
'name' => 'Mathba'
],[
'state_id' => 413,
'name' => 'Mehendiganj'
],[
'state_id' => 413,
'name' => 'Nālchiti'
],[
'state_id' => 413,
'name' => 'Patuakhali'
],[
'state_id' => 413,
'name' => 'Pirojpur'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
