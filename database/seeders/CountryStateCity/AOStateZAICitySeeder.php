<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AOStateZAICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 148,
'name' => 'Mbanza Congo'
],[
'state_id' => 148,
'name' => 'N\'zeto'
],[
'state_id' => 148,
'name' => 'Soio'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
