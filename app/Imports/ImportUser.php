<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ImportUser implements FromCollection,WithHeadings
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function headings():array{
//        $header = DB::table('header')->select(
//            DB::raw("(GROUP_CONCAT(header.name)) as `name`"))
//            ->get();
//
//        return[
//            $header[0]->name
//        ];
        $attributes = array_keys($this->collection()->first()->getAttributes());
        return $attributes;
    }

    public function collection()
    {
        return User::select('id','name','email','phone_number AS phone')->get();
    }
//    public function model(array $row)
//    {
//        return new User([
//            //
//        ]);
//    }
}
