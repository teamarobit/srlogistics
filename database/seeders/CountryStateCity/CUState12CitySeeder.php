<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CUState12CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 955,
'name' => 'Bartolomé Masó'
],[
'state_id' => 955,
'name' => 'Bayamo'
],[
'state_id' => 955,
'name' => 'Campechuela'
],[
'state_id' => 955,
'name' => 'Cauto Cristo'
],[
'state_id' => 955,
'name' => 'Guisa'
],[
'state_id' => 955,
'name' => 'Jiguaní'
],[
'state_id' => 955,
'name' => 'Manzanillo'
],[
'state_id' => 955,
'name' => 'Media Luna'
],[
'state_id' => 955,
'name' => 'Municipio de Bayamo'
],[
'state_id' => 955,
'name' => 'Municipio de Manzanillo'
],[
'state_id' => 955,
'name' => 'Municipio de Niquero'
],[
'state_id' => 955,
'name' => 'Niquero'
],[
'state_id' => 955,
'name' => 'Río Cauto'
],[
'state_id' => 955,
'name' => 'Yara'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
