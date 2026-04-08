<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class LSStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 122,
'name' => 'Mafeteng District',
'iso2' => 'E'
],[
'country_id' => 122,
'name' => 'Mohale\'s Hoek District',
'iso2' => 'F'
],[
'country_id' => 122,
'name' => 'Mokhotlong District',
'iso2' => 'J'
],[
'country_id' => 122,
'name' => 'Qacha\'s Nek District',
'iso2' => 'H'
],[
'country_id' => 122,
'name' => 'Leribe District',
'iso2' => 'C'
],[
'country_id' => 122,
'name' => 'Quthing District',
'iso2' => 'G'
],[
'country_id' => 122,
'name' => 'Maseru District',
'iso2' => 'A'
],[
'country_id' => 122,
'name' => 'Butha-Buthe District',
'iso2' => 'B'
],[
'country_id' => 122,
'name' => 'Berea District',
'iso2' => 'D'
],[
'country_id' => 122,
'name' => 'Thaba-Tseka District',
'iso2' => 'K'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
