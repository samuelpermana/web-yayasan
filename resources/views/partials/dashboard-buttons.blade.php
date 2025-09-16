<div style="margin-bottom: 20px; display: flex; gap: 12px; flex-wrap: wrap;">
    <a href="{{ route('dashboard') }}" 
       class="btn-nav btn-primary-custom {{ request()->routeIs('dashboard') ? 'active-btn' : '' }}">
       Dashboard
    </a>
    <a href="{{ route('dashboard.yayasan') }}" 
       class="btn-nav btn-success-custom {{ request()->routeIs('dashboard.yayasan') ? 'active-btn' : '' }}">
       Dashboard Yayasan
    </a>
    <a href="{{ route('dashboard.mahad') }}" 
       class="btn-nav btn-info-custom {{ request()->routeIs('dashboard.mahad') ? 'active-btn' : '' }}">
       Dashboard Mahad
    </a>
</div>

<style>
    .btn-nav {
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s ease-in-out;
        display: inline-block;
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
    }

    .btn-nav:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.25);
    }

    /* Warna default */
    .btn-primary-custom { background: #007bff; color: white; }
    .btn-primary-custom:hover { background: #0069d9; }

    .btn-success-custom { background: #28a745; color: white; }
    .btn-success-custom:hover { background: #218838; }

    .btn-info-custom { background: #17a2b8; color: white; }
    .btn-info-custom:hover { background: #138496; }

    /* === Highlight Aktif === */
    .active-btn {
        border: 2px solid #ffc107;
        box-shadow: 0 0 12px rgba(255,193,7,0.6);
        transform: scale(1.05);
    }
</style>
