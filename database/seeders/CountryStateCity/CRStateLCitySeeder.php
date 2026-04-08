<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CRStateLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 897,
'name' => 'Batán'
],[
'state_id' => 897,
'name' => 'Guácimo'
],[
'state_id' => 897,
'name' => 'Guápiles'
],[
'state_id' => 897,
'name' => 'Limón'
],[
'state_id' => 897,
'name' => 'Matina'
],[
'state_id' => 897,
'name' => 'Pococí'
],[
'state_id' => 897,
'name' => 'Pocora'
],[
'state_id' => 897,
'name' => 'Roxana'
],[
'state_id' => 897,
'name' => 'Siquirres'
],[
'state_id' => 897,
'name' => 'Sixaola'
],[
'state_id' => 897,
'name' => 'Talamanca'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
