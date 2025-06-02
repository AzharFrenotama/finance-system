@extends('layouts.app')

@section('title', 'Anggaran - Sistem Manajemen Keuangan')

@section('content')
<section id="anggaran" class="tab active">
  <h2>Fitur Anggaran</h2>
  
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <h3>Tambah Anggaran Baru</h3>
        <form method="POST" action="{{ route('budgets.store') }}">
          @csrf
          <select name="category_id" required>
            <option value="">Pilih Kategori</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
          </select>
          
          <select name="month" required>
            <option value="">Pilih Bulan</option>
            @foreach(range(1, 12) as $month)
            <option value="{{ $month }}">{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
            @endforeach
          </select>
          
          <select name="year" required>
            <option value="">Pilih Tahun</option>
            @foreach(range(date('Y'), date('Y')+5) as $year)
            <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
          </select>
          
          <input type="number" name="limit_amount" step="0.01" placeholder="Batas Anggaran (Rp)" required />
          <button type="submit">Simpan Anggaran</button>
        </form>
      </div>
    </div>
  </div>
  
  <h3>Anggaran Aktif</h3>
  <div class="budgets-list">
    @foreach($budgets as $budget)
    <div class="budget-item card">
      <div class="budget-header">
        <h4>{{ $budget->category->name }}</h4>
        <span>{{ date('F', mktime(0, 0, 0, $budget->month, 1)) }} {{ $budget->year }}</span>
      </div>
      
      <div class="budget-details">
        <div class="budget-values">
          <span>Rp {{ number_format($budget->current_expense, 0, ',', '.') }} / Rp {{ number_format($budget->limit_amount, 0, ',', '.') }}</span>
        </div>
        
        <div class="budget-progress">
          @php
            $percentage = min(100, ($budget->current_expense / $budget->limit_amount) * 100);
            $progressClass = $percentage > 85 ? 'danger' : ($percentage > 65 ? 'warning' : 'safe');
          @endphp
          <div class="progress-bar">
            <div class="progress {{ $progressClass }}" style="width: {{ $percentage }}%"></div>
          </div>
          <span class="percentage">{{ number_format($percentage, 0) }}%</span>
        </div>
        
        <div class="budget-actions">
          <a href="{{ route('budgets.edit', $budget->id) }}" class="edit-btn">Edit</a>
          <form method="POST" action="{{ route('budgets.destroy', $budget->id) }}" style="display:inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-btn" onclick="return confirm('Yakin ingin menghapus anggaran ini?')">Hapus</button>
          </form>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</section>
@endsection

@section('extra_css')
<style>
  .budget-item {
    margin-bottom: 15px;
  }
  
  .budget-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
  }
  
  .budget-values {
    margin-bottom: 8px;
  }
  
  .budget-progress {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
  }
  
  .progress-bar {
    flex-grow: 1;
    height: 10px;
    background-color: #eee;
    border-radius: 5px;
    overflow: hidden;
    margin-right: 10px;
  }
  
  .progress {
    height: 100%;
    transition: width 0.3s ease;
  }
  
  .progress.safe {
    background-color: #4caf50;
  }
  
  .progress.warning {
    background-color: #ff9800;
  }
  
  .progress.danger {
    background-color: #f44336;
  }
  
  .percentage {
    min-width: 45px;
    text-align: right;
  }
  
  .budget-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
  }
  
  .edit-btn, .delete-btn {
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .edit-btn {
    background-color: #2196F3;
    color: white;
    text-decoration: none;
  }
  
  .delete-btn {
    background-color: #f44336;
    color: white;
    border: none;
  }
</style>
@endsection