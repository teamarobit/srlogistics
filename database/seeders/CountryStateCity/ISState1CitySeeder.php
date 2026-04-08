<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ISState1CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1672,
'name' => 'Garðabær'
],[
'state_id' => 1672,
'name' => 'Hafnarfjörður'
],[
'state_id' => 1672,
'name' => 'Kjósarhreppur'
],[
'state_id' => 1672,
'name' => 'Kópavogur'
],[
'state_id' => 1672,
'name' => 'Mosfellsbaer'
],[
'state_id' => 1672,
'name' => 'Mosfellsbær'
],[
'state_id' => 1672,
'name' => 'Reykjavík'
],[
'state_id' => 1672,
'name' => 'Seltjarnarnes'
],[
'state_id' => 1672,
'name' => 'Álftanes'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
