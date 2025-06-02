@extends('layouts.app')

@section('title', 'Transaksi - Sistem Manajemen Keuangan')

@section('content')
<section id="transaksi" class="tab active">
  <h2>Catat Transaksi</h2>
  
  <div class="transaction-tabs">
    <button class="tab-btn active" data-type="expense">Pengeluaran</button>
    <button class="tab-btn" data-type="income">Pemasukan</button>
  </div>
  
  <div class="transaction-forms">
    <!-- Form Pengeluaran -->
    <form id="form-expense" class="transaction-form active" method="POST" action="{{ route('expenses.store') }}">
      @csrf
      <input type="text" name="description" placeholder="Nama Transaksi" required />
      <input type="number" name="amount" step="0.01" placeholder="Jumlah (Rp)" required />
      <select name="category_id" required>
        <option value="">Pilih Kategori</option>
        @foreach($expenseCategories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
      </select>
      <input type="date" name="date" required value="{{ date('Y-m-d') }}" />
      <button type="submit">Tambah Pengeluaran</button>
    </form>
    
    <!-- Form Pemasukan -->
    <form id="form-income" class="transaction-form" method="POST" action="{{ route('incomes.store') }}">
      @csrf
      <input type="text" name="description" placeholder="Nama Transaksi" required />
      <input type="number" name="amount" step="0.01" placeholder="Jumlah (Rp)" required />
      <select name="category_id" required>
        <option value="">Pilih Kategori</option>
        @foreach($incomeCategories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
      </select>
      <input type="date" name="date" required value="{{ date('Y-m-d') }}" />
      <button type="submit">Tambah Pemasukan</button>
    </form>
  </div>
  
  <input type="text" id="search" placeholder="Cari transaksi..." />
  
  <h3>Semua Transaksi</h3>
  <ul id="daftar-transaksi">
    @foreach($transactions as $transaction)
    <li>
      <span>{{ $transaction->description }} - Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
      <span>
        <span class="{{ $transaction->type === 'income' ? 'income' : 'expense' }}">
          {{ $transaction->type === 'income' ? 'Income' : 'Expense' }}
        </span>
        <a href="{{ $transaction->type === 'income' ? route('incomes.edit', $transaction->id) : route('expenses.edit', $transaction->id) }}" 
           title="Edit Transaksi" style="margin-left:10px;">✏️</a>
        <button 
          onclick="deleteTransaction('{{ $transaction->type }}', {{ $transaction->id }})" 
          title="Hapus Transaksi" 
          style="margin-left:10px;">❌</button>
      </span>
    </li>
    @endforeach
  </ul>
</section>

<form id="delete-form" method="POST" style="display: none;">
  @csrf
  @method('DELETE')
</form>
@endsection

@section('extra_js')
<script>
  // Toggle between expense and income forms
  document.querySelectorAll('.tab-btn').forEach(button => {
    button.addEventListener('click', function() {
      // Remove active class from all buttons and forms
      document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
      document.querySelectorAll('.transaction-form').forEach(form => form.classList.remove('active'));
      
      // Add active class to clicked button and corresponding form
      this.classList.add('active');
      document.getElementById('form-' + this.dataset.type).classList.add('active');
    });
  });
  
  // Delete transaction function
  function deleteTransaction(type, id) {
    if (confirm('Yakin ingin menghapus transaksi ini?')) {
      const form = document.getElementById('delete-form');
      form.action = type === 'income' 
        ? "{{ url('incomes') }}/" + id
        : "{{ url('expenses') }}/" + id;
      form.submit();
    }
  }
  
  // Search functionality
  document.getElementById('search').addEventListener('input', function() {
    const searchText = this.value.toLowerCase();
    const transactions = document.querySelectorAll('#daftar-transaksi li');
    
    transactions.forEach(transaction => {
      const text = transaction.textContent.toLowerCase();
      transaction.style.display = text.includes(searchText) ? '' : 'none';
    });
  });
</script>
@endsection