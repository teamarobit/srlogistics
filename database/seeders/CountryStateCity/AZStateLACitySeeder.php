<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateLACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 263,
'name' => 'Haftoni'
],[
'state_id' => 263,
'name' => 'Lankaran'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
