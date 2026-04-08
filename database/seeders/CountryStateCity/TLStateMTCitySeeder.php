<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class TLStateMTCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1119,
'name' => 'Barique'
],[
'state_id' => 1119,
'name' => 'Laclo'
],[
'state_id' => 1119,
'name' => 'Laclubar'
],[
'state_id' => 1119,
'name' => 'Manatuto'
],[
'state_id' => 1119,
'name' => 'Manatutu'
],[
'state_id' => 1119,
'name' => 'Soibada'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
