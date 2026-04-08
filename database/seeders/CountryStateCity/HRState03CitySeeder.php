<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HRState03CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 940,
'name' => 'Budaševo'
],[
'state_id' => 940,
'name' => 'Dvor'
],[
'state_id' => 940,
'name' => 'Glina'
],[
'state_id' => 940,
'name' => 'Grad Glina'
],[
'state_id' => 940,
'name' => 'Grad Hrvatska Kostajnica'
],[
'state_id' => 940,
'name' => 'Grad Kutina'
],[
'state_id' => 940,
'name' => 'Grad Novska'
],[
'state_id' => 940,
'name' => 'Grad Petrinja'
],[
'state_id' => 940,
'name' => 'Grad Sisak'
],[
'state_id' => 940,
'name' => 'Gvozd'
],[
'state_id' => 940,
'name' => 'Hrvatska Kostajnica'
],[
'state_id' => 940,
'name' => 'Kutina'
],[
'state_id' => 940,
'name' => 'Lekenik'
],[
'state_id' => 940,
'name' => 'Lipovljani'
],[
'state_id' => 940,
'name' => 'Martinska Ves'
],[
'state_id' => 940,
'name' => 'Novska'
],[
'state_id' => 940,
'name' => 'Općina Dvor'
],[
'state_id' => 940,
'name' => 'Općina Gvozd'
],[
'state_id' => 940,
'name' => 'Petrinja'
],[
'state_id' => 940,
'name' => 'Popovača'
],[
'state_id' => 940,
'name' => 'Repušnica'
],[
'state_id' => 940,
'name' => 'Sisak'
],[
'state_id' => 940,
'name' => 'Sunja'
],[
'state_id' => 940,
'name' => 'Voloder'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
