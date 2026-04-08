<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AOStateHUACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 147,
'name' => 'Caála'
],[
'state_id' => 147,
'name' => 'Chela'
],[
'state_id' => 147,
'name' => 'Huambo'
],[
'state_id' => 147,
'name' => 'Longonjo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
