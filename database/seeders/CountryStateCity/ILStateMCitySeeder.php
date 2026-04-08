<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ILStateMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1828,
'name' => 'Bet Dagan'
],[
'state_id' => 1828,
'name' => 'Bet Yiẕẖaq'
],[
'state_id' => 1828,
'name' => 'Bnei Ayish'
],[
'state_id' => 1828,
'name' => 'Elyakhin'
],[
'state_id' => 1828,
'name' => 'Even Yehuda'
],[
'state_id' => 1828,
'name' => 'Eṭ Ṭaiyiba'
],[
'state_id' => 1828,
'name' => 'Gan Yavne'
],[
'state_id' => 1828,
'name' => 'Ganei Tikva'
],[
'state_id' => 1828,
'name' => 'Gedera'
],[
'state_id' => 1828,
'name' => 'Hod HaSharon'
],[
'state_id' => 1828,
'name' => 'Jaljūlya'
],[
'state_id' => 1828,
'name' => 'Kafr Qāsim'
],[
'state_id' => 1828,
'name' => 'Kefar H̱abad'
],[
'state_id' => 1828,
'name' => 'Kefar Yona'
],[
'state_id' => 1828,
'name' => 'Kfar Saba'
],[
'state_id' => 1828,
'name' => 'Lapid'
],[
'state_id' => 1828,
'name' => 'Lod'
],[
'state_id' => 1828,
'name' => 'Mazkeret Batya'
],[
'state_id' => 1828,
'name' => 'Modi‘in Makkabbim Re‘ut'
],[
'state_id' => 1828,
'name' => 'Ness Ziona'
],[
'state_id' => 1828,
'name' => 'Netanya'
],[
'state_id' => 1828,
'name' => 'Neẖalim'
],[
'state_id' => 1828,
'name' => 'Nirit'
],[
'state_id' => 1828,
'name' => 'Nof Ayalon'
],[
'state_id' => 1828,
'name' => 'Nordiyya'
],[
'state_id' => 1828,
'name' => 'Pardesiyya'
],[
'state_id' => 1828,
'name' => 'Petaẖ Tiqwa'
],[
'state_id' => 1828,
'name' => 'Qalansuwa'
],[
'state_id' => 1828,
'name' => 'Ra\'anana'
],[
'state_id' => 1828,
'name' => 'Ramla'
],[
'state_id' => 1828,
'name' => 'Reẖovot'
],[
'state_id' => 1828,
'name' => 'Rishon LeẔiyyon'
],[
'state_id' => 1828,
'name' => 'Rosh Ha‘Ayin'
],[
'state_id' => 1828,
'name' => 'Savyon'
],[
'state_id' => 1828,
'name' => 'Shoham'
],[
'state_id' => 1828,
'name' => 'Tel Mond'
],[
'state_id' => 1828,
'name' => 'Tirah'
],[
'state_id' => 1828,
'name' => 'Yavné'
],[
'state_id' => 1828,
'name' => 'Yehud'
],[
'state_id' => 1828,
'name' => 'Ẕur Moshe'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
