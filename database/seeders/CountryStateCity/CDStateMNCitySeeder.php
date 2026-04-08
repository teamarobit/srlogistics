<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CDStateMNCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 887,
'name' => 'Bolobo'
],[
'state_id' => 887,
'name' => 'Inongo'
],[
'state_id' => 887,
'name' => 'Mushie'
],[
'state_id' => 887,
'name' => 'Nioki'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
