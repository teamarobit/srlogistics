<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class GQStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 67,
'name' => 'Río Muni',
'iso2' => 'C'
],[
'country_id' => 67,
'name' => 'Kié-Ntem Province',
'iso2' => 'KN'
],[
'country_id' => 67,
'name' => 'Wele-Nzas Province',
'iso2' => 'WN'
],[
'country_id' => 67,
'name' => 'Litoral Province',
'iso2' => 'LI'
],[
'country_id' => 67,
'name' => 'Insular Region',
'iso2' => 'I'
],[
'country_id' => 67,
'name' => 'Bioko Sur Province',
'iso2' => 'BS'
],[
'country_id' => 67,
'name' => 'Annobón Province',
'iso2' => 'AN'
],[
'country_id' => 67,
'name' => 'Centro Sur Province',
'iso2' => 'CS'
],[
'country_id' => 67,
'name' => 'Bioko Norte Province',
'iso2' => 'BN'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
