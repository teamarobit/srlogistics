<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class SRStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 210,
'name' => 'Commewijne District',
'iso2' => 'CM'
],[
'country_id' => 210,
'name' => 'Nickerie District',
'iso2' => 'NI'
],[
'country_id' => 210,
'name' => 'Para District',
'iso2' => 'PR'
],[
'country_id' => 210,
'name' => 'Coronie District',
'iso2' => 'CR'
],[
'country_id' => 210,
'name' => 'Paramaribo District',
'iso2' => 'PM'
],[
'country_id' => 210,
'name' => 'Wanica District',
'iso2' => 'WA'
],[
'country_id' => 210,
'name' => 'Marowijne District',
'iso2' => 'MA'
],[
'country_id' => 210,
'name' => 'Brokopondo District',
'iso2' => 'BR'
],[
'country_id' => 210,
'name' => 'Sipaliwini District',
'iso2' => 'SI'
],[
'country_id' => 210,
'name' => 'Saramacca District',
'iso2' => 'SA'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
