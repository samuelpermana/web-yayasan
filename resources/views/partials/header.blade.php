<div class="header" style="display: flex; flex-direction: column; align-items: center; position: relative; padding: 10px;">
    
    <!-- Baris Atas: Logout di pojok kanan -->
    <div style="width: 100%; display: flex; justify-content: flex-end;">
        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>

    <!-- Baris Tengah: Judul dan Deskripsi -->
    <div style="text-align: center; margin-top: 10px;">
        <h1>YAYASAN AYAH BIGEL</h1>
        <p>Comprehensive solution for income tracking, expense management, and financial reporting</p>
    </div>

</div>
