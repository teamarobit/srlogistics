<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ETStateORCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1227,
'name' => 'Arsi Zone'
],[
'state_id' => 1227,
'name' => 'Bedelē'
],[
'state_id' => 1227,
'name' => 'Bedēsa'
],[
'state_id' => 1227,
'name' => 'Bishoftu'
],[
'state_id' => 1227,
'name' => 'Deder'
],[
'state_id' => 1227,
'name' => 'Dembī Dolo'
],[
'state_id' => 1227,
'name' => 'Dodola'
],[
'state_id' => 1227,
'name' => 'East Harerghe Zone'
],[
'state_id' => 1227,
'name' => 'East Shewa Zone'
],[
'state_id' => 1227,
'name' => 'East Wellega Zone'
],[
'state_id' => 1227,
'name' => 'Fichē'
],[
'state_id' => 1227,
'name' => 'Gebre Guracha'
],[
'state_id' => 1227,
'name' => 'Gelemso'
],[
'state_id' => 1227,
'name' => 'Genet'
],[
'state_id' => 1227,
'name' => 'Gimbi'
],[
'state_id' => 1227,
'name' => 'Ginir'
],[
'state_id' => 1227,
'name' => 'Goba'
],[
'state_id' => 1227,
'name' => 'Gorē'
],[
'state_id' => 1227,
'name' => 'Guji Zone'
],[
'state_id' => 1227,
'name' => 'Gēdo'
],[
'state_id' => 1227,
'name' => 'Hagere Maryam'
],[
'state_id' => 1227,
'name' => 'Huruta'
],[
'state_id' => 1227,
'name' => 'Hāgere Hiywet'
],[
'state_id' => 1227,
'name' => 'Hīrna'
],[
'state_id' => 1227,
'name' => 'Illubabor Zone'
],[
'state_id' => 1227,
'name' => 'Jimma'
],[
'state_id' => 1227,
'name' => 'Jimma Zone'
],[
'state_id' => 1227,
'name' => 'Kibre Mengist'
],[
'state_id' => 1227,
'name' => 'Kofelē'
],[
'state_id' => 1227,
'name' => 'Mendī'
],[
'state_id' => 1227,
'name' => 'Metahāra'
],[
'state_id' => 1227,
'name' => 'Metu'
],[
'state_id' => 1227,
'name' => 'Mojo'
],[
'state_id' => 1227,
'name' => 'Mēga'
],[
'state_id' => 1227,
'name' => 'Nazrēt'
],[
'state_id' => 1227,
'name' => 'Nejo'
],[
'state_id' => 1227,
'name' => 'North Shewa Zone'
],[
'state_id' => 1227,
'name' => 'Sebeta'
],[
'state_id' => 1227,
'name' => 'Sendafa'
],[
'state_id' => 1227,
'name' => 'Shakiso'
],[
'state_id' => 1227,
'name' => 'Shambu'
],[
'state_id' => 1227,
'name' => 'Shashemenē'
],[
'state_id' => 1227,
'name' => 'Sirre'
],[
'state_id' => 1227,
'name' => 'Tulu Bolo'
],[
'state_id' => 1227,
'name' => 'Waliso'
],[
'state_id' => 1227,
'name' => 'Wenjī'
],[
'state_id' => 1227,
'name' => 'West Harerghe Zone'
],[
'state_id' => 1227,
'name' => 'West Wellega Zone'
],[
'state_id' => 1227,
'name' => 'Yabēlo'
],[
'state_id' => 1227,
'name' => 'Ziway'
],[
'state_id' => 1227,
'name' => 'Ādīs ‘Alem'
],[
'state_id' => 1227,
'name' => 'Āgaro'
],[
'state_id' => 1227,
'name' => 'Āsasa'
],[
'state_id' => 1227,
'name' => 'Āsbe Teferī'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
