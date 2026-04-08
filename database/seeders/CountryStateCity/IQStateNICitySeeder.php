<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IQStateNICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1789,
'name' => 'Al Mawşil al Jadīdah'
],[
'state_id' => 1789,
'name' => 'Al-Hamdaniya'
],[
'state_id' => 1789,
'name' => 'Ash Shaykhān'
],[
'state_id' => 1789,
'name' => 'Mosul'
],[
'state_id' => 1789,
'name' => 'Sinjar'
],[
'state_id' => 1789,
'name' => 'Tall ‘Afar'
],[
'state_id' => 1789,
'name' => 'Tallkayf'
],[
'state_id' => 1789,
'name' => '‘Aqrah'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
