<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IRState18CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1765,
'name' => 'Ahram'
],[
'state_id' => 1765,
'name' => 'Bandar Ganaveh'
],[
'state_id' => 1765,
'name' => 'Borazjan'
],[
'state_id' => 1765,
'name' => 'Bushehr'
],[
'state_id' => 1765,
'name' => 'Deylam'
],[
'state_id' => 1765,
'name' => 'Khark'
],[
'state_id' => 1765,
'name' => 'Dashtestan'
],[
'state_id' => 1765,
'name' => 'Dashti'
],[
'state_id' => 1765,
'name' => 'Genaveh'
],[
'state_id' => 1765,
'name' => 'Kangan'
],[
'state_id' => 1765,
'name' => 'Tangestan'
],[
'state_id' => 1765,
'name' => 'Asaluyeh'
],[
'state_id' => 1765,
'name' => 'Bandar Bushehr'
],[
'state_id' => 1765,
'name' => 'Choghadak'
],[
'state_id' => 1765,
'name' => 'Kharg'
],[
'state_id' => 1765,
'name' => 'Alishahr'
],[
'state_id' => 1765,
'name' => 'Abad'
],[
'state_id' => 1765,
'name' => 'Delvar'
],[
'state_id' => 1765,
'name' => 'Anarestan'
],[
'state_id' => 1765,
'name' => 'Jam'
],[
'state_id' => 1765,
'name' => 'Riz'
],[
'state_id' => 1765,
'name' => 'Ab Pakhsh'
],[
'state_id' => 1765,
'name' => 'Boshkan'
],[
'state_id' => 1765,
'name' => 'Tang Eram'
],[
'state_id' => 1765,
'name' => 'Dalaki'
],[
'state_id' => 1765,
'name' => 'Sadabad'
],[
'state_id' => 1765,
'name' => 'Shaban Kareh'
],[
'state_id' => 1765,
'name' => 'Kalameh'
],[
'state_id' => 1765,
'name' => 'Vahdatiyeh'
],[
'state_id' => 1765,
'name' => 'Baduleh'
],[
'state_id' => 1765,
'name' => 'Khormoj'
],[
'state_id' => 1765,
'name' => 'Shonbeh'
],[
'state_id' => 1765,
'name' => 'Kaki'
],[
'state_id' => 1765,
'name' => 'Konar Torshan'
],[
'state_id' => 1765,
'name' => 'Bord Khun'
],[
'state_id' => 1765,
'name' => 'Bardestan'
],[
'state_id' => 1765,
'name' => 'Dayyer'
],[
'state_id' => 1765,
'name' => 'Dorahak'
],[
'state_id' => 1765,
'name' => 'Imam Hassan'
],[
'state_id' => 1765,
'name' => 'Bandar Deylam'
],[
'state_id' => 1765,
'name' => 'Nakhl Taghi'
],[
'state_id' => 1765,
'name' => 'Bandar-e Kangan'
],[
'state_id' => 1765,
'name' => 'Banak'
],[
'state_id' => 1765,
'name' => 'BandarSiraf'
],[
'state_id' => 1765,
'name' => 'Bandar Rig'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
