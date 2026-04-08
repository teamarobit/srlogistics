<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IQStateDQCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1780,
'name' => 'Ash Shaţrah'
],[
'state_id' => 1780,
'name' => 'Nasiriyah'
],[
'state_id' => 1780,
'name' => 'Nāḩiyat al Fuhūd'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
