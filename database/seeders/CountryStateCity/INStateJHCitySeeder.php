<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class INStateJHCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1698,
'name' => 'Bagra'
],[
'state_id' => 1698,
'name' => 'Barki Saria'
],[
'state_id' => 1698,
'name' => 'Barka Kana'
],[
'state_id' => 1698,
'name' => 'Barwadih'
],[
'state_id' => 1698,
'name' => 'Bhojudih'
],[
'state_id' => 1698,
'name' => 'Bokaro'
],[
'state_id' => 1698,
'name' => 'Bundu'
],[
'state_id' => 1698,
'name' => 'Chakradharpur'
],[
'state_id' => 1698,
'name' => 'Chatra'
],[
'state_id' => 1698,
'name' => 'Chiria'
],[
'state_id' => 1698,
'name' => 'Chakulia'
],[
'state_id' => 1698,
'name' => 'Chandil'
],[
'state_id' => 1698,
'name' => 'Chas'
],[
'state_id' => 1698,
'name' => 'Chaibasa'
],[
'state_id' => 1698,
'name' => 'Daltonganj'
],[
'state_id' => 1698,
'name' => 'Deogarh'
],[
'state_id' => 1698,
'name' => 'Dhanbad'
],[
'state_id' => 1698,
'name' => 'Dhanwar'
],[
'state_id' => 1698,
'name' => 'Dugda'
],[
'state_id' => 1698,
'name' => 'Dumka'
],[
'state_id' => 1698,
'name' => 'Garhwa'
],[
'state_id' => 1698,
'name' => 'Ghatsila'
],[
'state_id' => 1698,
'name' => 'Giridih'
],[
'state_id' => 1698,
'name' => 'Gobindpur'
],[
'state_id' => 1698,
'name' => 'Godda'
],[
'state_id' => 1698,
'name' => 'Gomoh'
],[
'state_id' => 1698,
'name' => 'Gopinathpur'
],[
'state_id' => 1698,
'name' => 'Gua'
],[
'state_id' => 1698,
'name' => 'Gumia'
],[
'state_id' => 1698,
'name' => 'Gumla'
],[
'state_id' => 1698,
'name' => 'Hazaribagh'
],[
'state_id' => 1698,
'name' => 'Hazaribag'
],[
'state_id' => 1698,
'name' => 'Hesla'
],[
'state_id' => 1698,
'name' => 'Husainabad'
],[
'state_id' => 1698,
'name' => 'Jagannathpur'
],[
'state_id' => 1698,
'name' => 'Jamshedpur'
],[
'state_id' => 1698,
'name' => 'Jamtara'
],[
'state_id' => 1698,
'name' => 'Jasidih'
],[
'state_id' => 1698,
'name' => 'Jharia'
],[
'state_id' => 1698,
'name' => 'Jugsalai'
],[
'state_id' => 1698,
'name' => 'Jumri Tilaiya'
],[
'state_id' => 1698,
'name' => 'Jamadoba'
],[
'state_id' => 1698,
'name' => 'Kenduadih'
],[
'state_id' => 1698,
'name' => 'Kharsawan'
],[
'state_id' => 1698,
'name' => 'Khunti'
],[
'state_id' => 1698,
'name' => 'Kodarma'
],[
'state_id' => 1698,
'name' => 'Kuju'
],[
'state_id' => 1698,
'name' => 'Kalikapur'
],[
'state_id' => 1698,
'name' => 'Kandra'
],[
'state_id' => 1698,
'name' => 'Kanke'
],[
'state_id' => 1698,
'name' => 'Katras'
],[
'state_id' => 1698,
'name' => 'Latehar'
],[
'state_id' => 1698,
'name' => 'Lohardaga'
],[
'state_id' => 1698,
'name' => 'Madhupur'
],[
'state_id' => 1698,
'name' => 'Malkera'
],[
'state_id' => 1698,
'name' => 'Manoharpur'
],[
'state_id' => 1698,
'name' => 'Mugma'
],[
'state_id' => 1698,
'name' => 'Mushabani'
],[
'state_id' => 1698,
'name' => 'Neturhat'
],[
'state_id' => 1698,
'name' => 'Nirsa'
],[
'state_id' => 1698,
'name' => 'Noamundi'
],[
'state_id' => 1698,
'name' => 'Pakur'
],[
'state_id' => 1698,
'name' => 'Palamu'
],[
'state_id' => 1698,
'name' => 'Pashchim Singhbhum'
],[
'state_id' => 1698,
'name' => 'Purba Singhbhum'
],[
'state_id' => 1698,
'name' => 'Pathardih'
],[
'state_id' => 1698,
'name' => 'Ramgarh'
],[
'state_id' => 1698,
'name' => 'Ranchi'
],[
'state_id' => 1698,
'name' => 'Ray'
],[
'state_id' => 1698,
'name' => 'Sahibganj'
],[
'state_id' => 1698,
'name' => 'Saraikela'
],[
'state_id' => 1698,
'name' => 'Sijua'
],[
'state_id' => 1698,
'name' => 'Simdega'
],[
'state_id' => 1698,
'name' => 'Sini'
],[
'state_id' => 1698,
'name' => 'Sarubera'
],[
'state_id' => 1698,
'name' => 'Topchanchi'
],[
'state_id' => 1698,
'name' => 'patamda'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
