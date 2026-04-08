<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CMStateCECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 687,
'name' => 'Akono'
],[
'state_id' => 687,
'name' => 'Akonolinga'
],[
'state_id' => 687,
'name' => 'Bafia'
],[
'state_id' => 687,
'name' => 'Essé'
],[
'state_id' => 687,
'name' => 'Eséka'
],[
'state_id' => 687,
'name' => 'Mbalmayo'
],[
'state_id' => 687,
'name' => 'Mbam-Et-Inoubou'
],[
'state_id' => 687,
'name' => 'Mbandjok'
],[
'state_id' => 687,
'name' => 'Mbankomo'
],[
'state_id' => 687,
'name' => 'Mefou-et-Akono'
],[
'state_id' => 687,
'name' => 'Mfoundi'
],[
'state_id' => 687,
'name' => 'Minta'
],[
'state_id' => 687,
'name' => 'Nanga Eboko'
],[
'state_id' => 687,
'name' => 'Ndikiniméki'
],[
'state_id' => 687,
'name' => 'Ngomedzap'
],[
'state_id' => 687,
'name' => 'Ngoro'
],[
'state_id' => 687,
'name' => 'Nkoteng'
],[
'state_id' => 687,
'name' => 'Ntui'
],[
'state_id' => 687,
'name' => 'Obala'
],[
'state_id' => 687,
'name' => 'Okoa'
],[
'state_id' => 687,
'name' => 'Okola'
],[
'state_id' => 687,
'name' => 'Ombésa'
],[
'state_id' => 687,
'name' => 'Saa'
],[
'state_id' => 687,
'name' => 'Yaoundé'
],[
'state_id' => 687,
'name' => 'Yoko'
],[
'state_id' => 687,
'name' => 'Évodoula'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
