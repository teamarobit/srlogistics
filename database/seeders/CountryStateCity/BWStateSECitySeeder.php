<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BWStateSECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 518,
'name' => 'Gaborone'
],[
'state_id' => 518,
'name' => 'Janeng'
],[
'state_id' => 518,
'name' => 'Kopong'
],[
'state_id' => 518,
'name' => 'Otse'
],[
'state_id' => 518,
'name' => 'Ramotswa'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
