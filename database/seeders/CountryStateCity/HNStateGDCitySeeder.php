<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HNStateGDCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1600,
'name' => 'Ahuas'
],[
'state_id' => 1600,
'name' => 'Auas'
],[
'state_id' => 1600,
'name' => 'Auka'
],[
'state_id' => 1600,
'name' => 'Barra Patuca'
],[
'state_id' => 1600,
'name' => 'Brus Laguna'
],[
'state_id' => 1600,
'name' => 'Iralaya'
],[
'state_id' => 1600,
'name' => 'Juan Francisco Bulnes'
],[
'state_id' => 1600,
'name' => 'Paptalaya'
],[
'state_id' => 1600,
'name' => 'Puerto Lempira'
],[
'state_id' => 1600,
'name' => 'Villeda Morales'
],[
'state_id' => 1600,
'name' => 'Wampusirpi'
],[
'state_id' => 1600,
'name' => 'Wawina'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
