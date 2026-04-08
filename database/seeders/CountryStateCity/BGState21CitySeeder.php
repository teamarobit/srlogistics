<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState21CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 556,
'name' => 'Banite'
],[
'state_id' => 556,
'name' => 'Borino'
],[
'state_id' => 556,
'name' => 'Chepelare'
],[
'state_id' => 556,
'name' => 'Devin'
],[
'state_id' => 556,
'name' => 'Dospat'
],[
'state_id' => 556,
'name' => 'Gyovren'
],[
'state_id' => 556,
'name' => 'Madan'
],[
'state_id' => 556,
'name' => 'Nedelino'
],[
'state_id' => 556,
'name' => 'Obshtina Banite'
],[
'state_id' => 556,
'name' => 'Obshtina Borino'
],[
'state_id' => 556,
'name' => 'Obshtina Chepelare'
],[
'state_id' => 556,
'name' => 'Obshtina Devin'
],[
'state_id' => 556,
'name' => 'Obshtina Dospat'
],[
'state_id' => 556,
'name' => 'Obshtina Madan'
],[
'state_id' => 556,
'name' => 'Obshtina Nedelino'
],[
'state_id' => 556,
'name' => 'Obshtina Rudozem'
],[
'state_id' => 556,
'name' => 'Obshtina Smolyan'
],[
'state_id' => 556,
'name' => 'Obshtina Zlatograd'
],[
'state_id' => 556,
'name' => 'Rudozem'
],[
'state_id' => 556,
'name' => 'Smolyan'
],[
'state_id' => 556,
'name' => 'Zlatograd'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
