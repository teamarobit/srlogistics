<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CYState01CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 969,
'name' => 'Akáki'
],[
'state_id' => 969,
'name' => 'Alámpra'
],[
'state_id' => 969,
'name' => 'Aredioú'
],[
'state_id' => 969,
'name' => 'Astromerítis'
],[
'state_id' => 969,
'name' => 'Dáli'
],[
'state_id' => 969,
'name' => 'Ergátes'
],[
'state_id' => 969,
'name' => 'Géri'
],[
'state_id' => 969,
'name' => 'Kakopetriá'
],[
'state_id' => 969,
'name' => 'Klírou'
],[
'state_id' => 969,
'name' => 'Kokkinotrimithiá'
],[
'state_id' => 969,
'name' => 'Káto Defterá'
],[
'state_id' => 969,
'name' => 'Káto Pýrgos'
],[
'state_id' => 969,
'name' => 'Lythrodóntas'
],[
'state_id' => 969,
'name' => 'Léfka'
],[
'state_id' => 969,
'name' => 'Lýmpia'
],[
'state_id' => 969,
'name' => 'Mámmari'
],[
'state_id' => 969,
'name' => 'Méniko'
],[
'state_id' => 969,
'name' => 'Mórfou'
],[
'state_id' => 969,
'name' => 'Nicosia'
],[
'state_id' => 969,
'name' => 'Nicosia Municipality'
],[
'state_id' => 969,
'name' => 'Peristeróna'
],[
'state_id' => 969,
'name' => 'Psimolofou'
],[
'state_id' => 969,
'name' => 'Páno Defterá'
],[
'state_id' => 969,
'name' => 'Péra'
],[
'state_id' => 969,
'name' => 'Tséri'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
