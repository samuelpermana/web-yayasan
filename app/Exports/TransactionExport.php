<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Transaction::with(['debitAccount', 'creditAccount']);

        // Apply filters
        if (!empty($this->filters['date_from'])) {
            $query->whereDate('transaction_date', '>=', $this->filters['date_from']);
        }

        if (!empty($this->filters['date_to'])) {
            $query->whereDate('transaction_date', '<=', $this->filters['date_to']);
        }

        if (!empty($this->filters['description'])) {
            $query->where('description', 'like', '%' . $this->filters['description'] . '%');
        }

        if (!empty($this->filters['debit_account_id'])) {
            $query->where('debit_account_id', $this->filters['debit_account_id']);
        }

        if (!empty($this->filters['credit_account_id'])) {
            $query->where('credit_account_id', $this->filters['credit_account_id']);
        }

        return $query->orderBy('id', 'asc')->get();
    }

    public function headings(): array
    {
        return [
            'Document No.',
            'Date',
            'Description',
            'Debit Account',
            'Credit Account',
            'Amount (Rp)'
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->id,
            $transaction->transaction_date->format('d-m-Y'),
            $transaction->description,
            $transaction->debitAccount 
                ? $transaction->debitAccount->id . ' - ' . $transaction->debitAccount->name . ' (' . $transaction->debitAccount->type . ')' 
                : '-',
            $transaction->creditAccount 
                ? $transaction->creditAccount->id . ' - ' . $transaction->creditAccount->name . ' (' . $transaction->creditAccount->type . ')' 
                : '-',
            number_format($transaction->amount, 0, ',', '.')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold
            1 => ['font' => ['bold' => true]],
        ];
    }
}
