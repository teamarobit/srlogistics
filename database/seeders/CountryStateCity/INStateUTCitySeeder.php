<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class INStateUTCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1689,
'name' => 'Almora'
],[
'state_id' => 1689,
'name' => 'Bageshwar'
],[
'state_id' => 1689,
'name' => 'Barkot'
],[
'state_id' => 1689,
'name' => 'Bhowali'
],[
'state_id' => 1689,
'name' => 'Bhim Tal'
],[
'state_id' => 1689,
'name' => 'Birbhaddar'
],[
'state_id' => 1689,
'name' => 'Bazpur'
],[
'state_id' => 1689,
'name' => 'Chakrata'
],[
'state_id' => 1689,
'name' => 'Chamoli'
],[
'state_id' => 1689,
'name' => 'Champawat'
],[
'state_id' => 1689,
'name' => 'Clement Town'
],[
'state_id' => 1689,
'name' => 'Dehradun'
],[
'state_id' => 1689,
'name' => 'Devaprayag'
],[
'state_id' => 1689,
'name' => 'Dharchula'
],[
'state_id' => 1689,
'name' => 'Doiwala'
],[
'state_id' => 1689,
'name' => 'Dugadda'
],[
'state_id' => 1689,
'name' => 'Dwarahat'
],[
'state_id' => 1689,
'name' => 'Garhwal'
],[
'state_id' => 1689,
'name' => 'Haldwani'
],[
'state_id' => 1689,
'name' => 'Harbatpur'
],[
'state_id' => 1689,
'name' => 'Haridwar'
],[
'state_id' => 1689,
'name' => 'Jaspur'
],[
'state_id' => 1689,
'name' => 'Joshimath'
],[
'state_id' => 1689,
'name' => 'Kashipur'
],[
'state_id' => 1689,
'name' => 'Khatima'
],[
'state_id' => 1689,
'name' => 'Kichha'
],[
'state_id' => 1689,
'name' => 'Kotdwara'
],[
'state_id' => 1689,
'name' => 'Kaladhungi'
],[
'state_id' => 1689,
'name' => 'Kalagarh Project Colony'
],[
'state_id' => 1689,
'name' => 'Laksar'
],[
'state_id' => 1689,
'name' => 'Lansdowne'
],[
'state_id' => 1689,
'name' => 'Lohaghat'
],[
'state_id' => 1689,
'name' => 'Manglaur'
],[
'state_id' => 1689,
'name' => 'Mussoorie'
],[
'state_id' => 1689,
'name' => 'Naini Tal'
],[
'state_id' => 1689,
'name' => 'Narendranagar'
],[
'state_id' => 1689,
'name' => 'Pauri'
],[
'state_id' => 1689,
'name' => 'Pithoragarh'
],[
'state_id' => 1689,
'name' => 'Pipalkoti'
],[
'state_id' => 1689,
'name' => 'Rishikesh'
],[
'state_id' => 1689,
'name' => 'Roorkee'
],[
'state_id' => 1689,
'name' => 'Rudraprayag'
],[
'state_id' => 1689,
'name' => 'Raipur'
],[
'state_id' => 1689,
'name' => 'Ramnagar'
],[
'state_id' => 1689,
'name' => 'Ranikhet'
],[
'state_id' => 1689,
'name' => 'Raiwala Bara'
],[
'state_id' => 1689,
'name' => 'Sitarganj'
],[
'state_id' => 1689,
'name' => 'Srinagar'
],[
'state_id' => 1689,
'name' => 'Sultanpur'
],[
'state_id' => 1689,
'name' => 'Tanakpur'
],[
'state_id' => 1689,
'name' => 'Tehri'
],[
'state_id' => 1689,
'name' => 'Tehri-Garhwal'
],[
'state_id' => 1689,
'name' => 'Udham Singh Nagar'
],[
'state_id' => 1689,
'name' => 'Uttarkashi'
],[
'state_id' => 1689,
'name' => 'Vikasnagar'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
