<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CYState05CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 970,
'name' => 'Argáka'
],[
'state_id' => 970,
'name' => 'Chlórakas'
],[
'state_id' => 970,
'name' => 'Emba'
],[
'state_id' => 970,
'name' => 'Geroskipou'
],[
'state_id' => 970,
'name' => 'Geroskípou (quarter)'
],[
'state_id' => 970,
'name' => 'Geroskípou Municipality'
],[
'state_id' => 970,
'name' => 'Kissonerga'
],[
'state_id' => 970,
'name' => 'Koloni'
],[
'state_id' => 970,
'name' => 'Konia'
],[
'state_id' => 970,
'name' => 'Mesógi'
],[
'state_id' => 970,
'name' => 'Paphos'
],[
'state_id' => 970,
'name' => 'Pégeia'
],[
'state_id' => 970,
'name' => 'Pólis'
],[
'state_id' => 970,
'name' => 'Tsáda'
],[
'state_id' => 970,
'name' => 'Tála'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
