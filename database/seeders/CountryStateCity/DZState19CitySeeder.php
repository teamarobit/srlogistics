<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState19CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 124,
'name' => 'Aïn Arnat'
],[
'state_id' => 124,
'name' => 'BABOR - VILLE'
],[
'state_id' => 124,
'name' => 'Bougaa'
],[
'state_id' => 124,
'name' => 'El Eulma'
],[
'state_id' => 124,
'name' => 'Salah Bey'
],[
'state_id' => 124,
'name' => 'Sétif'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
