<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CDStateSACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 876,
'name' => 'Lodja'
],[
'state_id' => 876,
'name' => 'Lusambo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
