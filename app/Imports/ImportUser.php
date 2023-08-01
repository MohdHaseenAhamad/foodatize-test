<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class ImportUser implements FromCollection, WithHeadings, WithEvents {
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function headings(): array {
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

    public function collection() {
        return User::select('id', 'name', 'email', 'phone_number AS phone')->get();
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:I1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'color' => [
                        'rgb' => '808080'
                    ],
                ]);

            },
        ];
    }
//    public function model(array $row)
//    {
//        return new User([
//            //
//        ]);
//    }
}
