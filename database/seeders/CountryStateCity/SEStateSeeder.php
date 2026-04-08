<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class SEStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 213,
'name' => 'Gävleborg County',
'iso2' => 'X'
],[
'country_id' => 213,
'name' => 'Dalarna County',
'iso2' => 'W'
],[
'country_id' => 213,
'name' => 'Värmland County',
'iso2' => 'S'
],[
'country_id' => 213,
'name' => 'Östergötland County',
'iso2' => 'E'
],[
'country_id' => 213,
'name' => 'Blekinge',
'iso2' => 'K'
],[
'country_id' => 213,
'name' => 'Norrbotten County',
'iso2' => 'BD'
],[
'country_id' => 213,
'name' => 'Örebro County',
'iso2' => 'T'
],[
'country_id' => 213,
'name' => 'Södermanland County',
'iso2' => 'D'
],[
'country_id' => 213,
'name' => 'Skåne County',
'iso2' => 'M'
],[
'country_id' => 213,
'name' => 'Kronoberg County',
'iso2' => 'G'
],[
'country_id' => 213,
'name' => 'Västerbotten County',
'iso2' => 'AC'
],[
'country_id' => 213,
'name' => 'Kalmar County',
'iso2' => 'H'
],[
'country_id' => 213,
'name' => 'Uppsala County',
'iso2' => 'C'
],[
'country_id' => 213,
'name' => 'Gotland County',
'iso2' => 'I'
],[
'country_id' => 213,
'name' => 'Västra Götaland County',
'iso2' => 'O'
],[
'country_id' => 213,
'name' => 'Halland County',
'iso2' => 'N'
],[
'country_id' => 213,
'name' => 'Västmanland County',
'iso2' => 'U'
],[
'country_id' => 213,
'name' => 'Jönköping County',
'iso2' => 'F'
],[
'country_id' => 213,
'name' => 'Stockholm County',
'iso2' => 'AB'
],[
'country_id' => 213,
'name' => 'Västernorrland County',
'iso2' => 'Y'
],[
'country_id' => 213,
'name' => 'Jämtland County',
'iso2' => '0'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
