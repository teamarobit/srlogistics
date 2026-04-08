<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class GHStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 83,
'name' => 'Ashanti',
'iso2' => 'AH'
],[
'country_id' => 83,
'name' => 'Western',
'iso2' => 'WP'
],[
'country_id' => 83,
'name' => 'Eastern',
'iso2' => 'EP'
],[
'country_id' => 83,
'name' => 'Northern',
'iso2' => 'NP'
],[
'country_id' => 83,
'name' => 'Central',
'iso2' => 'CP'
],[
'country_id' => 83,
'name' => 'Ahafo',
'iso2' => 'AF'
],[
'country_id' => 83,
'name' => 'Greater Accra',
'iso2' => 'AA'
],[
'country_id' => 83,
'name' => 'Upper East',
'iso2' => 'UE'
],[
'country_id' => 83,
'name' => 'Volta',
'iso2' => 'TV'
],[
'country_id' => 83,
'name' => 'Upper West',
'iso2' => 'UW'
],[
'country_id' => 83,
'name' => 'Bono East',
'iso2' => 'BE'
],[
'country_id' => 83,
'name' => 'Bono',
'iso2' => 'BO'
],[
'country_id' => 83,
'name' => 'North East',
'iso2' => 'NE'
],[
'country_id' => 83,
'name' => 'Oti',
'iso2' => 'OT'
],[
'country_id' => 83,
'name' => 'Savannah',
'iso2' => 'SV'
],[
'country_id' => 83,
'name' => 'Western North',
'iso2' => 'WN'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
