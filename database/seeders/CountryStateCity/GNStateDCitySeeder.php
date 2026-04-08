<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GNStateDCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1551,
'name' => 'Coyah'
],[
'state_id' => 1551,
'name' => 'Dubréka'
],[
'state_id' => 1551,
'name' => 'Forécariah'
],[
'state_id' => 1551,
'name' => 'Kindia'
],[
'state_id' => 1551,
'name' => 'Préfecture de Dubréka'
],[
'state_id' => 1551,
'name' => 'Préfecture de Forécariah'
],[
'state_id' => 1551,
'name' => 'Telimele Prefecture'
],[
'state_id' => 1551,
'name' => 'Tondon'
],[
'state_id' => 1551,
'name' => 'Télimélé'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
