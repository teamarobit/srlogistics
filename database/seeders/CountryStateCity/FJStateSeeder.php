<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class FJStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 73,
'name' => 'Lomaiviti',
'iso2' => '06'
],[
'country_id' => 73,
'name' => 'Ba',
'iso2' => '01'
],[
'country_id' => 73,
'name' => 'Tailevu',
'iso2' => '14'
],[
'country_id' => 73,
'name' => 'Nadroga-Navosa',
'iso2' => '08'
],[
'country_id' => 73,
'name' => 'Rewa',
'iso2' => '12'
],[
'country_id' => 73,
'name' => 'Northern Division',
'iso2' => 'N'
],[
'country_id' => 73,
'name' => 'Macuata',
'iso2' => '07'
],[
'country_id' => 73,
'name' => 'Western Division',
'iso2' => 'W'
],[
'country_id' => 73,
'name' => 'Cakaudrove',
'iso2' => '03'
],[
'country_id' => 73,
'name' => 'Serua',
'iso2' => '13'
],[
'country_id' => 73,
'name' => 'Ra',
'iso2' => '11'
],[
'country_id' => 73,
'name' => 'Naitasiri',
'iso2' => '09'
],[
'country_id' => 73,
'name' => 'Namosi',
'iso2' => '10'
],[
'country_id' => 73,
'name' => 'Central Division',
'iso2' => 'C'
],[
'country_id' => 73,
'name' => 'Bua',
'iso2' => '02'
],[
'country_id' => 73,
'name' => 'Rotuma',
'iso2' => 'R'
],[
'country_id' => 73,
'name' => 'Eastern Division',
'iso2' => 'E'
],[
'country_id' => 73,
'name' => 'Lau',
'iso2' => '05'
],[
'country_id' => 73,
'name' => 'Kadavu',
'iso2' => '04'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
