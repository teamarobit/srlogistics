<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class ZAStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 204,
'name' => 'Northern Cape',
'iso2' => 'NC'
],[
'country_id' => 204,
'name' => 'Free State',
'iso2' => 'FS'
],[
'country_id' => 204,
'name' => 'Limpopo',
'iso2' => 'LP'
],[
'country_id' => 204,
'name' => 'North West',
'iso2' => 'NW'
],[
'country_id' => 204,
'name' => 'KwaZulu-Natal',
'iso2' => 'KZN'
],[
'country_id' => 204,
'name' => 'Gauteng',
'iso2' => 'GP'
],[
'country_id' => 204,
'name' => 'Mpumalanga',
'iso2' => 'MP'
],[
'country_id' => 204,
'name' => 'Eastern Cape',
'iso2' => 'EC'
],[
'country_id' => 204,
'name' => 'Western Cape',
'iso2' => 'WC'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
