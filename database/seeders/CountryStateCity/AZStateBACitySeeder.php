<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateBACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 257,
'name' => 'Amirdzhan'
],[
'state_id' => 257,
'name' => 'Badamdar'
],[
'state_id' => 257,
'name' => 'Baku'
],[
'state_id' => 257,
'name' => 'Bakıxanov'
],[
'state_id' => 257,
'name' => 'Balakhani'
],[
'state_id' => 257,
'name' => 'Bilajari'
],[
'state_id' => 257,
'name' => 'Bilajer'
],[
'state_id' => 257,
'name' => 'Binagadi'
],[
'state_id' => 257,
'name' => 'Biny Selo'
],[
'state_id' => 257,
'name' => 'Buzovna'
],[
'state_id' => 257,
'name' => 'Hövsan'
],[
'state_id' => 257,
'name' => 'Khodzhi-Gasan'
],[
'state_id' => 257,
'name' => 'Korgöz'
],[
'state_id' => 257,
'name' => 'Lökbatan'
],[
'state_id' => 257,
'name' => 'Mardakan'
],[
'state_id' => 257,
'name' => 'Maştağa'
],[
'state_id' => 257,
'name' => 'Nardaran'
],[
'state_id' => 257,
'name' => 'Nizami Rayonu'
],[
'state_id' => 257,
'name' => 'Pirallahı'
],[
'state_id' => 257,
'name' => 'Puta'
],[
'state_id' => 257,
'name' => 'Qala'
],[
'state_id' => 257,
'name' => 'Qaraçuxur'
],[
'state_id' => 257,
'name' => 'Qobustan'
],[
'state_id' => 257,
'name' => 'Ramana'
],[
'state_id' => 257,
'name' => 'Sabunçu'
],[
'state_id' => 257,
'name' => 'Sanqaçal'
],[
'state_id' => 257,
'name' => 'Türkan'
],[
'state_id' => 257,
'name' => 'Yeni Suraxanı'
],[
'state_id' => 257,
'name' => 'Zabrat'
],[
'state_id' => 257,
'name' => 'Zyrya'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
