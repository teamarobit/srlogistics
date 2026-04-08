<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class INStateORCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1686,
'name' => 'Angul'
],[
'state_id' => 1686,
'name' => 'Angul District'
],[
'state_id' => 1686,
'name' => 'Bada Barabil'
],[
'state_id' => 1686,
'name' => 'Balasore'
],[
'state_id' => 1686,
'name' => 'Balimila'
],[
'state_id' => 1686,
'name' => 'Balangir'
],[
'state_id' => 1686,
'name' => 'Baragarh'
],[
'state_id' => 1686,
'name' => 'Barbil'
],[
'state_id' => 1686,
'name' => 'Bargarh'
],[
'state_id' => 1686,
'name' => 'Barpali'
],[
'state_id' => 1686,
'name' => 'Baud'
],[
'state_id' => 1686,
'name' => 'Baudh'
],[
'state_id' => 1686,
'name' => 'Belaguntha'
],[
'state_id' => 1686,
'name' => 'Bhadrak'
],[
'state_id' => 1686,
'name' => 'Bhadrakh'
],[
'state_id' => 1686,
'name' => 'Bhanjanagar'
],[
'state_id' => 1686,
'name' => 'Bhawanipatna'
],[
'state_id' => 1686,
'name' => 'Bhuban'
],[
'state_id' => 1686,
'name' => 'Bhubaneswar'
],[
'state_id' => 1686,
'name' => 'Binka'
],[
'state_id' => 1686,
'name' => 'Birmitrapur'
],[
'state_id' => 1686,
'name' => 'Bolanikhodan'
],[
'state_id' => 1686,
'name' => 'Brahmapur'
],[
'state_id' => 1686,
'name' => 'Brajarajnagar'
],[
'state_id' => 1686,
'name' => 'Buguda'
],[
'state_id' => 1686,
'name' => 'Burla'
],[
'state_id' => 1686,
'name' => 'Baleshwar'
],[
'state_id' => 1686,
'name' => 'Balugaon'
],[
'state_id' => 1686,
'name' => 'Banapur'
],[
'state_id' => 1686,
'name' => 'Banki'
],[
'state_id' => 1686,
'name' => 'Banposh'
],[
'state_id' => 1686,
'name' => 'Basudebpur'
],[
'state_id' => 1686,
'name' => 'Chatrapur'
],[
'state_id' => 1686,
'name' => 'Chikitigarh'
],[
'state_id' => 1686,
'name' => 'Chittarkonda'
],[
'state_id' => 1686,
'name' => 'Champua'
],[
'state_id' => 1686,
'name' => 'Chandbali'
],[
'state_id' => 1686,
'name' => 'Cuttack'
],[
'state_id' => 1686,
'name' => 'Daitari'
],[
'state_id' => 1686,
'name' => 'Deogarh'
],[
'state_id' => 1686,
'name' => 'Dhenkanal'
],[
'state_id' => 1686,
'name' => 'Digapahandi'
],[
'state_id' => 1686,
'name' => 'Gajapati'
],[
'state_id' => 1686,
'name' => 'Ganjam'
],[
'state_id' => 1686,
'name' => 'Gopalpur'
],[
'state_id' => 1686,
'name' => 'Gudari'
],[
'state_id' => 1686,
'name' => 'Gunupur'
],[
'state_id' => 1686,
'name' => 'Hinjilikatu'
],[
'state_id' => 1686,
'name' => 'Hirakud'
],[
'state_id' => 1686,
'name' => 'Jagatsinghpur'
],[
'state_id' => 1686,
'name' => 'Jajpur'
],[
'state_id' => 1686,
'name' => 'Jaleshwar'
],[
'state_id' => 1686,
'name' => 'Jatani'
],[
'state_id' => 1686,
'name' => 'Jeypore'
],[
'state_id' => 1686,
'name' => 'Jharsuguda'
],[
'state_id' => 1686,
'name' => 'Jharsuguda District'
],[
'state_id' => 1686,
'name' => 'Kaintragarh'
],[
'state_id' => 1686,
'name' => 'Kandhamal'
],[
'state_id' => 1686,
'name' => 'Kantilo'
],[
'state_id' => 1686,
'name' => 'Kantabanji'
],[
'state_id' => 1686,
'name' => 'Kendrapara'
],[
'state_id' => 1686,
'name' => 'Kendujhar'
],[
'state_id' => 1686,
'name' => 'Kesinga'
],[
'state_id' => 1686,
'name' => 'Khallikot'
],[
'state_id' => 1686,
'name' => 'Kharhial'
],[
'state_id' => 1686,
'name' => 'Khordha'
],[
'state_id' => 1686,
'name' => 'Khurda'
],[
'state_id' => 1686,
'name' => 'Kiri Buru'
],[
'state_id' => 1686,
'name' => 'Kodala'
],[
'state_id' => 1686,
'name' => 'Konarka'
],[
'state_id' => 1686,
'name' => 'Koraput'
],[
'state_id' => 1686,
'name' => 'Kuchaiburi'
],[
'state_id' => 1686,
'name' => 'Kuchinda'
],[
'state_id' => 1686,
'name' => 'Kalahandi'
],[
'state_id' => 1686,
'name' => 'Kamakhyanagar'
],[
'state_id' => 1686,
'name' => 'Malkangiri'
],[
'state_id' => 1686,
'name' => 'Mayurbhanj'
],[
'state_id' => 1686,
'name' => 'Nabarangpur'
],[
'state_id' => 1686,
'name' => 'Nayagarh District'
],[
'state_id' => 1686,
'name' => 'Nayagarh'
],[
'state_id' => 1686,
'name' => 'Nimaparha'
],[
'state_id' => 1686,
'name' => 'Nowrangapur'
],[
'state_id' => 1686,
'name' => 'Nuapada'
],[
'state_id' => 1686,
'name' => 'Nilgiri'
],[
'state_id' => 1686,
'name' => 'Padampur'
],[
'state_id' => 1686,
'name' => 'Paradip Garh'
],[
'state_id' => 1686,
'name' => 'Patnagarh'
],[
'state_id' => 1686,
'name' => 'Patamundai'
],[
'state_id' => 1686,
'name' => 'Phulbani'
],[
'state_id' => 1686,
'name' => 'Pipili'
],[
'state_id' => 1686,
'name' => 'Polasara'
],[
'state_id' => 1686,
'name' => 'Puri'
],[
'state_id' => 1686,
'name' => 'Purushottampur'
],[
'state_id' => 1686,
'name' => 'Rambha'
],[
'state_id' => 1686,
'name' => 'Raurkela'
],[
'state_id' => 1686,
'name' => 'Rayagada'
],[
'state_id' => 1686,
'name' => 'Remuna'
],[
'state_id' => 1686,
'name' => 'Rengali'
],[
'state_id' => 1686,
'name' => 'Sambalpur'
],[
'state_id' => 1686,
'name' => 'Sonepur'
],[
'state_id' => 1686,
'name' => 'Sorada'
],[
'state_id' => 1686,
'name' => 'Soro'
],[
'state_id' => 1686,
'name' => 'Subarnapur'
],[
'state_id' => 1686,
'name' => 'Sundargarh'
],[
'state_id' => 1686,
'name' => 'Tarabha'
],[
'state_id' => 1686,
'name' => 'Titlagarh'
],[
'state_id' => 1686,
'name' => 'Talcher'
],[
'state_id' => 1686,
'name' => 'Udayagiri'
],[
'state_id' => 1686,
'name' => 'Asika'
],[
'state_id' => 1686,
'name' => 'Athagarh'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
