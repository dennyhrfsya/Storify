@extends('layouts.admin')
@section('title', 'Users - Hak Akses')

@section('content')
    <div class="container-fluid">

        <div class="row mx-auto">
            <div class="col">

                <h5 class="dx-text-lg dx-text-biru dx-mb-10 text-center">Hak Akses <span
                        class="dx-text-kuning dx-font-bold dx-text-2xl">User</span>
                </h5>

                <div class="dx-table">
                    <div class="table-responsive">
                        <table class="table dx-batch-table">
                            <thead>
                                <tr>
                                    <th scope="col" class="align-middle">No</th>
                                    <th scope="col" class="align-middle">Role</th>
                                    <th scope="col" colspan="6" class="align-middle">Module</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $permission->role }}</td>
                                        <td>{{ $permission->module }}</td>
                                        <td>
                                            <div class="position-relative dx-text-xs dx-text-abu-abu dx-checkbox">
                                                <input id="icon-login" type="checkbox" name="remember" class="perm-check"
                                                    data-role="{{ $permission->role }}"
                                                    data-module="{{ $permission->module }}" data-field="all"
                                                    {{ $permission->all ? 'checked' : '' }}>
                                                <label>
                                                    All/Menu
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="position-relative dx-text-xs dx-text-abu-abu dx-checkbox">
                                                <input id="icon-login" type="checkbox" name="remember" class="perm-check"
                                                    data-role="{{ $permission->role }}"
                                                    data-module="{{ $permission->module }}" data-field="tambah"
                                                    {{ $permission->tambah ? 'checked' : '' }}>
                                                <label>
                                                    Tambah
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="position-relative dx-text-xs dx-text-abu-abu dx-checkbox">
                                                <input id="icon-login" type="checkbox" name="remember" class="perm-check"
                                                    data-role="{{ $permission->role }}"
                                                    data-module="{{ $permission->module }}" data-field="ubah"
                                                    {{ $permission->ubah ? 'checked' : '' }}>
                                                <label>
                                                    Ubah
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="position-relative dx-text-xs dx-text-abu-abu dx-checkbox">
                                                <input id="icon-login" type="checkbox" name="remember" class="perm-check"
                                                    data-role="{{ $permission->role }}"
                                                    data-module="{{ $permission->module }}" data-field="hapus"
                                                    {{ $permission->hapus ? 'checked' : '' }}>
                                                <label>
                                                    Hapus
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
