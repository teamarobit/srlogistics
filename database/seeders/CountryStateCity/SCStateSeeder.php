<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class SCStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 197,
'name' => 'Mont Buxton',
'iso2' => '17'
],[
'country_id' => 197,
'name' => 'La Digue',
'iso2' => '15'
],[
'country_id' => 197,
'name' => 'Saint Louis',
'iso2' => '22'
],[
'country_id' => 197,
'name' => 'Baie Lazare',
'iso2' => '06'
],[
'country_id' => 197,
'name' => 'Mont Fleuri',
'iso2' => '18'
],[
'country_id' => 197,
'name' => 'Les Mamelles',
'iso2' => '24'
],[
'country_id' => 197,
'name' => 'Grand\'Anse Mahé',
'iso2' => '13'
],[
'country_id' => 197,
'name' => 'Roche Caiman',
'iso2' => '25'
],[
'country_id' => 197,
'name' => 'Anse Royale',
'iso2' => '05'
],[
'country_id' => 197,
'name' => 'Glacis',
'iso2' => '12'
],[
'country_id' => 197,
'name' => 'Grand\'Anse Praslin',
'iso2' => '14'
],[
'country_id' => 197,
'name' => 'Bel Ombre',
'iso2' => '10'
],[
'country_id' => 197,
'name' => 'Anse-aux-Pins',
'iso2' => '01'
],[
'country_id' => 197,
'name' => 'Port Glaud',
'iso2' => '21'
],[
'country_id' => 197,
'name' => 'Au Cap',
'iso2' => '04'
],[
'country_id' => 197,
'name' => 'Takamaka',
'iso2' => '23'
],[
'country_id' => 197,
'name' => 'Pointe La Rue',
'iso2' => '20'
],[
'country_id' => 197,
'name' => 'Plaisance',
'iso2' => '19'
],[
'country_id' => 197,
'name' => 'Beau Vallon',
'iso2' => '08'
],[
'country_id' => 197,
'name' => 'Anse Boileau',
'iso2' => '02'
],[
'country_id' => 197,
'name' => 'Baie Sainte Anne',
'iso2' => '07'
],[
'country_id' => 197,
'name' => 'Bel Air',
'iso2' => '09'
],[
'country_id' => 197,
'name' => 'La Rivière Anglaise',
'iso2' => '16'
],[
'country_id' => 197,
'name' => 'Cascade',
'iso2' => '11'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
