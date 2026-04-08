<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class FIState13CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1263,
'name' => 'Eno'
],[
'state_id' => 1263,
'name' => 'Ilomantsi'
],[
'state_id' => 1263,
'name' => 'Joensuu'
],[
'state_id' => 1263,
'name' => 'Juuka'
],[
'state_id' => 1263,
'name' => 'Kesälahti'
],[
'state_id' => 1263,
'name' => 'Kiihtelysvaara'
],[
'state_id' => 1263,
'name' => 'Kitee'
],[
'state_id' => 1263,
'name' => 'Kontiolahti'
],[
'state_id' => 1263,
'name' => 'Lieksa'
],[
'state_id' => 1263,
'name' => 'Liperi'
],[
'state_id' => 1263,
'name' => 'Nurmes'
],[
'state_id' => 1263,
'name' => 'Outokumpu'
],[
'state_id' => 1263,
'name' => 'Polvijärvi'
],[
'state_id' => 1263,
'name' => 'Pyhäselkä'
],[
'state_id' => 1263,
'name' => 'Rääkkylä'
],[
'state_id' => 1263,
'name' => 'Tohmajärvi'
],[
'state_id' => 1263,
'name' => 'Tuupovaara'
],[
'state_id' => 1263,
'name' => 'Valtimo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
