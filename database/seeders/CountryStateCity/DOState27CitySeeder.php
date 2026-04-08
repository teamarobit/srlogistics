<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState27CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1103,
'name' => 'Amina'
],[
'state_id' => 1103,
'name' => 'Esperanza'
],[
'state_id' => 1103,
'name' => 'Guatapanal'
],[
'state_id' => 1103,
'name' => 'Jaibón'
],[
'state_id' => 1103,
'name' => 'Jicomé'
],[
'state_id' => 1103,
'name' => 'La Caya'
],[
'state_id' => 1103,
'name' => 'Laguna Salada'
],[
'state_id' => 1103,
'name' => 'Maizal'
],[
'state_id' => 1103,
'name' => 'Mao'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
