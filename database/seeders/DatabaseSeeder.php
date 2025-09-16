<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\DepositMaster;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Data akun untuk yayasan
        $chartOfAccountsYayasan = [
            ['id' => '1100100', 'name' => 'Kas', 'description' => 'Transaksi untuk pembayaran dan penerimaan uang melalui Kas', 'type' => 'Asset', 'role_area' => 'yayasan'],
            ['id' => '1100101', 'name' => 'Money Intransit', 'description' => 'Transaksi Kas penampungan atas penerimaan dan pengeluaran', 'type' => 'Asset', 'role_area' => 'yayasan'],
            ['id' => '1200100', 'name' => 'Bank BSI', 'description' => 'Transaksi untuk pembayaran dan penerimaan uang melalui Transfer bank', 'type' => 'Asset', 'role_area' => 'yayasan'],
            ['id' => '1300100', 'name' => 'Deposito Bank BSI', 'description' => 'Penempatan Deposito melalui bank', 'type' => 'Asset', 'role_area' => 'yayasan'],
            ['id' => '1400100', 'name' => 'Piutang Karyawan', 'description' => 'Piutang ke karyawan atas yang belum terima pembayarannya', 'type' => 'Asset', 'role_area' => 'yayasan'],
            ['id' => '1400101', 'name' => 'Piutang Lain-Lain', 'description' => 'Piutang ke pihak ke tiga atas yang belum terima pembayarannya', 'type' => 'Asset', 'role_area' => 'yayasan'],
            ['id' => '1500100', 'name' => 'Uang Muka', 'description' => 'Transaksi Uang muka untuk biaya operasional kantor', 'type' => 'Asset', 'role_area' => 'yayasan'],
            ['id' => '2100100', 'name' => 'Asset Bangunan', 'description' => 'Transaksi untuk pembangunan gedung', 'type' => 'Asset', 'role_area' => 'yayasan'],
            ['id' => '2200100', 'name' => 'Asset Computer', 'description' => 'Transaksi untuk pembelian Computer dan sejenis nya', 'type' => 'Asset', 'role_area' => 'yayasan'],
            ['id' => '2300100', 'name' => 'Asset Furniture', 'description' => 'Transaksi untuk pembelian meja,kursi dan sejenis nya', 'type' => 'Asset', 'role_area' => 'yayasan'],
            ['id' => '2400100', 'name' => 'Asset Transportasi', 'description' => 'Transaksi untuk pembelian alat-alat transportasi', 'type' => 'Asset', 'role_area' => 'yayasan'],
            ['id' => '2900100', 'name' => 'Pinjaman Koperasi', 'description' => 'Pinjaman uang atau barang melalaui koperasi', 'type' => 'Liability', 'role_area' => 'yayasan'],
            ['id' => '3100100', 'name' => 'Titipan', 'description' => 'Transaksi atas titipan Uang kepada pihak pertama', 'type' => 'Liability', 'role_area' => 'yayasan'],
            ['id' => '4100100', 'name' => 'Hutang Dagang', 'description' => 'Hutang ke pihak ke tiga atas hutang yang belum di bayarkan', 'type' => 'Liability', 'role_area' => 'yayasan'],
            ['id' => '6100100', 'name' => 'Pendapatan SPP', 'description' => 'Transaksi atas penerimaan SPP dan Daftar ulang santri', 'type' => 'Income', 'role_area' => 'yayasan'],
            ['id' => '6100101', 'name' => 'Pendapatan Lain-lain', 'description' => 'Transaksi atas penerimaan Lain-lain', 'type' => 'Income', 'role_area' => 'yayasan'],
            ['id' => '7100101', 'name' => 'Biaya Gaji', 'description' => 'Transaksi atas pembayaran gaji karyawan', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100102', 'name' => 'Biaya Lembur', 'description' => 'Transaksi atas pembayaran lembur karyawan', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100103', 'name' => 'Biaya Transportasi', 'description' => 'Transaksi atas biaya-biaya terkait dengan transportasi', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100104', 'name' => 'Biaya Pengobatan', 'description' => 'Transaksi atas pengobatan karyawan dan Santri', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100105', 'name' => 'Biaya THR', 'description' => 'Transaksi atas pembayaran THR karyawan', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100106', 'name' => 'Biaya Astek', 'description' => 'Transaksi atas pembayaran Astek karyawan', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100107', 'name' => 'Biaya BPJS', 'description' => 'Transaksi atas pembayaran BPJS karyawan', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100108', 'name' => 'Biaya Training', 'description' => 'Transaksi atas pembayaran Training karyawan', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100109', 'name' => 'Biaya Rumah Sakit', 'description' => 'Transaksi atas pembayaran Rumah sakit karyawan', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100110', 'name' => 'Biaya PBB', 'description' => 'Transaksi atas pembayaran PBB', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100111', 'name' => 'Biaya Makan dan Minum', 'description' => 'Transaksi atas pembayaran Makan dan minum', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100112', 'name' => 'Biaya Pembelian ATK', 'description' => 'Transaksi atas pembayaran pembelian ATK', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100113', 'name' => 'Biaya Listrik', 'description' => 'Transaksi atas pembayaran Listrik', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100114', 'name' => 'Biaya Maintenance', 'description' => 'Transaksi atas pembayaran pemeliharaan gedung dan sejenis nya', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100115', 'name' => 'Biaya Telephone', 'description' => 'Transaksi atas pembayaran Telephone kantor', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100116', 'name' => 'Biaya Internet', 'description' => 'Transaksi atas pembayaran Internet kantor', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100117', 'name' => 'Biaya Foto copy', 'description' => 'Transaksi atas pembayaran Foto copy dan sejenis nya', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100118', 'name' => 'Biaya Pengiriman', 'description' => 'Transaksi atas pembayaran pengirima barang dan sejenis nya', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100119', 'name' => 'Biaya Pengamanan', 'description' => 'Transaksi atas pembayaran keamanan dan termasuk gaji security nya', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100120', 'name' => 'Biaya Pemakaian air PAM', 'description' => 'Transaksi atas pembayaran pemakaian air PAM', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100121', 'name' => 'Biaya Ifthor Puasa', 'description' => 'Transaksi atas pemberian makan buka puasa', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100122', 'name' => 'Biaya Ujian', 'description' => 'Transaksi atas biaya ujian', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100123', 'name' => 'Biaya PPDB', 'description' => 'Transaksi atas biaya PPDB', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100124', 'name' => 'Biaya Cetakan', 'description' => 'Transaksi atas pembayaran pencetakan', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100125', 'name' => 'Biaya Kegiatan santri', 'description' => 'Transaksi atas Outing Guru dan Santri', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100126', 'name' => 'Biaya Konsumsi', 'description' => 'Transaksi atas pembayaran konsumsi', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100200', 'name' => 'Biaya Bank', 'description' => 'Transaksi atas pemdebitan biaya administrasi bank', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '7100999', 'name' => 'Biaya Lain-lain', 'description' => 'Transaksi atas pembayaran biaya oprasional lain-lain nya', 'type' => 'Expense', 'role_area' => 'yayasan'],
            ['id' => '8100100', 'name' => 'Bunga Bank BSI', 'description' => 'Pendapatan bunga bank', 'type' => 'Income', 'role_area' => 'yayasan'],
        ];

        // Data akun untuk mahad
        $chartOfAccountsMahad = [
            ['id' => 'M1100100', 'name' => 'Kas', 'description' => 'Transaksi untuk pembayaran dan penerimaan uang melalui Kas', 'type' => 'Asset', 'role_area' => 'mahad'],
            ['id' => 'M1100101', 'name' => 'Money Intransit', 'description' => 'Transaksi Kas penampungan atas penerimaan dan pengeluaran', 'type' => 'Asset', 'role_area' => 'mahad'],
            ['id' => 'M1200100', 'name' => 'Bank BSI', 'description' => 'Transaksi untuk pembayaran dan penerimaan uang melalui Transfer bank', 'type' => 'Asset', 'role_area' => 'mahad'],
            ['id' => 'M1300100', 'name' => 'Deposito Bank BSI', 'description' => 'Penempatan Deposito melalui bank', 'type' => 'Asset', 'role_area' => 'mahad'],
            ['id' => 'M1400100', 'name' => 'Piutang Karyawan', 'description' => 'Piutang ke karyawan atas yang belum terima pembayarannya', 'type' => 'Asset', 'role_area' => 'mahad'],
            ['id' => 'M1400101', 'name' => 'Piutang Lain-Lain', 'description' => 'Piutang ke pihak ke tiga atas yang belum terima pembayarannya', 'type' => 'Asset', 'role_area' => 'mahad'],
            ['id' => 'M1500100', 'name' => 'Uang Muka', 'description' => 'Transaksi Uang muka untuk biaya operasional kantor', 'type' => 'Asset', 'role_area' => 'mahad'],
            ['id' => 'M2100100', 'name' => 'Asset Bangunan', 'description' => 'Transaksi untuk pembangunan gedung', 'type' => 'Asset', 'role_area' => 'mahad'],
            ['id' => 'M2200100', 'name' => 'Asset Computer', 'description' => 'Transaksi untuk pembelian Computer dan sejenis nya', 'type' => 'Asset', 'role_area' => 'mahad'],
            ['id' => 'M2300100', 'name' => 'Asset Furniture', 'description' => 'Transaksi untuk pembelian meja,kursi dan sejenis nya', 'type' => 'Asset', 'role_area' => 'mahad'],
            ['id' => 'M2400100', 'name' => 'Asset Transportasi', 'description' => 'Transaksi untuk pembelian alat-alat transportasi', 'type' => 'Asset', 'role_area' => 'mahad'],
            ['id' => 'M2900100', 'name' => 'Pinjaman Koperasi', 'description' => 'Pinjaman uang atau barang melalaui koperasi', 'type' => 'Liability', 'role_area' => 'mahad'],
            ['id' => 'M3100100', 'name' => 'Titipan', 'description' => 'Transaksi atas titipan Uang kepada pihak pertama', 'type' => 'Liability', 'role_area' => 'mahad'],
            ['id' => 'M4100100', 'name' => 'Hutang Dagang', 'description' => 'Hutang ke pihak ke tiga atas hutang yang belum di bayarkan', 'type' => 'Liability', 'role_area' => 'mahad'],
            ['id' => 'M6100100', 'name' => 'Pendapatan SPP', 'description' => 'Transaksi atas penerimaan SPP dan Daftar ulang santri', 'type' => 'Income', 'role_area' => 'mahad'],
            ['id' => 'M6100101', 'name' => 'Pendapatan Lain-lain', 'description' => 'Transaksi atas penerimaan Lain-lain', 'type' => 'Income', 'role_area' => 'mahad'],
            ['id' => 'M7100101', 'name' => 'Biaya Gaji', 'description' => 'Transaksi atas pembayaran gaji karyawan', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100102', 'name' => 'Biaya Lembur', 'description' => 'Transaksi atas pembayaran lembur karyawan', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100103', 'name' => 'Biaya Transportasi', 'description' => 'Transaksi atas biaya-biaya terkait dengan transportasi', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100104', 'name' => 'Biaya Pengobatan', 'description' => 'Transaksi atas pengobatan karyawan dan Santri', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100105', 'name' => 'Biaya THR', 'description' => 'Transaksi atas pembayaran THR karyawan', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100106', 'name' => 'Biaya Astek', 'description' => 'Transaksi atas pembayaran Astek karyawan', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100107', 'name' => 'Biaya BPJS', 'description' => 'Transaksi atas pembayaran BPJS karyawan', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100108', 'name' => 'Biaya Training', 'description' => 'Transaksi atas pembayaran Training karyawan', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100109', 'name' => 'Biaya Rumah Sakit', 'description' => 'Transaksi atas pembayaran Rumah sakit karyawan', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100110', 'name' => 'Biaya PBB', 'description' => 'Transaksi atas pembayaran PBB', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100111', 'name' => 'Biaya Makan dan Minum', 'description' => 'Transaksi atas pembayaran Makan dan minum', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100112', 'name' => 'Biaya Pembelian ATK', 'description' => 'Transaksi atas pembayaran pembelian ATK', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100113', 'name' => 'Biaya Listrik', 'description' => 'Transaksi atas pembayaran Listrik', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100114', 'name' => 'Biaya Maintenance', 'description' => 'Transaksi atas pembayaran pemeliharaan gedung dan sejenis nya', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100115', 'name' => 'Biaya Telephone', 'description' => 'Transaksi atas pembayaran Telephone kantor', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100116', 'name' => 'Biaya Internet', 'description' => 'Transaksi atas pembayaran Internet kantor', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100117', 'name' => 'Biaya Foto copy', 'description' => 'Transaksi atas pembayaran Foto copy dan sejenis nya', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100118', 'name' => 'Biaya Pengiriman', 'description' => 'Transaksi atas pembayaran pengirima barang dan sejenis nya', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100119', 'name' => 'Biaya Pengamanan', 'description' => 'Transaksi atas pembayaran keamanan dan termasuk gaji security nya', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100120', 'name' => 'Biaya Pemakaian air PAM', 'description' => 'Transaksi atas pembayaran pemakaian air PAM', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100121', 'name' => 'Biaya Ifthor Puasa', 'description' => 'Transaksi atas pemberian makan buka puasa', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100122', 'name' => 'Biaya Ujian', 'description' => 'Transaksi atas biaya ujian', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100123', 'name' => 'Biaya PPDB', 'description' => 'Transaksi atas biaya PPDB', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100124', 'name' => 'Biaya Cetakan', 'description' => 'Transaksi atas pembayaran pencetakan', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100125', 'name' => 'Biaya Kegiatan santri', 'description' => 'Transaksi atas Outing Guru dan Santri', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100126', 'name' => 'Biaya Konsumsi', 'description' => 'Transaksi atas pembayaran konsumsi', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100200', 'name' => 'Biaya Bank', 'description' => 'Transaksi atas pemdebitan biaya administrasi bank', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M7100999', 'name' => 'Biaya Lain-lain', 'description' => 'Transaksi atas pembayaran biaya oprasional lain-lain nya', 'type' => 'Expense', 'role_area' => 'mahad'],
            ['id' => 'M8100100', 'name' => 'Bunga Bank BSI', 'description' => 'Pendapatan bunga bank', 'type' => 'Income', 'role_area' => 'mahad'],
        ];

        // Gabungkan semua akun
        $allAccounts = array_merge($chartOfAccountsYayasan, $chartOfAccountsMahad);

        foreach ($allAccounts as $acc) {
            Account::create(array_merge($acc, ['nilai_awal' => 0]));
        }

        // --- Seed Deposit Master untuk Yayasan ---
        $depositMastersYayasan = [
            [
                'description' => 'Monthly Deposit',
                'default_amount' => 1000,
                'number' => "REQ123",
                'debit_account_id' => '1300100',   // Deposito Bank BSI
                'credit_account_id' => '1200100',  // Bank BSI
                'role_area' => 'yayasan',
            ],
            [
                'description' => 'Emergency Fund',
                'default_amount' => 500,
                'number' => "REQ125",
                'debit_account_id' => '1100100',   // Kas
                'credit_account_id' => '6100101',  // Pendapatan Lain-lain
                'role_area' => 'yayasan',
            ],
            [
                'description' => 'Investment Fund',
                'default_amount' => 2000,
                'number' => "REQ124",
                'debit_account_id' => '2300100',   // Asset Furniture
                'credit_account_id' => '1200100',  // Bank BSI
                'role_area' => 'yayasan',
            ],
        ];

        // --- Seed Deposit Master untuk Mahad ---
        $depositMastersMahad = [
            [
                'description' => 'Monthly Deposit',
                'default_amount' => 1000,
                'number' => "MREQ123",
                'debit_account_id' => 'M1300100',   // Deposito Bank BSI
                'credit_account_id' => 'M1200100',  // Bank BSI
                'role_area' => 'mahad',
            ],
            [
                'description' => 'Emergency Fund',
                'default_amount' => 500,
                'number' => "MREQ125",
                'debit_account_id' => 'M1100100',   // Kas
                'credit_account_id' => 'M6100101',  // Pendapatan Lain-lain
                'role_area' => 'mahad',
            ],
            [
                'description' => 'Investment Fund',
                'default_amount' => 2000,
                'number' => "MREQ124",
                'debit_account_id' => 'M2300100',   // Asset Furniture
                'credit_account_id' => 'M1200100',  // Bank BSI
                'role_area' => 'mahad',
            ],
        ];

        // Gabungkan semua deposit master
        $allDepositMasters = array_merge($depositMastersYayasan, $depositMastersMahad);

        foreach ($allDepositMasters as $dm) {
            DepositMaster::create($dm);
        }

        // --- Seed Transactions untuk Yayasan ---
        $transactionsYayasan = [
            [
                'description' => 'Pembelian ATK',
                'amount' => 250000,
                'paid_to_source' => '1100100',
                'id_deposit_master' => null,
                'debit_account_id' => '7100112',
                'credit_account_id' => '1100100',
                'transaction_date' => '2025-01-02',
                'role_area' => 'yayasan',
            ],
            [
                'description' => 'Penerimaan SPP',
                'amount' => 3000000,
                'paid_to_source' => '1200100',
                'id_deposit_master' => null,
                'debit_account_id' => '1200100',
                'credit_account_id' => '6100100',
                'transaction_date' => '2025-01-05',
                'role_area' => 'yayasan',
            ],
            [
                'description' => 'Setor ke Deposito',
                'amount' => 1000000,
                'paid_to_source' => '1200100',
                'id_deposit_master' => 1,
                'debit_account_id' => '1300100',
                'credit_account_id' => '1200100',
                'transaction_date' => '2025-01-07',
                'role_area' => 'yayasan',
            ],
            [
                'description' => 'Pembayaran Listrik PLN',
                'amount' => 750000,
                'paid_to_source' => '1200100',
                'id_deposit_master' => null,
                'debit_account_id' => '7100113',
                'credit_account_id' => '1200100',
                'transaction_date' => '2025-01-08',
                'role_area' => 'yayasan',
            ],
            [
                'description' => 'Pembayaran Gaji Staff',
                'amount' => 5000000,
                'paid_to_source' => '1200100',
                'id_deposit_master' => null,
                'debit_account_id' => '7100101',
                'credit_account_id' => '1200100',
                'transaction_date' => '2025-01-10',
                'role_area' => 'yayasan',
            ],
            [
                'description' => 'Penerimaan Donasi Alumni',
                'amount' => 2000000,
                'paid_to_source' => '1100100',
                'id_deposit_master' => null,
                'debit_account_id' => '1100100',
                'credit_account_id' => '6100101',
                'transaction_date' => '2025-01-12',
                'role_area' => 'yayasan',
            ],
            [
                'description' => 'Pembelian Meja Kantor',
                'amount' => 1500000,
                'paid_to_source' => '1200100',
                'id_deposit_master' => null,
                'debit_account_id' => '2300100',
                'credit_account_id' => '1200100',
                'transaction_date' => '2025-01-14',
                'role_area' => 'yayasan',
            ],
            [
                'description' => 'Tarik Tunai dari Bank',
                'amount' => 1000000,
                'paid_to_source' => '1200100',
                'id_deposit_master' => null,
                'debit_account_id' => '1100100',
                'credit_account_id' => '1200100',
                'transaction_date' => '2025-01-15',
                'role_area' => 'yayasan',
            ],
            [
                'description' => 'Pembayaran Internet Kantor',
                'amount' => 500000,
                'paid_to_source' => '1100100',
                'id_deposit_master' => null,
                'debit_account_id' => '7100116',
                'credit_account_id' => '1100100',
                'transaction_date' => '2025-01-18',
                'role_area' => 'yayasan',
            ],
            [
                'description' => 'Penerimaan Hibah Pemerintah',
                'amount' => 10000000,
                'paid_to_source' => '1200100',
                'id_deposit_master' => null,
                'debit_account_id' => '1200100',
                'credit_account_id' => '6100101',
                'transaction_date' => '2025-01-20',
                'role_area' => 'yayasan',
            ],
            [
                'description' => 'Pendapatan Bunga Bank',
                'amount' => 120000,
                'paid_to_source' => '1200100',
                'id_deposit_master' => null,
                'debit_account_id' => '1200100',
                'credit_account_id' => '8100100',
                'transaction_date' => '2025-01-22',
                'role_area' => 'yayasan',
            ],
            [
                'description' => 'Pemberian Pinjaman ke Karyawan',
                'amount' => 1500000,
                'paid_to_source' => '1100100',
                'id_deposit_master' => null,
                'debit_account_id' => '1400100',
                'credit_account_id' => '1100100',
                'transaction_date' => '2025-01-23',
                'role_area' => 'yayasan',
            ],
            [
                'description' => 'Pembayaran Transportasi Acara',
                'amount' => 600000,
                'paid_to_source' => '1100100',
                'id_deposit_master' => null,
                'debit_account_id' => '7100103',
                'credit_account_id' => '1100100',
                'transaction_date' => '2025-01-24',
                'role_area' => 'yayasan',
            ],
            [
                'description' => 'Pembayaran BPJS Karyawan',
                'amount' => 900000,
                'paid_to_source' => '1200100',
                'id_deposit_master' => null,
                'debit_account_id' => '7100107',
                'credit_account_id' => '1200100',
                'transaction_date' => '2025-01-25',
                'role_area' => 'yayasan',
            ],
            [
                'description' => 'Pembayaran Cetakan Brosur',
                'amount' => 300000,
                'paid_to_source' => '1100100',
                'id_deposit_master' => null,
                'debit_account_id' => '7100124',
                'credit_account_id' => '1100100',
                'transaction_date' => '2025-01-26',
                'role_area' => 'yayasan',
            ],
            [
                'description' => 'Pembayaran Makan & Minum Acara',
                'amount' => 750000,
                'paid_to_source' => '1100100',
                'id_deposit_master' => null,
                'debit_account_id' => '7100111',
                'credit_account_id' => '1100100',
                'transaction_date' => '2025-01-27',
                'role_area' => 'yayasan',
            ],
        ];

        // --- Seed Transactions untuk Mahad ---
        $transactionsMahad = [
            [
                'description' => 'Pembelian ATK',
                'amount' => 250000,
                'paid_to_source' => 'M1100100',
                'id_deposit_master' => null,
                'debit_account_id' => 'M7100112',
                'credit_account_id' => 'M1100100',
                'transaction_date' => '2025-01-02',
                'role_area' => 'mahad',
            ],
            [
                'description' => 'Penerimaan SPP',
                'amount' => 3000000,
                'paid_to_source' => 'M1200100',
                'id_deposit_master' => null,
                'debit_account_id' => 'M1200100',
                'credit_account_id' => 'M6100100',
                'transaction_date' => '2025-01-05',
                'role_area' => 'mahad',
            ],
            [
                'description' => 'Setor ke Deposito',
                'amount' => 1000000,
                'paid_to_source' => 'M1200100',
                'id_deposit_master' => 4,
                'debit_account_id' => 'M1300100',
                'credit_account_id' => 'M1200100',
                'transaction_date' => '2025-01-07',
                'role_area' => 'mahad',
            ],
            [
                'description' => 'Pembayaran Listrik PLN',
                'amount' => 750000,
                'paid_to_source' => 'M1200100',
                'id_deposit_master' => null,
                'debit_account_id' => 'M7100113',
                'credit_account_id' => 'M1200100',
                'transaction_date' => '2025-01-08',
                'role_area' => 'mahad',
            ],
            [
                'description' => 'Pembayaran Gaji Staff',
                'amount' => 5000000,
                'paid_to_source' => 'M1200100',
                'id_deposit_master' => null,
                'debit_account_id' => 'M7100101',
                'credit_account_id' => 'M1200100',
                'transaction_date' => '2025-01-10',
                'role_area' => 'mahad',
            ],
            [
                'description' => 'Penerimaan Donasi Alumni',
                'amount' => 2000000,
                'paid_to_source' => 'M1100100',
                'id_deposit_master' => null,
                'debit_account_id' => 'M1100100',
                'credit_account_id' => 'M6100101',
                'transaction_date' => '2025-01-12',
                'role_area' => 'mahad',
            ],
            [
                'description' => 'Pembelian Meja Kantor',
                'amount' => 1500000,
                'paid_to_source' => 'M1200100',
                'id_deposit_master' => null,
                'debit_account_id' => 'M2300100',
                'credit_account_id' => 'M1200100',
                'transaction_date' => '2025-01-14',
                'role_area' => 'mahad',
            ],
            [
                'description' => 'Tarik Tunai dari Bank',
                'amount' => 1000000,
                'paid_to_source' => 'M1200100',
                'id_deposit_master' => null,
                'debit_account_id' => 'M1100100',
                'credit_account_id' => 'M1200100',
                'transaction_date' => '2025-01-15',
                'role_area' => 'mahad',
            ],
            [
                'description' => 'Pembayaran Internet Kantor',
                'amount' => 500000,
                'paid_to_source' => 'M1100100',
                'id_deposit_master' => null,
                'debit_account_id' => 'M7100116',
                'credit_account_id' => 'M1100100',
                'transaction_date' => '2025-01-18',
                'role_area' => 'mahad',
            ],
            [
                'description' => 'Penerimaan Hibah Pemerintah',
                'amount' => 10000000,
                'paid_to_source' => 'M1200100',
                'id_deposit_master' => null,
                'debit_account_id' => 'M1200100',
                'credit_account_id' => 'M6100101',
                'transaction_date' => '2025-01-20',
                'role_area' => 'mahad',
            ],
            [
                'description' => 'Pendapatan Bunga Bank',
                'amount' => 120000,
                'paid_to_source' => 'M1200100',
                'id_deposit_master' => null,
                'debit_account_id' => 'M1200100',
                'credit_account_id' => 'M8100100',
                'transaction_date' => '2025-01-22',
                'role_area' => 'mahad',
            ],
            [
                'description' => 'Pemberian Pinjaman ke Karyawan',
                'amount' => 1500000,
                'paid_to_source' => 'M1100100',
                'id_deposit_master' => null,
                'debit_account_id' => 'M1400100',
                'credit_account_id' => 'M1100100',
                'transaction_date' => '2025-01-23',
                'role_area' => 'mahad',
            ],
            [
                'description' => 'Pembayaran Transportasi Acara',
                'amount' => 600000,
                'paid_to_source' => 'M1100100',
                'id_deposit_master' => null,
                'debit_account_id' => 'M7100103',
                'credit_account_id' => 'M1100100',
                'transaction_date' => '2025-01-24',
                'role_area' => 'mahad',
            ],
            [
                'description' => 'Pembayaran BPJS Karyawan',
                'amount' => 900000,
                'paid_to_source' => 'M1200100',
                'id_deposit_master' => null,
                'debit_account_id' => 'M7100107',
                'credit_account_id' => 'M1200100',
                'transaction_date' => '2025-01-25',
                'role_area' => 'mahad',
            ],
            [
                'description' => 'Pembayaran Cetakan Brosur',
                'amount' => 300000,
                'paid_to_source' => 'M1100100',
                'id_deposit_master' => null,
                'debit_account_id' => 'M7100124',
                'credit_account_id' => 'M1100100',
                'transaction_date' => '2025-01-26',
                'role_area' => 'mahad',
            ],
            [
                'description' => 'Pembayaran Makan & Minum Acara',
                'amount' => 750000,
                'paid_to_source' => 'M1100100',
                'id_deposit_master' => null,
                'debit_account_id' => 'M7100111',
                'credit_account_id' => 'M1100100',
                'transaction_date' => '2025-01-27',
                'role_area' => 'mahad',
            ],
        ];

        // Gabungkan semua transaksi
        $allTransactions = array_merge($transactionsYayasan, $transactionsMahad);

        foreach ($allTransactions as $trx) {
            Transaction::create($trx);
        }

        // --- Seed Users (Admin & User Default) ---
        User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'type' => 'admin',
        ]);
        User::create([
            'username' => 'bendahara',
            'email' => 'bendahara@example.com',
            'password' => Hash::make('password'),
            'type' => 'admin',
        ]);


        User::create([
            'username' => 'user',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'type' => 'user',
        ]);
    }
}