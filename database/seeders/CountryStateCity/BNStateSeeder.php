<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class BNStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 33,
'name' => 'Brunei-Muara District',
'iso2' => 'BM'
],[
'country_id' => 33,
'name' => 'Belait District',
'iso2' => 'BE'
],[
'country_id' => 33,
'name' => 'Temburong District',
'iso2' => 'TE'
],[
'country_id' => 33,
'name' => 'Tutong District',
'iso2' => 'TU'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
