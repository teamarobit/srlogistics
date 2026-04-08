<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class PYStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 172,
'name' => 'Presidente Hayes Department',
'iso2' => '15'
],[
'country_id' => 172,
'name' => 'Canindeyú',
'iso2' => '14'
],[
'country_id' => 172,
'name' => 'Guairá Department',
'iso2' => '4'
],[
'country_id' => 172,
'name' => 'Caaguazú',
'iso2' => '5'
],[
'country_id' => 172,
'name' => 'Paraguarí Department',
'iso2' => '9'
],[
'country_id' => 172,
'name' => 'Caazapá',
'iso2' => '6'
],[
'country_id' => 172,
'name' => 'San Pedro Department',
'iso2' => '2'
],[
'country_id' => 172,
'name' => 'Central Department',
'iso2' => '11'
],[
'country_id' => 172,
'name' => 'Itapúa',
'iso2' => '7'
],[
'country_id' => 172,
'name' => 'Concepción Department',
'iso2' => '1'
],[
'country_id' => 172,
'name' => 'Boquerón Department',
'iso2' => '19'
],[
'country_id' => 172,
'name' => 'Ñeembucú Department',
'iso2' => '12'
],[
'country_id' => 172,
'name' => 'Amambay Department',
'iso2' => '13'
],[
'country_id' => 172,
'name' => 'Cordillera Department',
'iso2' => '3'
],[
'country_id' => 172,
'name' => 'Alto Paraná Department',
'iso2' => '10'
],[
'country_id' => 172,
'name' => 'Alto Paraguay Department',
'iso2' => '16'
],[
'country_id' => 172,
'name' => 'Misiones Department',
'iso2' => '8'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
