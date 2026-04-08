<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class SZStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 212,
'name' => 'Manzini District',
'iso2' => 'MA'
],[
'country_id' => 212,
'name' => 'Hhohho District',
'iso2' => 'HH'
],[
'country_id' => 212,
'name' => 'Lubombo District',
'iso2' => 'LU'
],[
'country_id' => 212,
'name' => 'Shiselweni District',
'iso2' => 'SH'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
