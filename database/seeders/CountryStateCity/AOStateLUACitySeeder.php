<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AOStateLUACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 156,
'name' => 'Belas'
],[
'state_id' => 156,
'name' => 'Icolo e Bengo'
],[
'state_id' => 156,
'name' => 'Luanda'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
