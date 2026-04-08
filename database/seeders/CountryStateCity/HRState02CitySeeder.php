<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HRState02CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 936,
'name' => 'Bedekovčina'
],[
'state_id' => 936,
'name' => 'Budinščina'
],[
'state_id' => 936,
'name' => 'Grad Donja Stubica'
],[
'state_id' => 936,
'name' => 'Grad Klanjec'
],[
'state_id' => 936,
'name' => 'Grad Krapina'
],[
'state_id' => 936,
'name' => 'Grad Zabok'
],[
'state_id' => 936,
'name' => 'Grad Zlatar'
],[
'state_id' => 936,
'name' => 'Jesenje'
],[
'state_id' => 936,
'name' => 'Klanjec'
],[
'state_id' => 936,
'name' => 'Konjščina'
],[
'state_id' => 936,
'name' => 'Krapina'
],[
'state_id' => 936,
'name' => 'Kumrovec'
],[
'state_id' => 936,
'name' => 'Marija Bistrica'
],[
'state_id' => 936,
'name' => 'Mače'
],[
'state_id' => 936,
'name' => 'Mihovljan'
],[
'state_id' => 936,
'name' => 'Oroslavje'
],[
'state_id' => 936,
'name' => 'Pregrada'
],[
'state_id' => 936,
'name' => 'Radoboj'
],[
'state_id' => 936,
'name' => 'Stubičke Toplice'
],[
'state_id' => 936,
'name' => 'Sveti Križ Začretje'
],[
'state_id' => 936,
'name' => 'Zabok'
],[
'state_id' => 936,
'name' => 'Zlatar'
],[
'state_id' => 936,
'name' => 'Zlatar Bistrica'
],[
'state_id' => 936,
'name' => 'Đurmanec'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
