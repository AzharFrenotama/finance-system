@extends('layouts.app')

@section('title', 'Laporan - Sistem Manajemen Keuangan')

@section('content')
<section id="laporan" class="tab active">
  <h2>Laporan Keuangan</h2>
  
  <div class="filter-controls">
    <form method="GET" action="{{ route('reports.index') }}" class="report-filter">
      <select name="month">
        <option value="">Semua Bulan</option>
        @foreach(range(1, 12) as $month)
        <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
          {{ date('F', mktime(0, 0, 0, $month, 1)) }}
        </option>
        @endforeach
      </select>
      
      <select name="year">
        <option value="">Semua Tahun</option>
        @foreach(range(date('Y')-2, date('Y')) as $year)
        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
          {{ $year }}
        </option>
        @endforeach
      </select>
      
      <button type="submit">Tampilkan</button>
    </form>
  </div>
  
  <div class="report-summary">
    <div class="card">
      <h3>Ringkasan Periode {{ $periodLabel }}</h3>
      <div class="summary-numbers">
        <div class="summary-item">
          <span class="label">Total Pemasukan:</span>
          <span class="amount income">Rp {{ number_format($totalIncome, 0, ',', '.') }}</span>
        </div>
        <div class="summary-item">
          <span class="label">Total Pengeluaran:</span>
          <span class="amount expense">Rp {{ number_format($totalExpense, 0, ',', '.') }}</span>
        </div>
        <div class="summary-item">
          <span class="label">Selisih:</span>
          <span class="amount {{ ($totalIncome - $totalExpense) >= 0 ? 'income' : 'expense' }}">
            Rp {{ number_format(abs($totalIncome - $totalExpense), 0, ',', '.') }}
            {{ ($totalIncome - $totalExpense) >= 0 ? '(Surplus)' : '(Defisit)' }}
          </span>
        </div>
      </div>
    </div>
  </div>
  
  <div class="charts-container">
    <div class="card">
      <h3>Grafik Pemasukan vs Pengeluaran</h3>
      <canvas id="grafikLaporan" height="200"></canvas>
    </div>
    
    <div class="card">
      <h3>Pengeluaran per Kategori</h3>
      <canvas id="categoryExpenseChart" height="200"></canvas>
    </div>
  </div>
</section>
@endsection

@section('extra_js')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Data from controller
    const incomeData = {!! json_encode($incomeData) !!};
    const expenseData = {!! json_encode($expenseData) !!};
    const categoryExpenseData = {!! json_encode($categoryExpenseData) !!};
    
    // Main income vs expense chart
    const mainCtx = document.getElementById('grafikLaporan').getContext('2d');
    new Chart(mainCtx, {
      type: 'bar',
      data: {
        labels: incomeData.labels,
        datasets: [
          {
            label: 'Pemasukan',
            data: incomeData.values,
            backgroundColor: '#4caf50',
            borderColor: '#43a047',
            borderWidth: 1
          },
          {
            label: 'Pengeluaran',
            data: expenseData.values,
            backgroundColor: '#f44336',
            borderColor: '#e53935',
            borderWidth: 1
          }
        ]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
    
    // Category expense chart
    const catCtx = document.getElementById('categoryExpenseChart').getContext('2d');
    new Chart(catCtx, {
      type: 'doughnut',
      data: {
        labels: categoryExpenseData.labels,
        datasets: [{
          data: categoryExpenseData.values,
          backgroundColor: [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
            '#FF9F40', '#c0ca33', '#00acc1', '#8e24aa', '#5d4037'
          ]
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    });
  });
</script>
@endsection