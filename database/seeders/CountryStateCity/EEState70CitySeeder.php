<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EEState70CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1212,
'name' => 'Järvakandi'
],[
'state_id' => 1212,
'name' => 'Kehtna'
],[
'state_id' => 1212,
'name' => 'Kehtna vald'
],[
'state_id' => 1212,
'name' => 'Kohila'
],[
'state_id' => 1212,
'name' => 'Kohila vald'
],[
'state_id' => 1212,
'name' => 'Märjamaa'
],[
'state_id' => 1212,
'name' => 'Märjamaa vald'
],[
'state_id' => 1212,
'name' => 'Rapla'
],[
'state_id' => 1212,
'name' => 'Rapla vald'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
