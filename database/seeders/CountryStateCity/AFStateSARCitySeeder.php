<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AFStateSARCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 16,
'name' => 'Chīras'
],[
'state_id' => 16,
'name' => 'Larkird'
],[
'state_id' => 16,
'name' => 'Qal‘ah-ye Shahr'
],[
'state_id' => 16,
'name' => 'Sang-e Chārak'
],[
'state_id' => 16,
'name' => 'Sar-e Pul'
],[
'state_id' => 16,
'name' => 'Tagāw-Bāy'
],[
'state_id' => 16,
'name' => 'Tukzār'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
