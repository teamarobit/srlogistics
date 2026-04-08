<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ISState4CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1673,
'name' => 'Reykhólahreppur'
],[
'state_id' => 1673,
'name' => 'Strandabyggð'
],[
'state_id' => 1673,
'name' => 'Tálknafjarðarhreppur'
],[
'state_id' => 1673,
'name' => 'Ísafjarðarbær'
],[
'state_id' => 1673,
'name' => 'Ísafjörður'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
