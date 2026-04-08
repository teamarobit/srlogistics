<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class KMStateGCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 854,
'name' => 'Bahani'
],[
'state_id' => 854,
'name' => 'Bambadjani'
],[
'state_id' => 854,
'name' => 'Bouni'
],[
'state_id' => 854,
'name' => 'Chezani'
],[
'state_id' => 854,
'name' => 'Chindini'
],[
'state_id' => 854,
'name' => 'Chouani'
],[
'state_id' => 854,
'name' => 'Dembéni'
],[
'state_id' => 854,
'name' => 'Douniani'
],[
'state_id' => 854,
'name' => 'Dzahadjou'
],[
'state_id' => 854,
'name' => 'Foumbouni'
],[
'state_id' => 854,
'name' => 'Hantsindzi'
],[
'state_id' => 854,
'name' => 'Héroumbili'
],[
'state_id' => 854,
'name' => 'Itsandra'
],[
'state_id' => 854,
'name' => 'Itsandzéni'
],[
'state_id' => 854,
'name' => 'Ivouani'
],[
'state_id' => 854,
'name' => 'Koua'
],[
'state_id' => 854,
'name' => 'Madjeouéni'
],[
'state_id' => 854,
'name' => 'Mandza'
],[
'state_id' => 854,
'name' => 'Mavingouni'
],[
'state_id' => 854,
'name' => 'Mbéni'
],[
'state_id' => 854,
'name' => 'Mitsamiouli'
],[
'state_id' => 854,
'name' => 'Mitsoudjé'
],[
'state_id' => 854,
'name' => 'Mnoungou'
],[
'state_id' => 854,
'name' => 'Mohoro'
],[
'state_id' => 854,
'name' => 'Moroni'
],[
'state_id' => 854,
'name' => 'Mtsamdou'
],[
'state_id' => 854,
'name' => 'Mvouni'
],[
'state_id' => 854,
'name' => 'Nioumamilima'
],[
'state_id' => 854,
'name' => 'Ntsaouéni'
],[
'state_id' => 854,
'name' => 'Ntsoudjini'
],[
'state_id' => 854,
'name' => 'Ouellah'
],[
'state_id' => 854,
'name' => 'Ouhozi'
],[
'state_id' => 854,
'name' => 'Ourovéni'
],[
'state_id' => 854,
'name' => 'Oussivo'
],[
'state_id' => 854,
'name' => 'Salimani'
],[
'state_id' => 854,
'name' => 'Singani'
],[
'state_id' => 854,
'name' => 'Séléa'
],[
'state_id' => 854,
'name' => 'Tsidjé'
],[
'state_id' => 854,
'name' => 'Vanadjou'
],[
'state_id' => 854,
'name' => 'Vanambouani'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
