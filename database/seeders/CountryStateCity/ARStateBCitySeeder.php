<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ARStateBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 193,
'name' => 'Balvanera'
],[
'state_id' => 193,
'name' => 'Barracas'
],[
'state_id' => 193,
'name' => 'Belgrano'
],[
'state_id' => 193,
'name' => 'Boedo'
],[
'state_id' => 193,
'name' => 'Buenos Aires'
],[
'state_id' => 193,
'name' => 'Colegiales'
],[
'state_id' => 193,
'name' => 'Retiro'
],[
'state_id' => 193,
'name' => 'Villa Lugano'
],[
'state_id' => 193,
'name' => 'Villa Ortúzar'
],[
'state_id' => 193,
'name' => 'Villa Santa Rita'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
