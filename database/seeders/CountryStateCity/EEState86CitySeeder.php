<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EEState86CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1213,
'name' => 'Antsla'
],[
'state_id' => 1213,
'name' => 'Antsla vald'
],[
'state_id' => 1213,
'name' => 'Rõuge'
],[
'state_id' => 1213,
'name' => 'Rõuge vald'
],[
'state_id' => 1213,
'name' => 'Vana-Antsla'
],[
'state_id' => 1213,
'name' => 'Värska'
],[
'state_id' => 1213,
'name' => 'Võru'
],[
'state_id' => 1213,
'name' => 'Võru vald'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
