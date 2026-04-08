<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateXJCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 801,
'name' => 'Ailan Mubage'
],[
'state_id' => 801,
'name' => 'Aksu'
],[
'state_id' => 801,
'name' => 'Aksu Diqu'
],[
'state_id' => 801,
'name' => 'Altay'
],[
'state_id' => 801,
'name' => 'Altay Diqu'
],[
'state_id' => 801,
'name' => 'Aral'
],[
'state_id' => 801,
'name' => 'Aykol'
],[
'state_id' => 801,
'name' => 'Baijiantan'
],[
'state_id' => 801,
'name' => 'Baluntaicun'
],[
'state_id' => 801,
'name' => 'Bayingolin Mongol Zizhizhou'
],[
'state_id' => 801,
'name' => 'Changji'
],[
'state_id' => 801,
'name' => 'Changji Huizu Zizhizhou'
],[
'state_id' => 801,
'name' => 'Fukang'
],[
'state_id' => 801,
'name' => 'Hami'
],[
'state_id' => 801,
'name' => 'Hotan'
],[
'state_id' => 801,
'name' => 'Hoxtolgay'
],[
'state_id' => 801,
'name' => 'Huocheng'
],[
'state_id' => 801,
'name' => 'Ili Kazak Zizhizhou'
],[
'state_id' => 801,
'name' => 'Karamay'
],[
'state_id' => 801,
'name' => 'Karamay Shi'
],[
'state_id' => 801,
'name' => 'Kashgar'
],[
'state_id' => 801,
'name' => 'Kaxgar Diqu'
],[
'state_id' => 801,
'name' => 'Korla'
],[
'state_id' => 801,
'name' => 'Kuqa'
],[
'state_id' => 801,
'name' => 'Kuytun'
],[
'state_id' => 801,
'name' => 'Qapqal'
],[
'state_id' => 801,
'name' => 'Shache'
],[
'state_id' => 801,
'name' => 'Shihezi'
],[
'state_id' => 801,
'name' => 'Sishilichengzi'
],[
'state_id' => 801,
'name' => 'Tacheng'
],[
'state_id' => 801,
'name' => 'Tacheng Diqu'
],[
'state_id' => 801,
'name' => 'Turpan'
],[
'state_id' => 801,
'name' => 'Turpan Diqu'
],[
'state_id' => 801,
'name' => 'Urumqi Shi'
],[
'state_id' => 801,
'name' => 'Xinyuan'
],[
'state_id' => 801,
'name' => 'Zangguy'
],[
'state_id' => 801,
'name' => 'Ürümqi'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
