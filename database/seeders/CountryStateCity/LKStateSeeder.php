<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class LKStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 208,
'name' => 'Jaffna District',
'iso2' => '41'
],[
'country_id' => 208,
'name' => 'Kandy District',
'iso2' => '21'
],[
'country_id' => 208,
'name' => 'Kalutara District',
'iso2' => '13'
],[
'country_id' => 208,
'name' => 'Badulla District',
'iso2' => '81'
],[
'country_id' => 208,
'name' => 'Hambantota District',
'iso2' => '33'
],[
'country_id' => 208,
'name' => 'Galle District',
'iso2' => '31'
],[
'country_id' => 208,
'name' => 'Kilinochchi District',
'iso2' => '42'
],[
'country_id' => 208,
'name' => 'Nuwara Eliya District',
'iso2' => '23'
],[
'country_id' => 208,
'name' => 'Trincomalee District',
'iso2' => '53'
],[
'country_id' => 208,
'name' => 'Puttalam District',
'iso2' => '62'
],[
'country_id' => 208,
'name' => 'Kegalle District',
'iso2' => '92'
],[
'country_id' => 208,
'name' => 'Central Province',
'iso2' => '2'
],[
'country_id' => 208,
'name' => 'Ampara District',
'iso2' => '52'
],[
'country_id' => 208,
'name' => 'North Central Province',
'iso2' => '7'
],[
'country_id' => 208,
'name' => 'Southern Province',
'iso2' => '3'
],[
'country_id' => 208,
'name' => 'Western Province',
'iso2' => '1'
],[
'country_id' => 208,
'name' => 'Sabaragamuwa Province',
'iso2' => '9'
],[
'country_id' => 208,
'name' => 'Gampaha District',
'iso2' => '12'
],[
'country_id' => 208,
'name' => 'Mannar District',
'iso2' => '43'
],[
'country_id' => 208,
'name' => 'Matara District',
'iso2' => '32'
],[
'country_id' => 208,
'name' => 'Ratnapura district',
'iso2' => '91'
],[
'country_id' => 208,
'name' => 'Eastern Province',
'iso2' => '5'
],[
'country_id' => 208,
'name' => 'Vavuniya District',
'iso2' => '44'
],[
'country_id' => 208,
'name' => 'Matale District',
'iso2' => '22'
],[
'country_id' => 208,
'name' => 'Uva Province',
'iso2' => '8'
],[
'country_id' => 208,
'name' => 'Polonnaruwa District',
'iso2' => '72'
],[
'country_id' => 208,
'name' => 'Northern Province',
'iso2' => '4'
],[
'country_id' => 208,
'name' => 'Mullaitivu District',
'iso2' => '45'
],[
'country_id' => 208,
'name' => 'Colombo District',
'iso2' => '11'
],[
'country_id' => 208,
'name' => 'Anuradhapura District',
'iso2' => '71'
],[
'country_id' => 208,
'name' => 'North Western Province',
'iso2' => '6'
],[
'country_id' => 208,
'name' => 'Batticaloa District',
'iso2' => '51'
],[
'country_id' => 208,
'name' => 'Monaragala District',
'iso2' => '82'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
