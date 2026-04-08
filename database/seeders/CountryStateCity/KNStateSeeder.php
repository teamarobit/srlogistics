<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class KNStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 185,
'name' => 'Saint Peter Basseterre Parish',
'iso2' => '11'
],[
'country_id' => 185,
'name' => 'Nevis',
'iso2' => 'N'
],[
'country_id' => 185,
'name' => 'Christ Church Nichola Town Parish',
'iso2' => '01'
],[
'country_id' => 185,
'name' => 'Saint Paul Capisterre Parish',
'iso2' => '09'
],[
'country_id' => 185,
'name' => 'Saint James Windward Parish',
'iso2' => '05'
],[
'country_id' => 185,
'name' => 'Saint Anne Sandy Point Parish',
'iso2' => '02'
],[
'country_id' => 185,
'name' => 'Saint George Gingerland Parish',
'iso2' => '04'
],[
'country_id' => 185,
'name' => 'Saint Paul Charlestown Parish',
'iso2' => '10'
],[
'country_id' => 185,
'name' => 'Saint Thomas Lowland Parish',
'iso2' => '12'
],[
'country_id' => 185,
'name' => 'Saint John Figtree Parish',
'iso2' => '07'
],[
'country_id' => 185,
'name' => 'Saint Kitts',
'iso2' => 'K'
],[
'country_id' => 185,
'name' => 'Saint Thomas Middle Island Parish',
'iso2' => '13'
],[
'country_id' => 185,
'name' => 'Trinity Palmetto Point Parish',
'iso2' => '15'
],[
'country_id' => 185,
'name' => 'Saint Mary Cayon Parish',
'iso2' => '08'
],[
'country_id' => 185,
'name' => 'Saint John Capisterre Parish',
'iso2' => '06'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
