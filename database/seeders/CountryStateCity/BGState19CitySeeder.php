<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState19CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 570,
'name' => 'Alfatar'
],[
'state_id' => 570,
'name' => 'Dulovo'
],[
'state_id' => 570,
'name' => 'Glavinitsa'
],[
'state_id' => 570,
'name' => 'Kaynardzha'
],[
'state_id' => 570,
'name' => 'Obshtina Alfatar'
],[
'state_id' => 570,
'name' => 'Obshtina Dulovo'
],[
'state_id' => 570,
'name' => 'Obshtina Glavinitsa'
],[
'state_id' => 570,
'name' => 'Obshtina Kaynardzha'
],[
'state_id' => 570,
'name' => 'Obshtina Silistra'
],[
'state_id' => 570,
'name' => 'Obshtina Sitovo'
],[
'state_id' => 570,
'name' => 'Obshtina Tutrakan'
],[
'state_id' => 570,
'name' => 'Silistra'
],[
'state_id' => 570,
'name' => 'Sitovo'
],[
'state_id' => 570,
'name' => 'Tutrakan'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
