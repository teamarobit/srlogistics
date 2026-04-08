<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GQStateBNCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1201,
'name' => 'Malabo'
],[
'state_id' => 1201,
'name' => 'Rebola'
],[
'state_id' => 1201,
'name' => 'Santiago de Baney'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
