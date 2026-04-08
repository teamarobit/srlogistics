<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CLStateAICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 774,
'name' => 'Chile Chico'
],[
'state_id' => 774,
'name' => 'Cochrane'
],[
'state_id' => 774,
'name' => 'Coyhaique'
],[
'state_id' => 774,
'name' => 'Aysén'
],[
'state_id' => 774,
'name' => 'Cisnes'
],[
'state_id' => 774,
'name' => 'Guaitecas'
],[
'state_id' => 774,
'name' => 'Lago Verde'
],[
'state_id' => 774,
'name' => 'O\'Higgins'
],[
'state_id' => 774,
'name' => 'Río Ibáñez'
],[
'state_id' => 774,
'name' => 'Tortel'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
