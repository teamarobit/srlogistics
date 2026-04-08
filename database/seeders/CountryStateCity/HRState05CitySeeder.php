<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HRState05CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 946,
'name' => 'Beretinec'
],[
'state_id' => 946,
'name' => 'Breznica'
],[
'state_id' => 946,
'name' => 'Breznički Hum'
],[
'state_id' => 946,
'name' => 'Cestica'
],[
'state_id' => 946,
'name' => 'Donje Ladanje'
],[
'state_id' => 946,
'name' => 'Gornje Vratno'
],[
'state_id' => 946,
'name' => 'Gornji Kneginec'
],[
'state_id' => 946,
'name' => 'Grad Ivanec'
],[
'state_id' => 946,
'name' => 'Grad Ludbreg'
],[
'state_id' => 946,
'name' => 'Grad Novi Marof'
],[
'state_id' => 946,
'name' => 'Grad Varaždin'
],[
'state_id' => 946,
'name' => 'Hrašćica'
],[
'state_id' => 946,
'name' => 'Ivanec'
],[
'state_id' => 946,
'name' => 'Jalkovec'
],[
'state_id' => 946,
'name' => 'Jalžabet'
],[
'state_id' => 946,
'name' => 'Klenovnik'
],[
'state_id' => 946,
'name' => 'Kućan Marof'
],[
'state_id' => 946,
'name' => 'Lepoglava'
],[
'state_id' => 946,
'name' => 'Ljubešćica'
],[
'state_id' => 946,
'name' => 'Ludbreg'
],[
'state_id' => 946,
'name' => 'Nedeljanec'
],[
'state_id' => 946,
'name' => 'Petrijanec'
],[
'state_id' => 946,
'name' => 'Remetinec'
],[
'state_id' => 946,
'name' => 'Sračinec'
],[
'state_id' => 946,
'name' => 'Sveti Đurđ'
],[
'state_id' => 946,
'name' => 'Tužno'
],[
'state_id' => 946,
'name' => 'Varaždin'
],[
'state_id' => 946,
'name' => 'Vidovec'
],[
'state_id' => 946,
'name' => 'Vinica'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
