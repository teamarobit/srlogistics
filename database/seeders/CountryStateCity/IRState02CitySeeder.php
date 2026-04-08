<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IRState02CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1771,
'name' => 'Behshahr'
],[
'state_id' => 1771,
'name' => 'Babol'
],[
'state_id' => 1771,
'name' => 'Babolsar'
],[
'state_id' => 1771,
'name' => 'Chalus'
],[
'state_id' => 1771,
'name' => 'Fereydunkenar'
],[
'state_id' => 1771,
'name' => 'Juybar'
],[
'state_id' => 1771,
'name' => 'Nashtarud'
],[
'state_id' => 1771,
'name' => 'Neka'
],[
'state_id' => 1771,
'name' => 'Nowshahr'
],[
'state_id' => 1771,
'name' => 'Sari'
],[
'state_id' => 1771,
'name' => 'Savadkuh'
],[
'state_id' => 1771,
'name' => 'Kalar Dasht'
],[
'state_id' => 1771,
'name' => 'Galugah'
],[
'state_id' => 1771,
'name' => 'Mahmudabad'
],[
'state_id' => 1771,
'name' => 'Miandorud'
],[
'state_id' => 1771,
'name' => 'Nur'
],[
'state_id' => 1771,
'name' => 'Qaem Shahr'
],[
'state_id' => 1771,
'name' => 'Ramsar'
],[
'state_id' => 1771,
'name' => 'Abbasabad'
],[
'state_id' => 1771,
'name' => 'Simorgh County'
],[
'state_id' => 1771,
'name' => 'Tonekabon'
],[
'state_id' => 1771,
'name' => 'Amol'
],[
'state_id' => 1771,
'name' => 'Emamzade Abdollah'
],[
'state_id' => 1771,
'name' => 'Dabudasht'
],[
'state_id' => 1771,
'name' => 'Rineh'
],[
'state_id' => 1771,
'name' => 'Gazanak'
],[
'state_id' => 1771,
'name' => 'Amir Kala'
],[
'state_id' => 1771,
'name' => 'Khoshroud Pey'
],[
'state_id' => 1771,
'name' => 'Zargarmahalleh'
],[
'state_id' => 1771,
'name' => 'Gatab'
],[
'state_id' => 1771,
'name' => 'Marzikola'
],[
'state_id' => 1771,
'name' => 'Bahnamir'
],[
'state_id' => 1771,
'name' => 'Kalleh Bast'
],[
'state_id' => 1771,
'name' => 'Khalil Shahr'
],[
'state_id' => 1771,
'name' => 'Rostam kola'
],[
'state_id' => 1771,
'name' => 'Khorramabad'
],[
'state_id' => 1771,
'name' => 'Shirud'
],[
'state_id' => 1771,
'name' => 'Kuhi Khil'
],[
'state_id' => 1771,
'name' => 'Marzanabad'
],[
'state_id' => 1771,
'name' => 'Hachiroud'
],[
'state_id' => 1771,
'name' => 'Ketalem and Sadat Shahr'
],[
'state_id' => 1771,
'name' => 'Paein Hoular'
],[
'state_id' => 1771,
'name' => 'Farim'
],[
'state_id' => 1771,
'name' => 'Kiasar'
],[
'state_id' => 1771,
'name' => 'Alasht'
],[
'state_id' => 1771,
'name' => 'Pol Sefid'
],[
'state_id' => 1771,
'name' => 'Zirab'
],[
'state_id' => 1771,
'name' => 'Shirgah'
],[
'state_id' => 1771,
'name' => 'Kia Kola'
],[
'state_id' => 1771,
'name' => 'Salman Shahr'
],[
'state_id' => 1771,
'name' => 'Kelarabad'
],[
'state_id' => 1771,
'name' => 'Arateh'
],[
'state_id' => 1771,
'name' => 'Qaemshahr'
],[
'state_id' => 1771,
'name' => 'Kelardasht'
],[
'state_id' => 1771,
'name' => 'Sorkh Roud'
],[
'state_id' => 1771,
'name' => 'Surak'
],[
'state_id' => 1771,
'name' => 'Izadshahr'
],[
'state_id' => 1771,
'name' => 'Baladeh'
],[
'state_id' => 1771,
'name' => 'Chamestan'
],[
'state_id' => 1771,
'name' => 'Royan'
],[
'state_id' => 1771,
'name' => 'Pul'
],[
'state_id' => 1771,
'name' => 'Kojur'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
