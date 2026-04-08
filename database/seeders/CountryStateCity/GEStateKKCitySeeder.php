<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GEStateKKCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1417,
'name' => 'Bolnisi'
],[
'state_id' => 1417,
'name' => 'Bolnisis Munitsip’alit’et’i'
],[
'state_id' => 1417,
'name' => 'Didi Lilo'
],[
'state_id' => 1417,
'name' => 'Dmanisis Munitsip’alit’et’i'
],[
'state_id' => 1417,
'name' => 'Gardabani'
],[
'state_id' => 1417,
'name' => 'Gardabnis Munitsip’alit’et’i'
],[
'state_id' => 1417,
'name' => 'Manglisi'
],[
'state_id' => 1417,
'name' => 'Marneuli'
],[
'state_id' => 1417,
'name' => 'Marneulis Munitsip’alit’et’i'
],[
'state_id' => 1417,
'name' => 'Naghvarevi'
],[
'state_id' => 1417,
'name' => 'Rust’avi'
],[
'state_id' => 1417,
'name' => 'Tetrits’q’alos Munitsip’alit’et’i'
],[
'state_id' => 1417,
'name' => 'Tsalka'
],[
'state_id' => 1417,
'name' => 'Ts’alk’is Munitsip’alit’et’i'
],[
'state_id' => 1417,
'name' => 'T’et’ri Tsqaro'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
