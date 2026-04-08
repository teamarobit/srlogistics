<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateACCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1742,
'name' => 'Banda Aceh'
],[
'state_id' => 1742,
'name' => 'Bireun'
],[
'state_id' => 1742,
'name' => 'Kabupaten Aceh Barat'
],[
'state_id' => 1742,
'name' => 'Kabupaten Aceh Barat Daya'
],[
'state_id' => 1742,
'name' => 'Kabupaten Aceh Besar'
],[
'state_id' => 1742,
'name' => 'Kabupaten Aceh Jaya'
],[
'state_id' => 1742,
'name' => 'Kabupaten Aceh Selatan'
],[
'state_id' => 1742,
'name' => 'Kabupaten Aceh Singkil'
],[
'state_id' => 1742,
'name' => 'Kabupaten Aceh Tamiang'
],[
'state_id' => 1742,
'name' => 'Kabupaten Aceh Tengah'
],[
'state_id' => 1742,
'name' => 'Kabupaten Aceh Tenggara'
],[
'state_id' => 1742,
'name' => 'Kabupaten Aceh Timur'
],[
'state_id' => 1742,
'name' => 'Kabupaten Aceh Utara'
],[
'state_id' => 1742,
'name' => 'Kabupaten Bener Meriah'
],[
'state_id' => 1742,
'name' => 'Kabupaten Bireuen'
],[
'state_id' => 1742,
'name' => 'Kabupaten Gayo Lues'
],[
'state_id' => 1742,
'name' => 'Kabupaten Nagan Raya'
],[
'state_id' => 1742,
'name' => 'Kabupaten Pidie'
],[
'state_id' => 1742,
'name' => 'Kabupaten Simeulue'
],[
'state_id' => 1742,
'name' => 'Kota Banda Aceh'
],[
'state_id' => 1742,
'name' => 'Kota Langsa'
],[
'state_id' => 1742,
'name' => 'Kota Lhokseumawe'
],[
'state_id' => 1742,
'name' => 'Kota Sabang'
],[
'state_id' => 1742,
'name' => 'Kota Subulussalam'
],[
'state_id' => 1742,
'name' => 'Langsa'
],[
'state_id' => 1742,
'name' => 'Lhokseumawe'
],[
'state_id' => 1742,
'name' => 'Meulaboh'
],[
'state_id' => 1742,
'name' => 'Reuleuet'
],[
'state_id' => 1742,
'name' => 'Sabang'
],[
'state_id' => 1742,
'name' => 'Sigli'
],[
'state_id' => 1742,
'name' => 'Sinabang'
],[
'state_id' => 1742,
'name' => 'Singkil'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
