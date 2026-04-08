<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IRState30CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1762,
'name' => 'Fardis'
],[
'state_id' => 1762,
'name' => 'Karaj'
],[
'state_id' => 1762,
'name' => 'Nazarabad'
],[
'state_id' => 1762,
'name' => 'Eshtehard'
],[
'state_id' => 1762,
'name' => 'Savojbolagh'
],[
'state_id' => 1762,
'name' => 'Taleqan'
],[
'state_id' => 1762,
'name' => 'Charbagh'
],[
'state_id' => 1762,
'name' => 'Hashtgerd New City'
],[
'state_id' => 1762,
'name' => 'Koohsar'
],[
'state_id' => 1762,
'name' => 'Golsar'
],[
'state_id' => 1762,
'name' => 'Hashtgerd'
],[
'state_id' => 1762,
'name' => 'Asara'
],[
'state_id' => 1762,
'name' => 'Kamalshahr'
],[
'state_id' => 1762,
'name' => 'Garmdareh'
],[
'state_id' => 1762,
'name' => 'Mahdasht'
],[
'state_id' => 1762,
'name' => 'Mohammad Shahr'
],[
'state_id' => 1762,
'name' => 'Tankaman'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
