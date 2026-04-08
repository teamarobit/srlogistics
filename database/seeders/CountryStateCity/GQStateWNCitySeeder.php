<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GQStateWNCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1195,
'name' => 'Aconibe'
],[
'state_id' => 1195,
'name' => 'Ayene'
],[
'state_id' => 1195,
'name' => 'Añisoc'
],[
'state_id' => 1195,
'name' => 'Mengomeyén'
],[
'state_id' => 1195,
'name' => 'Mongomo'
],[
'state_id' => 1195,
'name' => 'Nsok'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
