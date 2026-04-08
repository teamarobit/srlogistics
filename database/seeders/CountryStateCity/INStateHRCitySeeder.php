<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class INStateHRCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1680,
'name' => 'Ambala'
],[
'state_id' => 1680,
'name' => 'Ateli Mandi'
],[
'state_id' => 1680,
'name' => 'Bahadurgarh'
],[
'state_id' => 1680,
'name' => 'Bara Uchana'
],[
'state_id' => 1680,
'name' => 'Barwala'
],[
'state_id' => 1680,
'name' => 'Beri Khas'
],[
'state_id' => 1680,
'name' => 'Bhiwani'
],[
'state_id' => 1680,
'name' => 'Bilaspur'
],[
'state_id' => 1680,
'name' => 'Bawal'
],[
'state_id' => 1680,
'name' => 'Buriya'
],[
'state_id' => 1680,
'name' => 'Charkhi Dadri'
],[
'state_id' => 1680,
'name' => 'Chhachhrauli'
],[
'state_id' => 1680,
'name' => 'Dabwali'
],[
'state_id' => 1680,
'name' => 'Dharuhera'
],[
'state_id' => 1680,
'name' => 'Ellenabad'
],[
'state_id' => 1680,
'name' => 'Faridabad'
],[
'state_id' => 1680,
'name' => 'Farrukhnagar'
],[
'state_id' => 1680,
'name' => 'Fatehabad'
],[
'state_id' => 1680,
'name' => 'Firozpur Jhirka'
],[
'state_id' => 1680,
'name' => 'Gharaunda'
],[
'state_id' => 1680,
'name' => 'Gohana'
],[
'state_id' => 1680,
'name' => 'Gorakhpur'
],[
'state_id' => 1680,
'name' => 'Gurgaon'
],[
'state_id' => 1680,
'name' => 'Hasanpur'
],[
'state_id' => 1680,
'name' => 'Hisar'
],[
'state_id' => 1680,
'name' => 'Hodal'
],[
'state_id' => 1680,
'name' => 'Hansi'
],[
'state_id' => 1680,
'name' => 'Inda Chhoi'
],[
'state_id' => 1680,
'name' => 'Indri'
],[
'state_id' => 1680,
'name' => 'Jagadhri'
],[
'state_id' => 1680,
'name' => 'Jhajjar'
],[
'state_id' => 1680,
'name' => 'Jakhal'
],[
'state_id' => 1680,
'name' => 'Jind'
],[
'state_id' => 1680,
'name' => 'Kaithal'
],[
'state_id' => 1680,
'name' => 'Kalanaur'
],[
'state_id' => 1680,
'name' => 'Kanina Khas'
],[
'state_id' => 1680,
'name' => 'Karnal'
],[
'state_id' => 1680,
'name' => 'Kharkhauda'
],[
'state_id' => 1680,
'name' => 'Kheri Sampla'
],[
'state_id' => 1680,
'name' => 'Kurukshetra'
],[
'state_id' => 1680,
'name' => 'Kalanwali'
],[
'state_id' => 1680,
'name' => 'Loharu'
],[
'state_id' => 1680,
'name' => 'Ladwa'
],[
'state_id' => 1680,
'name' => 'Maham'
],[
'state_id' => 1680,
'name' => 'Mahendragarh'
],[
'state_id' => 1680,
'name' => 'Mandholi Kalan'
],[
'state_id' => 1680,
'name' => 'Mustafabad'
],[
'state_id' => 1680,
'name' => 'Narwana'
],[
'state_id' => 1680,
'name' => 'Narayangarh'
],[
'state_id' => 1680,
'name' => 'Narnaul'
],[
'state_id' => 1680,
'name' => 'Narnaund'
],[
'state_id' => 1680,
'name' => 'Nilokheri'
],[
'state_id' => 1680,
'name' => 'Nuh'
],[
'state_id' => 1680,
'name' => 'Palwal'
],[
'state_id' => 1680,
'name' => 'Panchkula'
],[
'state_id' => 1680,
'name' => 'Panipat'
],[
'state_id' => 1680,
'name' => 'Pataudi'
],[
'state_id' => 1680,
'name' => 'Pehowa'
],[
'state_id' => 1680,
'name' => 'Pinjaur'
],[
'state_id' => 1680,
'name' => 'Pundri'
],[
'state_id' => 1680,
'name' => 'Punahana'
],[
'state_id' => 1680,
'name' => 'Radaur'
],[
'state_id' => 1680,
'name' => 'Ratia'
],[
'state_id' => 1680,
'name' => 'Rewari'
],[
'state_id' => 1680,
'name' => 'Rohtak'
],[
'state_id' => 1680,
'name' => 'Rania'
],[
'state_id' => 1680,
'name' => 'Safidon'
],[
'state_id' => 1680,
'name' => 'Samalkha'
],[
'state_id' => 1680,
'name' => 'Shadipur Julana'
],[
'state_id' => 1680,
'name' => 'Shahabad'
],[
'state_id' => 1680,
'name' => 'Sirsa'
],[
'state_id' => 1680,
'name' => 'Sohna'
],[
'state_id' => 1680,
'name' => 'Sonipat'
],[
'state_id' => 1680,
'name' => 'Thanesar'
],[
'state_id' => 1680,
'name' => 'Tohana'
],[
'state_id' => 1680,
'name' => 'Tosham'
],[
'state_id' => 1680,
'name' => 'Taoru'
],[
'state_id' => 1680,
'name' => 'Uklana'
],[
'state_id' => 1680,
'name' => 'Yamunanagar'
],[
'state_id' => 1680,
'name' => 'Asandh'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
