<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class SLStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 198,
'name' => 'Northern Province',
'iso2' => 'N'
],[
'country_id' => 198,
'name' => 'Southern Province',
'iso2' => 'S'
],[
'country_id' => 198,
'name' => 'Western Area',
'iso2' => 'W'
],[
'country_id' => 198,
'name' => 'Eastern Province',
'iso2' => 'E'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
