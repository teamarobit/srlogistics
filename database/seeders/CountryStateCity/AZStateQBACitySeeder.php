<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateQBACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 268,
'name' => 'Hacıhüseynli'
],[
'state_id' => 268,
'name' => 'Quba'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
