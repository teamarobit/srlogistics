<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateARACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 826,
'name' => 'Arauca'
],[
'state_id' => 826,
'name' => 'Arauquita'
],[
'state_id' => 826,
'name' => 'Cravo Norte'
],[
'state_id' => 826,
'name' => 'Fortul'
],[
'state_id' => 826,
'name' => 'Puerto Rondón'
],[
'state_id' => 826,
'name' => 'Saravena'
],[
'state_id' => 826,
'name' => 'Tame'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
