<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class WSStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 191,
'name' => 'Aiga-i-le-Tai',
'iso2' => 'AL'
],[
'country_id' => 191,
'name' => 'Satupa\'itea',
'iso2' => 'SA'
],[
'country_id' => 191,
'name' => 'A\'ana',
'iso2' => 'AA'
],[
'country_id' => 191,
'name' => 'Fa\'asaleleaga',
'iso2' => 'FA'
],[
'country_id' => 191,
'name' => 'Atua',
'iso2' => 'AT'
],[
'country_id' => 191,
'name' => 'Vaisigano',
'iso2' => 'VS'
],[
'country_id' => 191,
'name' => 'Palauli',
'iso2' => 'PA'
],[
'country_id' => 191,
'name' => 'Va\'a-o-Fonoti',
'iso2' => 'VF'
],[
'country_id' => 191,
'name' => 'Gaga\'emauga',
'iso2' => 'GE'
],[
'country_id' => 191,
'name' => 'Tuamasaga',
'iso2' => 'TU'
],[
'country_id' => 191,
'name' => 'Gaga\'ifomauga',
'iso2' => 'GI'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
