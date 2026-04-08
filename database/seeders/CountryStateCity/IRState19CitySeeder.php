<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IRState19CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1758,
'name' => 'Abhar'
],[
'state_id' => 1758,
'name' => 'Alvand'
],[
'state_id' => 1758,
'name' => 'Khorramdarreh'
],[
'state_id' => 1758,
'name' => 'Khodabandeh'
],[
'state_id' => 1758,
'name' => 'Mahneshan'
],[
'state_id' => 1758,
'name' => 'Ijrud'
],[
'state_id' => 1758,
'name' => 'Tarom'
],[
'state_id' => 1758,
'name' => 'Soltanieh'
],[
'state_id' => 1758,
'name' => 'Zanjan'
],[
'state_id' => 1758,
'name' => 'Sain Qaleh'
],[
'state_id' => 1758,
'name' => 'Hidaj'
],[
'state_id' => 1758,
'name' => 'Halab'
],[
'state_id' => 1758,
'name' => 'Zarrin Abad'
],[
'state_id' => 1758,
'name' => 'Zarrin Rood'
],[
'state_id' => 1758,
'name' => 'Sojas'
],[
'state_id' => 1758,
'name' => 'Sohrevard'
],[
'state_id' => 1758,
'name' => 'Qeydar'
],[
'state_id' => 1758,
'name' => 'Karasf'
],[
'state_id' => 1758,
'name' => 'Garmaab'
],[
'state_id' => 1758,
'name' => 'Nurbahar'
],[
'state_id' => 1758,
'name' => 'Armaqankhaneh'
],[
'state_id' => 1758,
'name' => 'Nik Pey'
],[
'state_id' => 1758,
'name' => 'Abbar'
],[
'state_id' => 1758,
'name' => 'Chavarzagh'
],[
'state_id' => 1758,
'name' => 'Dandi'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
