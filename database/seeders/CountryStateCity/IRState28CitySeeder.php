<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IRState28CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1775,
'name' => 'Bojnurd'
],[
'state_id' => 1775,
'name' => 'Esfarayen'
],[
'state_id' => 1775,
'name' => 'Raz'
],[
'state_id' => 1775,
'name' => 'Faruj'
],[
'state_id' => 1775,
'name' => 'Jajarm'
],[
'state_id' => 1775,
'name' => 'Maneh va Samalqan'
],[
'state_id' => 1775,
'name' => 'Shirvan'
],[
'state_id' => 1775,
'name' => 'Safiabad'
],[
'state_id' => 1775,
'name' => 'Chenaran Shahr'
],[
'state_id' => 1775,
'name' => 'Hesar-e Garmkhan'
],[
'state_id' => 1775,
'name' => 'Sankhast'
],[
'state_id' => 1775,
'name' => 'Shoqan'
],[
'state_id' => 1775,
'name' => 'Ziarat'
],[
'state_id' => 1775,
'name' => 'Qushkhaneh'
],[
'state_id' => 1775,
'name' => 'Lujali'
],[
'state_id' => 1775,
'name' => 'Titkanlu'
],[
'state_id' => 1775,
'name' => 'Farooj'
],[
'state_id' => 1775,
'name' => 'Ivar'
],[
'state_id' => 1775,
'name' => 'Daraq'
],[
'state_id' => 1775,
'name' => 'Garmeh'
],[
'state_id' => 1775,
'name' => 'Ashkhaneh'
],[
'state_id' => 1775,
'name' => 'Ava'
],[
'state_id' => 1775,
'name' => 'Pish Ghaleh'
],[
'state_id' => 1775,
'name' => 'Qazi'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
