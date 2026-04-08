<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ILStateZCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1827,
'name' => 'Acre'
],[
'state_id' => 1827,
'name' => 'Afula'
],[
'state_id' => 1827,
'name' => 'Basmat Ṭab‘ūn'
],[
'state_id' => 1827,
'name' => 'Beit Jann'
],[
'state_id' => 1827,
'name' => 'Bet She’an'
],[
'state_id' => 1827,
'name' => 'Buqei‘a'
],[
'state_id' => 1827,
'name' => 'Bu‘eina'
],[
'state_id' => 1827,
'name' => 'Bīr el Maksūr'
],[
'state_id' => 1827,
'name' => 'Dabbūrīya'
],[
'state_id' => 1827,
'name' => 'Deir Ḥannā'
],[
'state_id' => 1827,
'name' => 'El Mazra‘a'
],[
'state_id' => 1827,
'name' => 'Er Reina'
],[
'state_id' => 1827,
'name' => 'Esh Sheikh Dannūn'
],[
'state_id' => 1827,
'name' => 'Iksāl'
],[
'state_id' => 1827,
'name' => 'Judeida Makr'
],[
'state_id' => 1827,
'name' => 'Jīsh'
],[
'state_id' => 1827,
'name' => 'Kafr Kammā'
],[
'state_id' => 1827,
'name' => 'Kafr Kannā'
],[
'state_id' => 1827,
'name' => 'Kafr Mandā'
],[
'state_id' => 1827,
'name' => 'Kafr Miṣr'
],[
'state_id' => 1827,
'name' => 'Karmi’el'
],[
'state_id' => 1827,
'name' => 'Kaukab Abū el Hījā'
],[
'state_id' => 1827,
'name' => 'Kefar Rosh HaNiqra'
],[
'state_id' => 1827,
'name' => 'Kefar Tavor'
],[
'state_id' => 1827,
'name' => 'Kefar Weradim'
],[
'state_id' => 1827,
'name' => 'Kfar Yasif'
],[
'state_id' => 1827,
'name' => 'Kābūl'
],[
'state_id' => 1827,
'name' => 'Maghār'
],[
'state_id' => 1827,
'name' => 'Metulla'
],[
'state_id' => 1827,
'name' => 'Migdal Ha‘Emeq'
],[
'state_id' => 1827,
'name' => 'Mi‘ilyā'
],[
'state_id' => 1827,
'name' => 'Nahariyya'
],[
'state_id' => 1827,
'name' => 'Nazareth'
],[
'state_id' => 1827,
'name' => 'Naḥf'
],[
'state_id' => 1827,
'name' => 'Nefat ‘Akko'
],[
'state_id' => 1827,
'name' => 'Nein'
],[
'state_id' => 1827,
'name' => 'Pasuta'
],[
'state_id' => 1827,
'name' => 'Qiryat Shemona'
],[
'state_id' => 1827,
'name' => 'Ramat Yishay'
],[
'state_id' => 1827,
'name' => 'Rosh Pinna'
],[
'state_id' => 1827,
'name' => 'Rumat Heib'
],[
'state_id' => 1827,
'name' => 'Safed'
],[
'state_id' => 1827,
'name' => 'Sakhnīn'
],[
'state_id' => 1827,
'name' => 'Sallama'
],[
'state_id' => 1827,
'name' => 'Shelomi'
],[
'state_id' => 1827,
'name' => 'Shibli'
],[
'state_id' => 1827,
'name' => 'Sājūr'
],[
'state_id' => 1827,
'name' => 'Sūlam'
],[
'state_id' => 1827,
'name' => 'Tamra'
],[
'state_id' => 1827,
'name' => 'Tiberias'
],[
'state_id' => 1827,
'name' => 'Timrat'
],[
'state_id' => 1827,
'name' => 'Yavne’el'
],[
'state_id' => 1827,
'name' => 'maalot Tarshīhā'
],[
'state_id' => 1827,
'name' => 'Ḥurfeish'
],[
'state_id' => 1827,
'name' => '‘Eilabun'
],[
'state_id' => 1827,
'name' => '‘Uzeir'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
