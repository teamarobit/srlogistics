<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ISState3CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1677,
'name' => 'Akranes'
],[
'state_id' => 1677,
'name' => 'Borgarbyggð'
],[
'state_id' => 1677,
'name' => 'Borgarnes'
],[
'state_id' => 1677,
'name' => 'Dalabyggð'
],[
'state_id' => 1677,
'name' => 'Eyja- og Miklaholtshreppur'
],[
'state_id' => 1677,
'name' => 'Helgafellssveit'
],[
'state_id' => 1677,
'name' => 'Hvalfjarðarsveit'
],[
'state_id' => 1677,
'name' => 'Skorradalshreppur'
],[
'state_id' => 1677,
'name' => 'Snæfellsbær'
],[
'state_id' => 1677,
'name' => 'Stykkishólmur'
],[
'state_id' => 1677,
'name' => 'Ólafsvík'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
