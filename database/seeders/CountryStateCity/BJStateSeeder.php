<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class BJStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 24,
'name' => 'Collines Department',
'iso2' => 'CO'
],[
'country_id' => 24,
'name' => 'Kouffo Department',
'iso2' => 'KO'
],[
'country_id' => 24,
'name' => 'Donga Department',
'iso2' => 'DO'
],[
'country_id' => 24,
'name' => 'Zou Department',
'iso2' => 'ZO'
],[
'country_id' => 24,
'name' => 'Plateau Department',
'iso2' => 'PL'
],[
'country_id' => 24,
'name' => 'Mono Department',
'iso2' => 'MO'
],[
'country_id' => 24,
'name' => 'Atakora Department',
'iso2' => 'AK'
],[
'country_id' => 24,
'name' => 'Alibori Department',
'iso2' => 'AL'
],[
'country_id' => 24,
'name' => 'Borgou Department',
'iso2' => 'BO'
],[
'country_id' => 24,
'name' => 'Atlantique Department',
'iso2' => 'AQ'
],[
'country_id' => 24,
'name' => 'Ouémé Department',
'iso2' => 'OU'
],[
'country_id' => 24,
'name' => 'Littoral Department',
'iso2' => 'LI'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
