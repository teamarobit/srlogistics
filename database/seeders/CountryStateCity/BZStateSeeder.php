<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class BZStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 23,
'name' => 'Belize District',
'iso2' => 'BZ'
],[
'country_id' => 23,
'name' => 'Stann Creek District',
'iso2' => 'SC'
],[
'country_id' => 23,
'name' => 'Corozal District',
'iso2' => 'CZL'
],[
'country_id' => 23,
'name' => 'Toledo District',
'iso2' => 'TOL'
],[
'country_id' => 23,
'name' => 'Orange Walk District',
'iso2' => 'OW'
],[
'country_id' => 23,
'name' => 'Cayo District',
'iso2' => 'CY'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
