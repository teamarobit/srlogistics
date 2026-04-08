<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState12CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 558,
'name' => 'Berkovitsa'
],[
'state_id' => 558,
'name' => 'Boychinovtsi'
],[
'state_id' => 558,
'name' => 'Brusartsi'
],[
'state_id' => 558,
'name' => 'Chiprovtsi'
],[
'state_id' => 558,
'name' => 'Lom'
],[
'state_id' => 558,
'name' => 'Medkovets'
],[
'state_id' => 558,
'name' => 'Montana'
],[
'state_id' => 558,
'name' => 'Obshtina Boychinovtsi'
],[
'state_id' => 558,
'name' => 'Obshtina Chiprovtsi'
],[
'state_id' => 558,
'name' => 'Obshtina Georgi Damyanovo'
],[
'state_id' => 558,
'name' => 'Obshtina Lom'
],[
'state_id' => 558,
'name' => 'Obshtina Montana'
],[
'state_id' => 558,
'name' => 'Obshtina Valchedram'
],[
'state_id' => 558,
'name' => 'Obshtina Varshets'
],[
'state_id' => 558,
'name' => 'Obshtina Yakimovo'
],[
'state_id' => 558,
'name' => 'Valchedram'
],[
'state_id' => 558,
'name' => 'Varshets'
],[
'state_id' => 558,
'name' => 'Yakimovo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
