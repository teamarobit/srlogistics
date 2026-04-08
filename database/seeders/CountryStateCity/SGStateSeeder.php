<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class SGStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 199,
'name' => 'North East Community Development Council',
'iso2' => '02'
],[
'country_id' => 199,
'name' => 'South East Community Development Council',
'iso2' => '04'
],[
'country_id' => 199,
'name' => 'Central Singapore Community Development Council',
'iso2' => '01'
],[
'country_id' => 199,
'name' => 'South West Community Development Council',
'iso2' => '05'
],[
'country_id' => 199,
'name' => 'North West Community Development Council',
'iso2' => '03'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
