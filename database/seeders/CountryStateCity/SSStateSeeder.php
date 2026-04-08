<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class SSStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 206,
'name' => 'Unity',
'iso2' => 'UY'
],[
'country_id' => 206,
'name' => 'Upper Nile',
'iso2' => 'NU'
],[
'country_id' => 206,
'name' => 'Warrap',
'iso2' => 'WR'
],[
'country_id' => 206,
'name' => 'Northern Bahr el Ghazal',
'iso2' => 'BN'
],[
'country_id' => 206,
'name' => 'Western Equatoria',
'iso2' => 'EW'
],[
'country_id' => 206,
'name' => 'Lakes',
'iso2' => 'LK'
],[
'country_id' => 206,
'name' => 'Western Bahr el Ghazal',
'iso2' => 'BW'
],[
'country_id' => 206,
'name' => 'Central Equatoria',
'iso2' => 'EC'
],[
'country_id' => 206,
'name' => 'Eastern Equatoria',
'iso2' => 'EE'
],[
'country_id' => 206,
'name' => 'Jonglei State',
'iso2' => 'JG'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
