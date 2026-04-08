<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CIState06CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 920,
'name' => 'Bangolo'
],[
'state_id' => 920,
'name' => 'Biankouma'
],[
'state_id' => 920,
'name' => 'Cavally'
],[
'state_id' => 920,
'name' => 'Danané'
],[
'state_id' => 920,
'name' => 'Duekoué'
],[
'state_id' => 920,
'name' => 'Guiglo'
],[
'state_id' => 920,
'name' => 'Guémon'
],[
'state_id' => 920,
'name' => 'Man'
],[
'state_id' => 920,
'name' => 'Tonkpi'
],[
'state_id' => 920,
'name' => 'Toulépleu Gueré'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
