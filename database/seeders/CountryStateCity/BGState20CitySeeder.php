<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState20CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 562,
'name' => 'Kermen'
],[
'state_id' => 562,
'name' => 'Kotel'
],[
'state_id' => 562,
'name' => 'Nova Zagora'
],[
'state_id' => 562,
'name' => 'Obshtina Kotel'
],[
'state_id' => 562,
'name' => 'Obshtina Nova Zagora'
],[
'state_id' => 562,
'name' => 'Obshtina Sliven'
],[
'state_id' => 562,
'name' => 'Obshtina Tvarditsa'
],[
'state_id' => 562,
'name' => 'Sliven'
],[
'state_id' => 562,
'name' => 'Tvarditsa'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
