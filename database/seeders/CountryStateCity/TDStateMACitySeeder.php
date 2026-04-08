<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class TDStateMACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 764,
'name' => 'Goundi'
],[
'state_id' => 764,
'name' => 'Koumra'
],[
'state_id' => 764,
'name' => 'Moïssala'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
