<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{
    public function collection()
    {
        return User::donors()
            ->select(
                'name',
                'email',
                'blood_group',
                'phone',
                'city',
                'address',
                'available'
            )
            ->get();
    }

    public function map($user): array
    {
        return [
            $user->name,
            $user->email,
            $user->blood_group,
            $user->phone,
            $user->city,
            $user->address,
            ucfirst($user->available ?? '-'),
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Blood Group',
            'Phone Number',
            'City',
            'Address',
            'Availability',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => 'F8FAFC',
                    ],
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:G1')
                    ->getFont()
                    ->setBold(true);

                $event->sheet->getDelegate()->getStyle('A1:G1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('F8FAFC');
            },
        ];
    }
}