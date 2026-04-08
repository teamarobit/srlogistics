<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class SVStateUSCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1181,
'name' => 'Berlín'
],[
'state_id' => 1181,
'name' => 'Concepción Batres'
],[
'state_id' => 1181,
'name' => 'Jiquilisco'
],[
'state_id' => 1181,
'name' => 'Jucuapa'
],[
'state_id' => 1181,
'name' => 'Jucuarán'
],[
'state_id' => 1181,
'name' => 'Ozatlán'
],[
'state_id' => 1181,
'name' => 'Puerto El Triunfo'
],[
'state_id' => 1181,
'name' => 'San Agustín'
],[
'state_id' => 1181,
'name' => 'Santa Elena'
],[
'state_id' => 1181,
'name' => 'Santiago de María'
],[
'state_id' => 1181,
'name' => 'Usulután'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
