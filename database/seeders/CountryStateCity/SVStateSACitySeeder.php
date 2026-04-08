<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class SVStateSACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1180,
'name' => 'Candelaria de La Frontera'
],[
'state_id' => 1180,
'name' => 'Chalchuapa'
],[
'state_id' => 1180,
'name' => 'Coatepeque'
],[
'state_id' => 1180,
'name' => 'El Congo'
],[
'state_id' => 1180,
'name' => 'Metapán'
],[
'state_id' => 1180,
'name' => 'Santa Ana'
],[
'state_id' => 1180,
'name' => 'Texistepeque'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
