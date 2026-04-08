<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EEState78CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1210,
'name' => 'Alatskivi'
],[
'state_id' => 1210,
'name' => 'Elva'
],[
'state_id' => 1210,
'name' => 'Kallaste'
],[
'state_id' => 1210,
'name' => 'Kambja vald'
],[
'state_id' => 1210,
'name' => 'Kurepalu'
],[
'state_id' => 1210,
'name' => 'Kõrveküla'
],[
'state_id' => 1210,
'name' => 'Luunja'
],[
'state_id' => 1210,
'name' => 'Luunja vald'
],[
'state_id' => 1210,
'name' => 'Nõo'
],[
'state_id' => 1210,
'name' => 'Nõo vald'
],[
'state_id' => 1210,
'name' => 'Peipsiääre vald'
],[
'state_id' => 1210,
'name' => 'Puhja'
],[
'state_id' => 1210,
'name' => 'Tartu'
],[
'state_id' => 1210,
'name' => 'Tartu linn'
],[
'state_id' => 1210,
'name' => 'Tartu vald'
],[
'state_id' => 1210,
'name' => 'Ülenurme'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
