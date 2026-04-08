<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class FIState06CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1253,
'name' => 'Forssa'
],[
'state_id' => 1253,
'name' => 'Hauho'
],[
'state_id' => 1253,
'name' => 'Hausjärvi'
],[
'state_id' => 1253,
'name' => 'Humppila'
],[
'state_id' => 1253,
'name' => 'Hämeenlinna'
],[
'state_id' => 1253,
'name' => 'Janakkala'
],[
'state_id' => 1253,
'name' => 'Jokioinen'
],[
'state_id' => 1253,
'name' => 'Kalvola'
],[
'state_id' => 1253,
'name' => 'Lammi'
],[
'state_id' => 1253,
'name' => 'Loppi'
],[
'state_id' => 1253,
'name' => 'Renko'
],[
'state_id' => 1253,
'name' => 'Riihimäki'
],[
'state_id' => 1253,
'name' => 'Tammela'
],[
'state_id' => 1253,
'name' => 'Tervakoski'
],[
'state_id' => 1253,
'name' => 'Tuulos'
],[
'state_id' => 1253,
'name' => 'Ypäjä'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
