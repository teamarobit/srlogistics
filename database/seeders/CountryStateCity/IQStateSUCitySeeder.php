<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IQStateSUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1795,
'name' => 'As Sulaymānīyah'
],[
'state_id' => 1795,
'name' => 'Baynjiwayn'
],[
'state_id' => 1795,
'name' => 'Jamjamāl'
],[
'state_id' => 1795,
'name' => 'Ḩalabjah'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
