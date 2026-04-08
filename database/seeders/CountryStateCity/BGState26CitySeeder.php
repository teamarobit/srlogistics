<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState26CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 566,
'name' => 'Dimitrovgrad'
],[
'state_id' => 566,
'name' => 'Harmanli'
],[
'state_id' => 566,
'name' => 'Haskovo'
],[
'state_id' => 566,
'name' => 'Ivaylovgrad'
],[
'state_id' => 566,
'name' => 'Lyubimets'
],[
'state_id' => 566,
'name' => 'Madzharovo'
],[
'state_id' => 566,
'name' => 'Mineralni Bani'
],[
'state_id' => 566,
'name' => 'Obshtina Dimitrovgrad'
],[
'state_id' => 566,
'name' => 'Obshtina Harmanli'
],[
'state_id' => 566,
'name' => 'Obshtina Haskovo'
],[
'state_id' => 566,
'name' => 'Obshtina Ivaylovgrad'
],[
'state_id' => 566,
'name' => 'Obshtina Madzharovo'
],[
'state_id' => 566,
'name' => 'Obshtina Mineralni Bani'
],[
'state_id' => 566,
'name' => 'Obshtina Stambolovo'
],[
'state_id' => 566,
'name' => 'Obshtina Svilengrad'
],[
'state_id' => 566,
'name' => 'Obshtina Topolovgrad'
],[
'state_id' => 566,
'name' => 'Simeonovgrad'
],[
'state_id' => 566,
'name' => 'Svilengrad'
],[
'state_id' => 566,
'name' => 'Topolovgrad'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
