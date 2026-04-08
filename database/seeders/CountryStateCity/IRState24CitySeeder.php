<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IRState24CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1767,
'name' => 'Ardabil'
],[
'state_id' => 1767,
'name' => 'Bileh Savar'
],[
'state_id' => 1767,
'name' => 'Omidcheh'
],[
'state_id' => 1767,
'name' => 'Parsabad'
],[
'state_id' => 1767,
'name' => 'Germi'
],[
'state_id' => 1767,
'name' => 'Khalkhal'
],[
'state_id' => 1767,
'name' => 'Kowsar'
],[
'state_id' => 1767,
'name' => 'Meshgin Shahr'
],[
'state_id' => 1767,
'name' => 'Namin'
],[
'state_id' => 1767,
'name' => 'Nir'
],[
'state_id' => 1767,
'name' => 'Sareyn'
],[
'state_id' => 1767,
'name' => 'Hir'
],[
'state_id' => 1767,
'name' => 'Jafarabad'
],[
'state_id' => 1767,
'name' => 'Eslāmābād'
],[
'state_id' => 1767,
'name' => 'Aslan Duz'
],[
'state_id' => 1767,
'name' => 'Tazakand'
],[
'state_id' => 1767,
'name' => 'Kolor'
],[
'state_id' => 1767,
'name' => 'Hashjin'
],[
'state_id' => 1767,
'name' => 'Sarein'
],[
'state_id' => 1767,
'name' => 'Kivi'
],[
'state_id' => 1767,
'name' => 'Razi'
],[
'state_id' => 1767,
'name' => 'Fakhrabad'
],[
'state_id' => 1767,
'name' => 'Qasabeh'
],[
'state_id' => 1767,
'name' => 'Lahroud'
],[
'state_id' => 1767,
'name' => 'Moradlu'
],[
'state_id' => 1767,
'name' => 'Abibeiglou'
],[
'state_id' => 1767,
'name' => 'Anbaran'
],[
'state_id' => 1767,
'name' => 'Kuraim'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
