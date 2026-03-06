@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <h2 class="md:dx-block dx-text-biru dx-font-bold dx-text-lg dx-mb-4">Dashboard
        </h2>

        @if (session('status'))
            <div id="welcomeNotice" class="dx-notice dx-notice-information">
                <div class="dx-notice-icon">
                    <img src="{{ asset('images/icon-admin.png') }}" alt="notif" class="img-fluid">
                </div>
                <div class="row dx-notice-body">
                    <div class="dx-notice-body-text">
                        <h3 class="dx-notice-title">Selamat Datang !</h3>
                        <p>{{ session('status') }}, anda berhasil masuk <strong>{{ auth()->user()->name }}</strong></p>
                    </div>
                </div>
            </div>
        @endif

        <div class="dx-grid dx-mb-12">
            <div class="dx-box-content dx-bg-putih card-body p-3">
                <div class="dx-box-title">
                    <h5 class="dx-text-sm dx-font-bold">Total</h5>
                    <p class="dx-box-text display-4 dx-text-hijau counter" id="total" data-target="{{ $totalUsers }}">
                        0
                    </p>
                </div>
                <div class="dx-box-section">
                    <img src="{{ asset('images/icon-user.png') }}" alt="" class="dx-img-box">
                </div>
            </div>
            <div class="col dx-box-content dx-bg-putih card-body p-3">
                <div class="dx-box-title">
                    <h5 class="dx-text-sm dx-font-bold">Total</h5>
                    <p class="dx-box-text display-4 dx-text-merah counter" id="total" data-target="{{ $totalAsets }}">
                        0
                    </p>
                </div>
                <div class="dx-box-section">
                    <img src="{{ asset('images/icon-keranjang.png') }}" alt="" class="dx-img-box">
                </div>
            </div>
            <div class="col dx-box-content dx-bg-putih card-body p-3">
                <div class="dx-box-title">
                    <h5 class="dx-text-sm dx-font-bold">Total</h5>
                    <p class="dx-box-text display-4 dx-text-kuning counter" id="total" data-target="30">
                        0</p>
                </div>
                <div class="dx-box-section">
                    <img src="{{ asset('images/icon-lampu.png') }}" alt="" class="dx-img-box">
                </div>
            </div>
            <div class="col dx-box-content dx-bg-putih card-body p-3">
                <div class="dx-box-title">
                    <h5 class="dx-text-sm dx-font-bold">Total</h5>
                    <p class="dx-box-text display-4 dx-text-biru counter" id="total" data-target="10">0
                    </p>
                </div>
                <div class="dx-box-section">
                    <img src="{{ asset('images/icon-database.png') }}" alt="" class="dx-img-box">
                </div>
            </div>
        </div>
    </div>
@endsection
