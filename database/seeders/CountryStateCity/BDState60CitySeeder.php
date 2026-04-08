<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BDState60CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 362,
'name' => 'Baniachang'
],[
'state_id' => 362,
'name' => 'Chhātak'
],[
'state_id' => 362,
'name' => 'Habiganj'
],[
'state_id' => 362,
'name' => 'Jahedpur'
],[
'state_id' => 362,
'name' => 'Maulavi Bāzār'
],[
'state_id' => 362,
'name' => 'Maulvibazar'
],[
'state_id' => 362,
'name' => 'Sunamganj'
],[
'state_id' => 362,
'name' => 'Sylhet'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
