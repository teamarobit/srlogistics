<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BDState13CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 366,
'name' => 'Azimpur'
],[
'state_id' => 366,
'name' => 'Bhairab Bāzār'
],[
'state_id' => 366,
'name' => 'Bājitpur'
],[
'state_id' => 366,
'name' => 'Char Bhadrāsan'
],[
'state_id' => 366,
'name' => 'Char Golora'
],[
'state_id' => 366,
'name' => 'Dhaka'
],[
'state_id' => 366,
'name' => 'Dohār'
],[
'state_id' => 366,
'name' => 'Faridpur'
],[
'state_id' => 366,
'name' => 'Gazipur'
],[
'state_id' => 366,
'name' => 'Gopalganj'
],[
'state_id' => 366,
'name' => 'Joymontop'
],[
'state_id' => 366,
'name' => 'Khanbaniara'
],[
'state_id' => 366,
'name' => 'Kishoregonj'
],[
'state_id' => 366,
'name' => 'Kishorganj'
],[
'state_id' => 366,
'name' => 'Madaripur'
],[
'state_id' => 366,
'name' => 'Manikganj'
],[
'state_id' => 366,
'name' => 'Mirzāpur'
],[
'state_id' => 366,
'name' => 'Munshiganj'
],[
'state_id' => 366,
'name' => 'Narayanganj'
],[
'state_id' => 366,
'name' => 'Narsingdi'
],[
'state_id' => 366,
'name' => 'Nāgarpur'
],[
'state_id' => 366,
'name' => 'Paltan'
],[
'state_id' => 366,
'name' => 'Parvez Ali'
],[
'state_id' => 366,
'name' => 'Parvez Ali Hossain'
],[
'state_id' => 366,
'name' => 'Pālang'
],[
'state_id' => 366,
'name' => 'Rajbari'
],[
'state_id' => 366,
'name' => 'Ramnagar'
],[
'state_id' => 366,
'name' => 'Sakhipur'
],[
'state_id' => 366,
'name' => 'Sayani'
],[
'state_id' => 366,
'name' => 'Shariatpur'
],[
'state_id' => 366,
'name' => 'Sonārgaon'
],[
'state_id' => 366,
'name' => 'Tangail'
],[
'state_id' => 366,
'name' => 'Tungi'
],[
'state_id' => 366,
'name' => 'Tungipāra'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
