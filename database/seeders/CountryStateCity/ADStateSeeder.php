<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class ADStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 6,
'name' => 'Encamp',
'iso2' => '03'
],[
'country_id' => 6,
'name' => 'Andorra la Vella',
'iso2' => '07'
],[
'country_id' => 6,
'name' => 'Canillo',
'iso2' => '02'
],[
'country_id' => 6,
'name' => 'Sant Julià de Lòria',
'iso2' => '06'
],[
'country_id' => 6,
'name' => 'Ordino',
'iso2' => '05'
],[
'country_id' => 6,
'name' => 'Escaldes-Engordany',
'iso2' => '08'
],[
'country_id' => 6,
'name' => 'La Massana',
'iso2' => '04'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
