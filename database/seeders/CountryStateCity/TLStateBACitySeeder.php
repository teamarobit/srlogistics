<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class TLStateBACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1123,
'name' => 'Baguia'
],[
'state_id' => 1123,
'name' => 'Baucau'
],[
'state_id' => 1123,
'name' => 'Baukau'
],[
'state_id' => 1123,
'name' => 'Laga'
],[
'state_id' => 1123,
'name' => 'Quelicai'
],[
'state_id' => 1123,
'name' => 'Vemasse'
],[
'state_id' => 1123,
'name' => 'Venilale'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
