<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IRState27CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1766,
'name' => 'Gonbad Kavus'
],[
'state_id' => 1766,
'name' => 'Gorgan'
],[
'state_id' => 1766,
'name' => 'Kalaleh'
],[
'state_id' => 1766,
'name' => 'Qarnabad'
],[
'state_id' => 1766,
'name' => 'Gomishan'
],[
'state_id' => 1766,
'name' => 'Galikesh'
],[
'state_id' => 1766,
'name' => 'Kordkuy'
],[
'state_id' => 1766,
'name' => 'Maraveh Tappeh'
],[
'state_id' => 1766,
'name' => 'Minudasht'
],[
'state_id' => 1766,
'name' => 'Ramian'
],[
'state_id' => 1766,
'name' => 'Aq Qala'
],[
'state_id' => 1766,
'name' => 'Torkaman'
],[
'state_id' => 1766,
'name' => 'Aq Qayeh'
],[
'state_id' => 1766,
'name' => 'Azadshahr'
],[
'state_id' => 1766,
'name' => 'Neginshahr'
],[
'state_id' => 1766,
'name' => 'Nowdeh Khanduz'
],[
'state_id' => 1766,
'name' => 'Anbar Olum'
],[
'state_id' => 1766,
'name' => 'Bandar-e Gaz'
],[
'state_id' => 1766,
'name' => 'Nowkandeh'
],[
'state_id' => 1766,
'name' => 'Bandar Torkaman'
],[
'state_id' => 1766,
'name' => 'Tatar Olia'
],[
'state_id' => 1766,
'name' => 'Khānbebin'
],[
'state_id' => 1766,
'name' => 'Daland'
],[
'state_id' => 1766,
'name' => 'Sangdevin'
],[
'state_id' => 1766,
'name' => 'Aliabad-e-Katul'
],[
'state_id' => 1766,
'name' => 'Fazelabad'
],[
'state_id' => 1766,
'name' => 'Mazraeh'
],[
'state_id' => 1766,
'name' => 'Faraqi'
],[
'state_id' => 1766,
'name' => 'Jelin'
],[
'state_id' => 1766,
'name' => 'Sarkhon Kalateh'
],[
'state_id' => 1766,
'name' => 'Siminshahr'
],[
'state_id' => 1766,
'name' => 'Gomish Tepe'
],[
'state_id' => 1766,
'name' => 'Incheboron'
],[
'state_id' => 1766,
'name' => 'Maraveh'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
