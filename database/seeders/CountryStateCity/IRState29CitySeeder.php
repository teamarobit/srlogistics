<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IRState29CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1763,
'name' => 'Boshruyeh'
],[
'state_id' => 1763,
'name' => 'Qaen'
],[
'state_id' => 1763,
'name' => 'Birjand'
],[
'state_id' => 1763,
'name' => 'Darmian'
],[
'state_id' => 1763,
'name' => 'Khusf'
],[
'state_id' => 1763,
'name' => 'Nehbandan'
],[
'state_id' => 1763,
'name' => 'Sarbisheh'
],[
'state_id' => 1763,
'name' => 'Sarayan'
],[
'state_id' => 1763,
'name' => 'Zirkuh'
],[
'state_id' => 1763,
'name' => 'Tabas'
],[
'state_id' => 1763,
'name' => 'Eresk'
],[
'state_id' => 1763,
'name' => 'Boshrouyeh'
],[
'state_id' => 1763,
'name' => 'Mohammad Shahr'
],[
'state_id' => 1763,
'name' => 'Asadieh'
],[
'state_id' => 1763,
'name' => 'Tabas Masina'
],[
'state_id' => 1763,
'name' => 'Ghohestan'
],[
'state_id' => 1763,
'name' => 'Gazik'
],[
'state_id' => 1763,
'name' => 'Hajiabad'
],[
'state_id' => 1763,
'name' => 'Zohaan'
],[
'state_id' => 1763,
'name' => 'Ayask'
],[
'state_id' => 1763,
'name' => 'Seh Qaleh'
],[
'state_id' => 1763,
'name' => 'Sarbishe'
],[
'state_id' => 1763,
'name' => 'Mud'
],[
'state_id' => 1763,
'name' => 'Deyhuk'
],[
'state_id' => 1763,
'name' => 'Eshqabad'
],[
'state_id' => 1763,
'name' => 'Eslamiyeh'
],[
'state_id' => 1763,
'name' => 'Ferdows'
],[
'state_id' => 1763,
'name' => 'Arian Shahr'
],[
'state_id' => 1763,
'name' => 'Esfedan'
],[
'state_id' => 1763,
'name' => 'Khezri Dashtebayaz'
],[
'state_id' => 1763,
'name' => 'Ghayen'
],[
'state_id' => 1763,
'name' => 'Nimbolook'
],[
'state_id' => 1763,
'name' => 'Shusf'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
