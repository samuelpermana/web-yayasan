<div class="header1">

    <!-- Baris Tengah: Judul dan Deskripsi -->
    <div class="corner-decoration top-left"></div>
        <div class="corner-decoration bottom-right"></div>
        
        <!-- Main Content -->
        <h1>Ummahatul Mukminin</h1>
        <div class="accent-line"></div>
        <p>Website Pengelola keuangan yayasan dengan mudah, transparan, dan teratur.</p>

    <div class="bottom-section">
        <form class="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
            <button type="submit" class="btn1-logout">Logout</button>
        </form>
    </div>
</div>
</div>
