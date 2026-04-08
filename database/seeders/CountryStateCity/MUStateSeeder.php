<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class MUStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 140,
'name' => 'Agalega Islands',
'iso2' => 'AG'
],[
'country_id' => 140,
'name' => 'Rodrigues Island',
'iso2' => 'RO'
],[
'country_id' => 140,
'name' => 'Pamplemousses',
'iso2' => 'PA'
],[
'country_id' => 140,
'name' => 'Saint Brandon Islands',
'iso2' => 'CC'
],[
'country_id' => 140,
'name' => 'Moka',
'iso2' => 'MO'
],[
'country_id' => 140,
'name' => 'Flacq',
'iso2' => 'FL'
],[
'country_id' => 140,
'name' => 'Savanne',
'iso2' => 'SA'
],[
'country_id' => 140,
'name' => 'Black River',
'iso2' => 'BL'
],[
'country_id' => 140,
'name' => 'Port Louis',
'iso2' => 'PL'
],[
'country_id' => 140,
'name' => 'Rivière du Rempart',
'iso2' => 'RR'
],[
'country_id' => 140,
'name' => 'Plaines Wilhems',
'iso2' => 'PW'
],[
'country_id' => 140,
'name' => 'Grand Port',
'iso2' => 'GP'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
