<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GTStateJACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1502,
'name' => 'Jalapa'
],[
'state_id' => 1502,
'name' => 'Mataquescuintla'
],[
'state_id' => 1502,
'name' => 'Monjas'
],[
'state_id' => 1502,
'name' => 'Municipio de Jalapa'
],[
'state_id' => 1502,
'name' => 'Municipio de Mataquescuintla'
],[
'state_id' => 1502,
'name' => 'San Luis Jilotepeque'
],[
'state_id' => 1502,
'name' => 'San Manuel Chaparrón'
],[
'state_id' => 1502,
'name' => 'San Pedro Pinula'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
