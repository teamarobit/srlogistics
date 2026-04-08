<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BYStateHOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 427,
'name' => 'Aktsyabrski'
],[
'state_id' => 427,
'name' => 'Brahin'
],[
'state_id' => 427,
'name' => 'Brahinski Rayon'
],[
'state_id' => 427,
'name' => 'Buda-Kashalyova'
],[
'state_id' => 427,
'name' => 'Chachersk'
],[
'state_id' => 427,
'name' => 'Chacherski Rayon'
],[
'state_id' => 427,
'name' => 'Dobrush'
],[
'state_id' => 427,
'name' => 'Dowsk'
],[
'state_id' => 427,
'name' => 'Homyel\''
],[
'state_id' => 427,
'name' => 'Homyel’ski Rayon'
],[
'state_id' => 427,
'name' => 'Kalinkavichy'
],[
'state_id' => 427,
'name' => 'Karanyowka'
],[
'state_id' => 427,
'name' => 'Karma'
],[
'state_id' => 427,
'name' => 'Kastsyukowka'
],[
'state_id' => 427,
'name' => 'Khal’ch'
],[
'state_id' => 427,
'name' => 'Khoyniki'
],[
'state_id' => 427,
'name' => 'Loyew'
],[
'state_id' => 427,
'name' => 'Lyel’chytski Rayon'
],[
'state_id' => 427,
'name' => 'Lyel’chytsy'
],[
'state_id' => 427,
'name' => 'Mazyr'
],[
'state_id' => 427,
'name' => 'Mazyrski Rayon'
],[
'state_id' => 427,
'name' => 'Narowlya'
],[
'state_id' => 427,
'name' => 'Novaya Huta'
],[
'state_id' => 427,
'name' => 'Parychy'
],[
'state_id' => 427,
'name' => 'Peramoga'
],[
'state_id' => 427,
'name' => 'Pyetrykaw'
],[
'state_id' => 427,
'name' => 'Rahachow'
],[
'state_id' => 427,
'name' => 'Rahachowski Rayon'
],[
'state_id' => 427,
'name' => 'Rechytsa'
],[
'state_id' => 427,
'name' => 'Sasnovy Bor'
],[
'state_id' => 427,
'name' => 'Svyetlahorsk'
],[
'state_id' => 427,
'name' => 'Turaw'
],[
'state_id' => 427,
'name' => 'Vasilyevichy'
],[
'state_id' => 427,
'name' => 'Vyetka'
],[
'state_id' => 427,
'name' => 'Vyetkawski Rayon'
],[
'state_id' => 427,
'name' => 'Yel’sk'
],[
'state_id' => 427,
'name' => 'Zhlobin'
],[
'state_id' => 427,
'name' => 'Zhlobinski Rayon'
],[
'state_id' => 427,
'name' => 'Zhytkavichy'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
