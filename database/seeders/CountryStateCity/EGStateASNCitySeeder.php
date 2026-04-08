<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EGStateASNCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1155,
'name' => 'Abu Simbel'
],[
'state_id' => 1155,
'name' => 'Aswan'
],[
'state_id' => 1155,
'name' => 'Idfū'
],[
'state_id' => 1155,
'name' => 'Kawm Umbū'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
