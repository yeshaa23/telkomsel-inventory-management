<?php

namespace App\Exports;

use App\Models\BorrowingDetail;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class BorrowingsExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public function collection(): Collection
    {
        return BorrowingDetail::with(['borrowing', 'product'])
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama Peminjam',
            'Kode Barang',
            'Nama Barang',
            'Jumlah',
            'Tanggal Pinjam',
            'Tanggal Jatuh Tempo',
            'Tanggal Kembali',
            'Status',
            'Kondisi Saat Kembali',
            'Catatan Pengembalian',
        ];
    }

    public function map($detail): array
    {
        return [
            $detail->borrowing->borrower_name ?? '-',
            $detail->product->code ?? '-',
            $detail->product->name ?? '-',
            $detail->quantity,
            optional($detail->borrowing->borrow_date)->format('Y-m-d') ?? '-',
            optional($detail->borrowing->due_date)->format('Y-m-d') ?? '-',
            optional($detail->borrowing->return_date)->format('Y-m-d') ?? '-',
            $detail->borrowing->display_status_label ?? '-',
            $detail->borrowing->return_condition ?? '-',
            $detail->borrowing->return_note ?? '-',
        ];
    }

    public function title(): string
    {
        return 'Laporan Peminjaman';
    }
}
