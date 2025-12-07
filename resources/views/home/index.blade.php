@extends('app')
@section('title', 'Home')
@section('content')
<div class="w-full">
    <h5>Selamat Datang di Halaman Dashboard.</h5>
    <br>
    <div class="flex flex-wrap gap-6">
        <div class="flex-1 min-w-[250px]">
            <div class="card h-full">
                <div class="card-header !pb-0 !border-b-0">
                    <h5>Jumlah Karyawan</h5>
                </div>
                <div class="card-body">
                    <div class="flex items-center justify-between gap-3 flex-wrap">
                        <h3 class="font-light flex items-center mb-0">
                            <i class="feather icon-users text-success-500 text-[30px] mr-1.5"></i>
                            {{ $count_karyawan }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-1 min-w-[250px]">
            <div class="card h-full">
                <div class="card-header !pb-0 !border-b-0">
                    <h5>Jumlah Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="flex items-center justify-between gap-3 flex-wrap">
                        <h3 class="font-light flex items-center mb-0">
                            <i class="feather icon-shopping-cart text-danger-500 text-[30px] mr-1.5"></i>
                            {{ $count_pesanan }} <span class="ml-1" style="margin-left:20px;"></span><span class="mx-4 py-3 text-sm">Total Item {{ $count_pesanan_detail }}</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-1 min-w-[250px]">
            <div class="card h-full">
                <div class="card-header !pb-0 !border-b-0">
                    <h5>Jumlah Bahan Produksi</h5>
                </div>
                <div class="card-body">
                    <div class="flex items-center justify-between gap-3 flex-wrap">
                        <h3 class="font-light flex items-center mb-0">
                            <i class="feather icon-more-horizontal text-success-500 text-[30px] mr-1.5"></i>
                            {{ $count_bahan_baku }} 
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-1 min-w-[250px]">
            <div class="card h-full">
                <div class="card-header !pb-0 !border-b-0">
                    <h5>Jumlah Proses Produksi</h5>
                </div>
                <div class="card-body">
                    <div class="flex items-center justify-between gap-3 flex-wrap">
                        <h3 class="font-light flex items-center mb-0">
                            <i class="feather icon-codepen text-success-500 text-[30px] mr-1.5"></i>
                            {{ $count_produksi }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
