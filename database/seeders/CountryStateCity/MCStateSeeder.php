<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class MCStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 145,
'name' => 'La Colle',
'iso2' => 'CL'
],[
'country_id' => 145,
'name' => 'La Condamine',
'iso2' => 'CO'
],[
'country_id' => 145,
'name' => 'Moneghetti',
'iso2' => 'MG'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
