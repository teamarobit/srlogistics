<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IRState20CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1773,
'name' => 'Damghan'
],[
'state_id' => 1773,
'name' => 'Mahdishahr'
],[
'state_id' => 1773,
'name' => 'Semnan'
],[
'state_id' => 1773,
'name' => 'Garmsar'
],[
'state_id' => 1773,
'name' => 'Mayamey'
],[
'state_id' => 1773,
'name' => 'Shahrud'
],[
'state_id' => 1773,
'name' => 'Aradan'
],[
'state_id' => 1773,
'name' => 'Kohanabad'
],[
'state_id' => 1773,
'name' => 'Amiriyeh'
],[
'state_id' => 1773,
'name' => 'Dibaj'
],[
'state_id' => 1773,
'name' => 'Kalāteh'
],[
'state_id' => 1773,
'name' => 'Sorkheh'
],[
'state_id' => 1773,
'name' => 'Bastam'
],[
'state_id' => 1773,
'name' => 'Biyārjomand'
],[
'state_id' => 1773,
'name' => 'Rodian'
],[
'state_id' => 1773,
'name' => 'Shahroud'
],[
'state_id' => 1773,
'name' => 'kalāte Khij'
],[
'state_id' => 1773,
'name' => 'Mojen'
],[
'state_id' => 1773,
'name' => 'Eyvanekey'
],[
'state_id' => 1773,
'name' => 'Darjazin'
],[
'state_id' => 1773,
'name' => 'Shahmirzad'
],[
'state_id' => 1773,
'name' => 'Mahdi Shahr'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
