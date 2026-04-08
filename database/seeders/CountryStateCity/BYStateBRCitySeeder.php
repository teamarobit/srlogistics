<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BYStateBRCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 431,
'name' => 'Antopal’'
],[
'state_id' => 431,
'name' => 'Asnyezhytsy'
],[
'state_id' => 431,
'name' => 'Baranovichi'
],[
'state_id' => 431,
'name' => 'Baranovichskiy Rayon'
],[
'state_id' => 431,
'name' => 'Brest'
],[
'state_id' => 431,
'name' => 'Brestski Rayon'
],[
'state_id' => 431,
'name' => 'Byaroza'
],[
'state_id' => 431,
'name' => 'Byarozawski Rayon'
],[
'state_id' => 431,
'name' => 'Byelaazyorsk'
],[
'state_id' => 431,
'name' => 'Charnawchytsy'
],[
'state_id' => 431,
'name' => 'Damachava'
],[
'state_id' => 431,
'name' => 'Davyd-Haradok'
],[
'state_id' => 431,
'name' => 'Drahichyn'
],[
'state_id' => 431,
'name' => 'Drahichynski Rayon'
],[
'state_id' => 431,
'name' => 'Hantsavichy'
],[
'state_id' => 431,
'name' => 'Hantsavitski Rayon'
],[
'state_id' => 431,
'name' => 'Haradzishcha'
],[
'state_id' => 431,
'name' => 'Horad Baranavichy'
],[
'state_id' => 431,
'name' => 'Horad Brest'
],[
'state_id' => 431,
'name' => 'Ivanava'
],[
'state_id' => 431,
'name' => 'Ivanawski Rayon'
],[
'state_id' => 431,
'name' => 'Ivatsevichy'
],[
'state_id' => 431,
'name' => 'Kamyanyets'
],[
'state_id' => 431,
'name' => 'Kamyanyetski Rayon'
],[
'state_id' => 431,
'name' => 'Kamyanyuki'
],[
'state_id' => 431,
'name' => 'Kobryn'
],[
'state_id' => 431,
'name' => 'Kosava'
],[
'state_id' => 431,
'name' => 'Lahishyn'
],[
'state_id' => 431,
'name' => 'Luninyets'
],[
'state_id' => 431,
'name' => 'Lyakhavichy'
],[
'state_id' => 431,
'name' => 'Malaryta'
],[
'state_id' => 431,
'name' => 'Mikashevichy'
],[
'state_id' => 431,
'name' => 'Motal’'
],[
'state_id' => 431,
'name' => 'Nyakhachava'
],[
'state_id' => 431,
'name' => 'Pinsk'
],[
'state_id' => 431,
'name' => 'Pruzhanski Rayon'
],[
'state_id' => 431,
'name' => 'Pruzhany'
],[
'state_id' => 431,
'name' => 'Ruzhany'
],[
'state_id' => 431,
'name' => 'Stolin'
],[
'state_id' => 431,
'name' => 'Stolinski Rayon'
],[
'state_id' => 431,
'name' => 'Tsyelyakhany'
],[
'state_id' => 431,
'name' => 'Vysokaye'
],[
'state_id' => 431,
'name' => 'Zhabinka'
],[
'state_id' => 431,
'name' => 'Zhabinkawski Rayon'
],[
'state_id' => 431,
'name' => 'Znamenka'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
