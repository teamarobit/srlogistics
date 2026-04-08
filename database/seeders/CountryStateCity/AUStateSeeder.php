<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class AUStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 14,
'name' => 'Victoria',
'iso2' => 'VIC'
],[
'country_id' => 14,
'name' => 'South Australia',
'iso2' => 'SA'
],[
'country_id' => 14,
'name' => 'Queensland',
'iso2' => 'QLD'
],[
'country_id' => 14,
'name' => 'Western Australia',
'iso2' => 'WA'
],[
'country_id' => 14,
'name' => 'Australian Capital Territory',
'iso2' => 'ACT'
],[
'country_id' => 14,
'name' => 'Tasmania',
'iso2' => 'TAS'
],[
'country_id' => 14,
'name' => 'New South Wales',
'iso2' => 'NSW'
],[
'country_id' => 14,
'name' => 'Northern Territory',
'iso2' => 'NT'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
