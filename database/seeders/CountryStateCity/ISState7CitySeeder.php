<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ISState7CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1674,
'name' => 'Borgarfjarðarhreppur'
],[
'state_id' => 1674,
'name' => 'Breiðdalshreppur'
],[
'state_id' => 1674,
'name' => 'Egilsstaðir'
],[
'state_id' => 1674,
'name' => 'Eskifjörður'
],[
'state_id' => 1674,
'name' => 'Fjarðabyggð'
],[
'state_id' => 1674,
'name' => 'Fljótsdalshreppur'
],[
'state_id' => 1674,
'name' => 'Fljótsdalshérað'
],[
'state_id' => 1674,
'name' => 'Höfn'
],[
'state_id' => 1674,
'name' => 'Neskaupstaður'
],[
'state_id' => 1674,
'name' => 'Reyðarfjörður'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
