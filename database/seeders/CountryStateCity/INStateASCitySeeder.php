<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class INStateASCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1700,
'name' => 'Abhayapuri'
],[
'state_id' => 1700,
'name' => 'Amguri'
],[
'state_id' => 1700,
'name' => 'Badarpur'
],[
'state_id' => 1700,
'name' => 'Baksa'
],[
'state_id' => 1700,
'name' => 'Barpathar'
],[
'state_id' => 1700,
'name' => 'Barpeta'
],[
'state_id' => 1700,
'name' => 'Barpeta Road'
],[
'state_id' => 1700,
'name' => 'Bihpuriagaon'
],[
'state_id' => 1700,
'name' => 'Bijni'
],[
'state_id' => 1700,
'name' => 'Bilasipara'
],[
'state_id' => 1700,
'name' => 'Bokajan'
],[
'state_id' => 1700,
'name' => 'Bokakhat'
],[
'state_id' => 1700,
'name' => 'Bongaigaon'
],[
'state_id' => 1700,
'name' => 'Basugaon'
],[
'state_id' => 1700,
'name' => 'Chirang'
],[
'state_id' => 1700,
'name' => 'Chabua'
],[
'state_id' => 1700,
'name' => 'Chapar'
],[
'state_id' => 1700,
'name' => 'Cachar'
],[
'state_id' => 1700,
'name' => 'Darrang'
],[
'state_id' => 1700,
'name' => 'Dergaon'
],[
'state_id' => 1700,
'name' => 'Dhekiajuli'
],[
'state_id' => 1700,
'name' => 'Dhemaji'
],[
'state_id' => 1700,
'name' => 'Dhing'
],[
'state_id' => 1700,
'name' => 'Dhubri'
],[
'state_id' => 1700,
'name' => 'Dibrugarh'
],[
'state_id' => 1700,
'name' => 'Digboi'
],[
'state_id' => 1700,
'name' => 'Dima Hasao District'
],[
'state_id' => 1700,
'name' => 'Diphu'
],[
'state_id' => 1700,
'name' => 'Dispur'
],[
'state_id' => 1700,
'name' => 'Duliagaon'
],[
'state_id' => 1700,
'name' => 'Dum Duma'
],[
'state_id' => 1700,
'name' => 'Gauripur'
],[
'state_id' => 1700,
'name' => 'Gohpur'
],[
'state_id' => 1700,
'name' => 'Golaghat'
],[
'state_id' => 1700,
'name' => 'Golakganj'
],[
'state_id' => 1700,
'name' => 'Goshaingaon'
],[
'state_id' => 1700,
'name' => 'Goalpara'
],[
'state_id' => 1700,
'name' => 'Guwahati'
],[
'state_id' => 1700,
'name' => 'Hailakandi'
],[
'state_id' => 1700,
'name' => 'Hojai'
],[
'state_id' => 1700,
'name' => 'Howli'
],[
'state_id' => 1700,
'name' => 'Haflong'
],[
'state_id' => 1700,
'name' => 'Hajo'
],[
'state_id' => 1700,
'name' => 'Jogighopa'
],[
'state_id' => 1700,
'name' => 'Jorhat'
],[
'state_id' => 1700,
'name' => 'Kamrup Metropolitan'
],[
'state_id' => 1700,
'name' => 'Karimganj'
],[
'state_id' => 1700,
'name' => 'Kharupatia'
],[
'state_id' => 1700,
'name' => 'Kokrajhar'
],[
'state_id' => 1700,
'name' => 'Kamrup'
],[
'state_id' => 1700,
'name' => 'Karbi Anglong'
],[
'state_id' => 1700,
'name' => 'Lakhimpur'
],[
'state_id' => 1700,
'name' => 'Lakhipur'
],[
'state_id' => 1700,
'name' => 'Lumding Railway Colony'
],[
'state_id' => 1700,
'name' => 'Lala'
],[
'state_id' => 1700,
'name' => 'Mahur'
],[
'state_id' => 1700,
'name' => 'Maibong'
],[
'state_id' => 1700,
'name' => 'Mangaldai'
],[
'state_id' => 1700,
'name' => 'Mariani'
],[
'state_id' => 1700,
'name' => 'Morigaon'
],[
'state_id' => 1700,
'name' => 'Moranha'
],[
'state_id' => 1700,
'name' => 'Makum'
],[
'state_id' => 1700,
'name' => 'Nagaon'
],[
'state_id' => 1700,
'name' => 'Nahorkatiya'
],[
'state_id' => 1700,
'name' => 'Nalbari'
],[
'state_id' => 1700,
'name' => 'North Guwahati'
],[
'state_id' => 1700,
'name' => 'North Lakhimpur'
],[
'state_id' => 1700,
'name' => 'Numaligarh'
],[
'state_id' => 1700,
'name' => 'Namrup'
],[
'state_id' => 1700,
'name' => 'Nazira'
],[
'state_id' => 1700,
'name' => 'Palasbari'
],[
'state_id' => 1700,
'name' => 'Raha'
],[
'state_id' => 1700,
'name' => 'Rangia'
],[
'state_id' => 1700,
'name' => 'Rangapara'
],[
'state_id' => 1700,
'name' => 'Sapatgram'
],[
'state_id' => 1700,
'name' => 'Sarupathar'
],[
'state_id' => 1700,
'name' => 'Sibsagar'
],[
'state_id' => 1700,
'name' => 'Silapathar'
],[
'state_id' => 1700,
'name' => 'Silchar'
],[
'state_id' => 1700,
'name' => 'Soalkuchi'
],[
'state_id' => 1700,
'name' => 'Sonitpur'
],[
'state_id' => 1700,
'name' => 'Sonari'
],[
'state_id' => 1700,
'name' => 'Sorbhog'
],[
'state_id' => 1700,
'name' => 'Tezpur'
],[
'state_id' => 1700,
'name' => 'Tinsukia'
],[
'state_id' => 1700,
'name' => 'Titabar'
],[
'state_id' => 1700,
'name' => 'Udalguri'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
