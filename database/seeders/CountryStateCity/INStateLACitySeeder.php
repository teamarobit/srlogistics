<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class INStateLACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1713,
'name' => 'Kargil'
],[
'state_id' => 1713,
'name' => 'Leh'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
