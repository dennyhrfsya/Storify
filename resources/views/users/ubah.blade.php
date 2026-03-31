@extends('layouts.admin')
@section('title', 'Users - Ubah')

@section('content')
    <div class="container-fluid">

        <div class="row mx-auto">
            <div class="col">

                <h5 class="dx-text-lg dx-text-biru dx-mb-4 text-center">Ubah <span
                        class="dx-text-kuning dx-font-bold dx-text-2xl">User</span>
                </h5>

                <form method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="dx-form-control">
                        <div class="dx-form-group">
                            <label for="name">Nama</label>
                            <input type="text" id="name" name="name" placeholder="Nama Lengkap"
                                value="{{ old('name', $user->name) }}" />
                            @error('name')
                                <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="dx-form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="Email@mail.com"
                                value="{{ old('email', $user->email) }}" />
                            @error('email')
                                <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="dx-form-group">
                            <label for="password">Password <span class="dx-text-sm dx-text-merah">(Kosongkan jika tidak
                                    diubah)</span></label>
                            <input type="password" id="password" name="password" placeholder="Password"
                                value="{{ old('password') }}" />
                            @error('password')
                                <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="dx-form-group">
                            <label for="role">Role</label>
                            <select id="select" name="role">
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                            </select>
                        </div>

                        <div class="d-flex gap-2 justify-content-center">
                            <button type="submit" class="dx-btn dx-btn-primary w-25">Update</button>
                            <a href="{{ route('users.index') }}" class="dx-btn dx-btn-secondary w-25">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
