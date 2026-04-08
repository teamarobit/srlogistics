<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class SVStateLICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1186,
'name' => 'Antiguo Cuscatlán'
],[
'state_id' => 1186,
'name' => 'Ciudad Arce'
],[
'state_id' => 1186,
'name' => 'La Libertad'
],[
'state_id' => 1186,
'name' => 'Nuevo Cuscatlán'
],[
'state_id' => 1186,
'name' => 'Quezaltepeque'
],[
'state_id' => 1186,
'name' => 'San Juan Opico'
],[
'state_id' => 1186,
'name' => 'San Pablo Tacachico'
],[
'state_id' => 1186,
'name' => 'Santa Tecla'
],[
'state_id' => 1186,
'name' => 'Zaragoza'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
