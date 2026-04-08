<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateSSCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1737,
'name' => 'Baturaja'
],[
'state_id' => 1737,
'name' => 'Kabupaten Empat Lawang'
],[
'state_id' => 1737,
'name' => 'Kabupaten Muara Enim'
],[
'state_id' => 1737,
'name' => 'Kabupaten Musi Banyuasin'
],[
'state_id' => 1737,
'name' => 'Kabupaten Musi Rawas'
],[
'state_id' => 1737,
'name' => 'Kabupaten Musi Rawas Utara'
],[
'state_id' => 1737,
'name' => 'Kabupaten Ogan Ilir'
],[
'state_id' => 1737,
'name' => 'Kabupaten Ogan Komering Ilir'
],[
'state_id' => 1737,
'name' => 'Kabupaten Ogan Komering Ulu'
],[
'state_id' => 1737,
'name' => 'Kabupaten Ogan Komering Ulu Selatan'
],[
'state_id' => 1737,
'name' => 'Kabupaten Ogan Komering Ulu Timur'
],[
'state_id' => 1737,
'name' => 'Kabupaten Penukal Abab Lematang Ilir'
],[
'state_id' => 1737,
'name' => 'Kota Lubuklinggau'
],[
'state_id' => 1737,
'name' => 'Kota Pagar Alam'
],[
'state_id' => 1737,
'name' => 'Kota Palembang'
],[
'state_id' => 1737,
'name' => 'Kota Prabumulih'
],[
'state_id' => 1737,
'name' => 'Lahat'
],[
'state_id' => 1737,
'name' => 'Lahat Regency'
],[
'state_id' => 1737,
'name' => 'Lubuklinggau'
],[
'state_id' => 1737,
'name' => 'Pagar Alam'
],[
'state_id' => 1737,
'name' => 'Palembang'
],[
'state_id' => 1737,
'name' => 'Prabumulih'
],[
'state_id' => 1737,
'name' => 'Tanjungagung'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
