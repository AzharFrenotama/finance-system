@extends('layouts.app')

@section('title', 'Dashboard - Sistem Manajemen Keuangan')

@section('content')
<section id="dashboard" class="tab active">
  <div class="summary">
    <div class="card">
      <h3>Saldo</h3>
      <p id="saldo">Rp {{ number_format($balance, 0, ',', '.') }}</p>
    </div>
    <div class="card">
      <h3>Pemasukan</h3>
      <p id="pemasukan">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
    </div>
    <div class="card">
      <h3>Pengeluaran</h3>
      <p id="pengeluaran">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
    </div>
  </div>
  
  <div class="row mt-4">
    <div class="card">
      <h3>Transaksi Terbaru</h3>
      <ul class="recent-transactions">
        @foreach($recentTransactions as $transaction)
        <li>
          <span>{{ $transaction->description }} - Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
          <span>
            <span class="{{ $transaction->type === 'income' ? 'income' : 'expense' }}">
              {{ $transaction->type === 'income' ? 'Income' : 'Expense' }}
            </span>
            <span>{{ $transaction->date->format('d/m/Y') }}</span>
          </span>
        </li>
        @endforeach
      </ul>
    </div>
  </div>
</section>
@endsection