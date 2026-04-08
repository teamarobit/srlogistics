<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AMStateSUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 199,
'name' => 'Agarak'
],[
'state_id' => 199,
'name' => 'Akner'
],[
'state_id' => 199,
'name' => 'Angeghakot’'
],[
'state_id' => 199,
'name' => 'Brrnakot’'
],[
'state_id' => 199,
'name' => 'Dzorastan'
],[
'state_id' => 199,
'name' => 'Goris'
],[
'state_id' => 199,
'name' => 'Hats’avan'
],[
'state_id' => 199,
'name' => 'Kapan'
],[
'state_id' => 199,
'name' => 'Khndzoresk'
],[
'state_id' => 199,
'name' => 'Meghri'
],[
'state_id' => 199,
'name' => 'Shaghat'
],[
'state_id' => 199,
'name' => 'Shinuhayr'
],[
'state_id' => 199,
'name' => 'Tegh'
],[
'state_id' => 199,
'name' => 'Verishen'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
