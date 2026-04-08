<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class TLStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 63,
'name' => 'Viqueque Municipality',
'iso2' => 'VI'
],[
'country_id' => 63,
'name' => 'Liquiçá Municipality',
'iso2' => 'LI'
],[
'country_id' => 63,
'name' => 'Ermera District',
'iso2' => 'ER'
],[
'country_id' => 63,
'name' => 'Manatuto District',
'iso2' => 'MT'
],[
'country_id' => 63,
'name' => 'Ainaro Municipality',
'iso2' => 'AN'
],[
'country_id' => 63,
'name' => 'Manufahi Municipality',
'iso2' => 'MF'
],[
'country_id' => 63,
'name' => 'Aileu municipality',
'iso2' => 'AL'
],[
'country_id' => 63,
'name' => 'Baucau Municipality',
'iso2' => 'BA'
],[
'country_id' => 63,
'name' => 'Cova Lima Municipality',
'iso2' => 'CO'
],[
'country_id' => 63,
'name' => 'Lautém Municipality',
'iso2' => 'LA'
],[
'country_id' => 63,
'name' => 'Dili municipality',
'iso2' => 'DI'
],[
'country_id' => 63,
'name' => 'Bobonaro Municipality',
'iso2' => 'BO'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
