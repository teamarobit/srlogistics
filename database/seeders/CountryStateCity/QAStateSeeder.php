<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class QAStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 179,
'name' => 'Al Rayyan Municipality',
'iso2' => 'RA'
],[
'country_id' => 179,
'name' => 'Al-Shahaniya',
'iso2' => 'SH'
],[
'country_id' => 179,
'name' => 'Al Wakrah',
'iso2' => 'WA'
],[
'country_id' => 179,
'name' => 'Madinat ash Shamal',
'iso2' => 'MS'
],[
'country_id' => 179,
'name' => 'Doha',
'iso2' => 'DA'
],[
'country_id' => 179,
'name' => 'Al Daayen',
'iso2' => 'ZA'
],[
'country_id' => 179,
'name' => 'Al Khor',
'iso2' => 'KH'
],[
'country_id' => 179,
'name' => 'Umm Salal Municipality',
'iso2' => 'US'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
