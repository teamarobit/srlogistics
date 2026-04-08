<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AMStateARCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 196,
'name' => 'Abovyan'
],[
'state_id' => 196,
'name' => 'Aralez'
],[
'state_id' => 196,
'name' => 'Ararat'
],[
'state_id' => 196,
'name' => 'Arevabuyr'
],[
'state_id' => 196,
'name' => 'Arevshat'
],[
'state_id' => 196,
'name' => 'Armash'
],[
'state_id' => 196,
'name' => 'Artashat'
],[
'state_id' => 196,
'name' => 'Avshar'
],[
'state_id' => 196,
'name' => 'Aygavan'
],[
'state_id' => 196,
'name' => 'Aygepat'
],[
'state_id' => 196,
'name' => 'Aygestan'
],[
'state_id' => 196,
'name' => 'Aygezard'
],[
'state_id' => 196,
'name' => 'Bardzrashen'
],[
'state_id' => 196,
'name' => 'Berk’anush'
],[
'state_id' => 196,
'name' => 'Burastan'
],[
'state_id' => 196,
'name' => 'Byuravan'
],[
'state_id' => 196,
'name' => 'Dalar'
],[
'state_id' => 196,
'name' => 'Darakert'
],[
'state_id' => 196,
'name' => 'Dashtavan'
],[
'state_id' => 196,
'name' => 'Dimitrov'
],[
'state_id' => 196,
'name' => 'Dvin'
],[
'state_id' => 196,
'name' => 'Getazat'
],[
'state_id' => 196,
'name' => 'Ghukasavan'
],[
'state_id' => 196,
'name' => 'Goravan'
],[
'state_id' => 196,
'name' => 'Hayanist'
],[
'state_id' => 196,
'name' => 'Hovtashat'
],[
'state_id' => 196,
'name' => 'Hovtashen'
],[
'state_id' => 196,
'name' => 'Jrahovit'
],[
'state_id' => 196,
'name' => 'Lusarrat'
],[
'state_id' => 196,
'name' => 'Marmarashen'
],[
'state_id' => 196,
'name' => 'Masis'
],[
'state_id' => 196,
'name' => 'Mrganush'
],[
'state_id' => 196,
'name' => 'Mrgavan'
],[
'state_id' => 196,
'name' => 'Mrgavet'
],[
'state_id' => 196,
'name' => 'Nizami'
],[
'state_id' => 196,
'name' => 'Norabats’'
],[
'state_id' => 196,
'name' => 'Noramarg'
],[
'state_id' => 196,
'name' => 'Norashen'
],[
'state_id' => 196,
'name' => 'Noyakert'
],[
'state_id' => 196,
'name' => 'Nshavan'
],[
'state_id' => 196,
'name' => 'Sayat’-Nova'
],[
'state_id' => 196,
'name' => 'Shahumyan'
],[
'state_id' => 196,
'name' => 'Sis'
],[
'state_id' => 196,
'name' => 'Sisavan'
],[
'state_id' => 196,
'name' => 'Surenavan'
],[
'state_id' => 196,
'name' => 'Vedi'
],[
'state_id' => 196,
'name' => 'Verin Artashat'
],[
'state_id' => 196,
'name' => 'Verin Dvin'
],[
'state_id' => 196,
'name' => 'Vosketap’'
],[
'state_id' => 196,
'name' => 'Vostan'
],[
'state_id' => 196,
'name' => 'Yeghegnavan'
],[
'state_id' => 196,
'name' => 'Zangakatun'
],[
'state_id' => 196,
'name' => 'Zorak'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
