<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class VUStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 237,
'name' => 'Torba',
'iso2' => 'TOB'
],[
'country_id' => 237,
'name' => 'Penama',
'iso2' => 'PAM'
],[
'country_id' => 237,
'name' => 'Shefa',
'iso2' => 'SEE'
],[
'country_id' => 237,
'name' => 'Malampa',
'iso2' => 'MAP'
],[
'country_id' => 237,
'name' => 'Sanma',
'iso2' => 'SAM'
],[
'country_id' => 237,
'name' => 'Tafea',
'iso2' => 'TAE'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
