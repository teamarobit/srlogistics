<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class GWStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 93,
'name' => 'Tombali Region',
'iso2' => 'TO'
],[
'country_id' => 93,
'name' => 'Cacheu Region',
'iso2' => 'CA'
],[
'country_id' => 93,
'name' => 'Biombo Region',
'iso2' => 'BM'
],[
'country_id' => 93,
'name' => 'Quinara Region',
'iso2' => 'QU'
],[
'country_id' => 93,
'name' => 'Sul Province',
'iso2' => 'S'
],[
'country_id' => 93,
'name' => 'Norte Province',
'iso2' => 'N'
],[
'country_id' => 93,
'name' => 'Oio Region',
'iso2' => 'OI'
],[
'country_id' => 93,
'name' => 'Gabú Region',
'iso2' => 'GA'
],[
'country_id' => 93,
'name' => 'Bafatá',
'iso2' => 'BA'
],[
'country_id' => 93,
'name' => 'Leste Province',
'iso2' => 'L'
],[
'country_id' => 93,
'name' => 'Bolama Region',
'iso2' => 'BL'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
