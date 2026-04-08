<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HRState07CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 941,
'name' => 'Bjelovar'
],[
'state_id' => 941,
'name' => 'Brezovac'
],[
'state_id' => 941,
'name' => 'Daruvar'
],[
'state_id' => 941,
'name' => 'Dežanovac'
],[
'state_id' => 941,
'name' => 'Garešnica'
],[
'state_id' => 941,
'name' => 'Grad Bjelovar'
],[
'state_id' => 941,
'name' => 'Grad Daruvar'
],[
'state_id' => 941,
'name' => 'Grad Garešnica'
],[
'state_id' => 941,
'name' => 'Grad Grubišno Polje'
],[
'state_id' => 941,
'name' => 'Grad Čazma'
],[
'state_id' => 941,
'name' => 'Grubišno Polje'
],[
'state_id' => 941,
'name' => 'Gudovac'
],[
'state_id' => 941,
'name' => 'Hercegovac'
],[
'state_id' => 941,
'name' => 'Ivanska'
],[
'state_id' => 941,
'name' => 'Kapela'
],[
'state_id' => 941,
'name' => 'Končanica'
],[
'state_id' => 941,
'name' => 'Predavac'
],[
'state_id' => 941,
'name' => 'Rovišće'
],[
'state_id' => 941,
'name' => 'Severin'
],[
'state_id' => 941,
'name' => 'Sirač'
],[
'state_id' => 941,
'name' => 'Velika Pisanica'
],[
'state_id' => 941,
'name' => 'Veliki Grđevac'
],[
'state_id' => 941,
'name' => 'Zrinski Topolovac'
],[
'state_id' => 941,
'name' => 'Čazma'
],[
'state_id' => 941,
'name' => 'Đulovac'
],[
'state_id' => 941,
'name' => 'Šandrovac'
],[
'state_id' => 941,
'name' => 'Ždralovi'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
