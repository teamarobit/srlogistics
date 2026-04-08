<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AMStateAVCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 198,
'name' => 'Aghavnatun'
],[
'state_id' => 198,
'name' => 'Aknalich'
],[
'state_id' => 198,
'name' => 'Aknashen'
],[
'state_id' => 198,
'name' => 'Alashkert'
],[
'state_id' => 198,
'name' => 'Apaga'
],[
'state_id' => 198,
'name' => 'Arak’s'
],[
'state_id' => 198,
'name' => 'Arazap’'
],[
'state_id' => 198,
'name' => 'Arbat’'
],[
'state_id' => 198,
'name' => 'Arevashat'
],[
'state_id' => 198,
'name' => 'Arevik'
],[
'state_id' => 198,
'name' => 'Argavand'
],[
'state_id' => 198,
'name' => 'Armavir'
],[
'state_id' => 198,
'name' => 'Arshaluys'
],[
'state_id' => 198,
'name' => 'Artimet'
],[
'state_id' => 198,
'name' => 'Aygek'
],[
'state_id' => 198,
'name' => 'Aygeshat'
],[
'state_id' => 198,
'name' => 'Baghramyan'
],[
'state_id' => 198,
'name' => 'Bambakashat'
],[
'state_id' => 198,
'name' => 'Dalarik'
],[
'state_id' => 198,
'name' => 'Doghs'
],[
'state_id' => 198,
'name' => 'Gay'
],[
'state_id' => 198,
'name' => 'Geghakert'
],[
'state_id' => 198,
'name' => 'Geghanist'
],[
'state_id' => 198,
'name' => 'Getashen'
],[
'state_id' => 198,
'name' => 'Gmbet’'
],[
'state_id' => 198,
'name' => 'Griboyedov'
],[
'state_id' => 198,
'name' => 'Haykashen'
],[
'state_id' => 198,
'name' => 'Hovtamej'
],[
'state_id' => 198,
'name' => 'Janfida'
],[
'state_id' => 198,
'name' => 'Khoronk’'
],[
'state_id' => 198,
'name' => 'Lenughi'
],[
'state_id' => 198,
'name' => 'Lukashin'
],[
'state_id' => 198,
'name' => 'Margara'
],[
'state_id' => 198,
'name' => 'Mayisyan'
],[
'state_id' => 198,
'name' => 'Merdzavan'
],[
'state_id' => 198,
'name' => 'Metsamor'
],[
'state_id' => 198,
'name' => 'Mrgashat'
],[
'state_id' => 198,
'name' => 'Musalerr'
],[
'state_id' => 198,
'name' => 'Myasnikyan'
],[
'state_id' => 198,
'name' => 'Nalbandyan'
],[
'state_id' => 198,
'name' => 'Nor Armavir'
],[
'state_id' => 198,
'name' => 'Norakert'
],[
'state_id' => 198,
'name' => 'Ptghunk’'
],[
'state_id' => 198,
'name' => 'P’shatavan'
],[
'state_id' => 198,
'name' => 'Sardarapat'
],[
'state_id' => 198,
'name' => 'Shenavan'
],[
'state_id' => 198,
'name' => 'Tandzut'
],[
'state_id' => 198,
'name' => 'Taronik'
],[
'state_id' => 198,
'name' => 'Tsaghkunk’'
],[
'state_id' => 198,
'name' => 'Tsiatsan'
],[
'state_id' => 198,
'name' => 'Vagharshapat'
],[
'state_id' => 198,
'name' => 'Voskehat'
],[
'state_id' => 198,
'name' => 'Yeghegnut'
],[
'state_id' => 198,
'name' => 'Yeraskhahun'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
