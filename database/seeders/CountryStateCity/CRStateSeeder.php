<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class CRStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 53,
'name' => 'Guanacaste Province',
'iso2' => 'G'
],[
'country_id' => 53,
'name' => 'Puntarenas Province',
'iso2' => 'P'
],[
'country_id' => 53,
'name' => 'Provincia de Cartago',
'iso2' => 'C'
],[
'country_id' => 53,
'name' => 'Heredia Province',
'iso2' => 'H'
],[
'country_id' => 53,
'name' => 'Limón Province',
'iso2' => 'L'
],[
'country_id' => 53,
'name' => 'San José Province',
'iso2' => 'SJ'
],[
'country_id' => 53,
'name' => 'Alajuela Province',
'iso2' => 'A'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
