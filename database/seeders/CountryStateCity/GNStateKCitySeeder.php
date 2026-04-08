<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GNStateKCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1547,
'name' => 'Kankan'
],[
'state_id' => 1547,
'name' => 'Kankan Prefecture'
],[
'state_id' => 1547,
'name' => 'Kerouane Prefecture'
],[
'state_id' => 1547,
'name' => 'Kouroussa'
],[
'state_id' => 1547,
'name' => 'Kérouané'
],[
'state_id' => 1547,
'name' => 'Mandiana'
],[
'state_id' => 1547,
'name' => 'Mandiana Prefecture'
],[
'state_id' => 1547,
'name' => 'Siguiri'
],[
'state_id' => 1547,
'name' => 'Siguiri Prefecture'
],[
'state_id' => 1547,
'name' => 'Tokonou'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
