<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IQStateBGCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1785,
'name' => 'Abu Ghraib District'
],[
'state_id' => 1785,
'name' => 'Abū Ghurayb'
],[
'state_id' => 1785,
'name' => 'Baghdad'
],[
'state_id' => 1785,
'name' => 'Adamiyah'
],[
'state_id' => 1785,
'name' => 'Al Adel'
],[
'state_id' => 1785,
'name' => 'Al Baladiyat'
],[
'state_id' => 1785,
'name' => 'Al Jamaa'
],[
'state_id' => 1785,
'name' => 'Al Saadoon Park'
],[
'state_id' => 1785,
'name' => 'Al Salhiah'
],[
'state_id' => 1785,
'name' => 'Al Za\'franiya'
],[
'state_id' => 1785,
'name' => 'Al-Ubaidi'
],[
'state_id' => 1785,
'name' => 'Al-Wahda'
],[
'state_id' => 1785,
'name' => 'Ameria'
],[
'state_id' => 1785,
'name' => 'Amil District'
],[
'state_id' => 1785,
'name' => 'Amin'
],[
'state_id' => 1785,
'name' => 'Arasat AlHindiya'
],[
'state_id' => 1785,
'name' => 'At Taifiya'
],[
'state_id' => 1785,
'name' => 'Bab Al Moatham'
],[
'state_id' => 1785,
'name' => 'Bab Al Sharqi'
],[
'state_id' => 1785,
'name' => 'Baghdad Al Jadeeda'
],[
'state_id' => 1785,
'name' => 'Baijai'
],[
'state_id' => 1785,
'name' => 'Bataween'
],[
'state_id' => 1785,
'name' => 'Bayaa'
],[
'state_id' => 1785,
'name' => 'Binouk'
],[
'state_id' => 1785,
'name' => 'Bo\'aitha'
],[
'state_id' => 1785,
'name' => 'Camp Sarah'
],[
'state_id' => 1785,
'name' => 'Daoudi'
],[
'state_id' => 1785,
'name' => 'Dora'
],[
'state_id' => 1785,
'name' => 'Ghadeer'
],[
'state_id' => 1785,
'name' => 'Ghazaliya'
],[
'state_id' => 1785,
'name' => 'Gherai\'at'
],[
'state_id' => 1785,
'name' => 'Green Zone'
],[
'state_id' => 1785,
'name' => 'Habibiya'
],[
'state_id' => 1785,
'name' => 'Harthiya'
],[
'state_id' => 1785,
'name' => 'Hurriya'
],[
'state_id' => 1785,
'name' => 'Iskan'
],[
'state_id' => 1785,
'name' => 'Jadriyah'
],[
'state_id' => 1785,
'name' => 'Jamila'
],[
'state_id' => 1785,
'name' => 'Jihad'
],[
'state_id' => 1785,
'name' => 'Kadhimiya'
],[
'state_id' => 1785,
'name' => 'Kamaliyah'
],[
'state_id' => 1785,
'name' => 'Karada'
],[
'state_id' => 1785,
'name' => 'Khadra'
],[
'state_id' => 1785,
'name' => 'Mansour'
],[
'state_id' => 1785,
'name' => 'Mashtal'
],[
'state_id' => 1785,
'name' => 'Mustansiriya'
],[
'state_id' => 1785,
'name' => 'Qadisiyah'
],[
'state_id' => 1785,
'name' => 'Sadr City'
],[
'state_id' => 1785,
'name' => 'Saidiya'
],[
'state_id' => 1785,
'name' => 'Sha\'ab'
],[
'state_id' => 1785,
'name' => 'Sheik Maaruf'
],[
'state_id' => 1785,
'name' => 'Shorjah'
],[
'state_id' => 1785,
'name' => 'Suleikh'
],[
'state_id' => 1785,
'name' => 'Ur District'
],[
'state_id' => 1785,
'name' => 'Wazireya'
],[
'state_id' => 1785,
'name' => 'Yarmouk'
],[
'state_id' => 1785,
'name' => 'Ziyouna'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
