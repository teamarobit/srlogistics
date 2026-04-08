<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class RWStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 183,
'name' => 'Southern Province',
'iso2' => '05'
],[
'country_id' => 183,
'name' => 'Western Province',
'iso2' => '04'
],[
'country_id' => 183,
'name' => 'Eastern Province',
'iso2' => '02'
],[
'country_id' => 183,
'name' => 'Kigali district',
'iso2' => '01'
],[
'country_id' => 183,
'name' => 'Northern Province',
'iso2' => '03'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
