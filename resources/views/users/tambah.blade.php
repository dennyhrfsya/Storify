@extends('layouts.admin')
@section('title', 'Users - Tambah')

@section('content')
    <div class="container-fluid">

        <div class="row mx-auto">
            <div class="col">

                <h5 class="dx-text-lg dx-text-biru dx-mb-10 text-center">Tambah <span
                        class="dx-text-kuning dx-font-bold dx-text-2xl">User</span>
                </h5>

                <form method="POST" action="{{ route('users.simpan') }}">
                    @csrf
                    <div class="dx-form-control">
                        <div class="dx-form-group">
                            <label for="name">Nama</label>
                            <input type="text" id="name" name="name" placeholder="Nama Lengkap"
                                value="{{ old('name') }}" autofocus />
                            @error('name')
                                <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="dx-form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="Email@mail.com"
                                value="{{ old('email') }}" />
                            @error('email')
                                <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="dx-form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Password"
                                value="{{ old('password') }}" />
                            @error('password')
                                <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="dx-btn dx-btn-primary w-25">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
