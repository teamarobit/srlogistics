<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HRState21CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 945,
'name' => 'Brezovica'
],[
'state_id' => 945,
'name' => 'Centar'
],[
'state_id' => 945,
'name' => 'Dubrava'
],[
'state_id' => 945,
'name' => 'Gradska četvrt Donji grad'
],[
'state_id' => 945,
'name' => 'Gradska četvrt Gornji Grad - Medvescak'
],[
'state_id' => 945,
'name' => 'Gradska četvrt Podsljeme'
],[
'state_id' => 945,
'name' => 'Horvati'
],[
'state_id' => 945,
'name' => 'Jankomir'
],[
'state_id' => 945,
'name' => 'Ježdovec'
],[
'state_id' => 945,
'name' => 'Kašina'
],[
'state_id' => 945,
'name' => 'Lučko'
],[
'state_id' => 945,
'name' => 'Novi Zagreb'
],[
'state_id' => 945,
'name' => 'Odra'
],[
'state_id' => 945,
'name' => 'Sesvete'
],[
'state_id' => 945,
'name' => 'Stenjevec'
],[
'state_id' => 945,
'name' => 'Strmec'
],[
'state_id' => 945,
'name' => 'Zadvorsko'
],[
'state_id' => 945,
'name' => 'Zagreb'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
