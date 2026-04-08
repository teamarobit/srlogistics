<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class LCStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 186,
'name' => 'Dennery Quarter',
'iso2' => '05'
],[
'country_id' => 186,
'name' => 'Anse la Raye Quarter',
'iso2' => '01'
],[
'country_id' => 186,
'name' => 'Castries Quarter',
'iso2' => '02'
],[
'country_id' => 186,
'name' => 'Laborie Quarter',
'iso2' => '07'
],[
'country_id' => 186,
'name' => 'Choiseul Quarter',
'iso2' => '03'
],[
'country_id' => 186,
'name' => 'Canaries',
'iso2' => '12'
],[
'country_id' => 186,
'name' => 'Micoud Quarter',
'iso2' => '08'
],[
'country_id' => 186,
'name' => 'Vieux Fort Quarter',
'iso2' => '11'
],[
'country_id' => 186,
'name' => 'Soufrière Quarter',
'iso2' => '10'
],[
'country_id' => 186,
'name' => 'Praslin Quarter',
'iso2' => '09'
],[
'country_id' => 186,
'name' => 'Gros Islet Quarter',
'iso2' => '06'
],[
'country_id' => 186,
'name' => 'Dauphin Quarter',
'iso2' => '04'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
