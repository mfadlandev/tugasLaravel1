@extends('layouts.admin-layout')

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
        {{ $title }}
    </h2>

    <div>
        <div class="shadow px-6 py-4 bg-white rounded sm:px-1 sm:py-1">
            <div class="grid grid-cols-12">
                <div class="col-span-6 p-4">
                    <a href="{{ route('petani.create') }}">
                        <button
                            class="px-4 py-1 text-sm rounded text-purple-600 font-semibold border border-purple-200 hover:text-white hover:bg-purple-600 hover:border-transparent focus:outline-none">Tambah</button>
                    </a>
                    <button
                        class="px-4 py-1 text-sm rounded text-green-600 font-semibold border border-green-200 hover:text-white hover:bg-green-600 hover:border-transparent focus:outline-none">Publish</button>
                    <button
                        class="px-4 py-1 text-sm rounded text-red-600 font-semibold border border-red-200 hover:text-white hover:bg-red-600 hover:border-transparent focus:outline-none">Delete</button>
                </div>



                <div class="col-span-6 p-4 flex justify-end">
                    <form action="{{ route('petani.index') }}" method="GET" class="flex flex-wrap gap-2">

                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama atau NIK..." class="px-4 py-2 rounded border border-gray-300 sm:text-sm">

                        <select name="kelompok" class="px-4 py-2 rounded border border-gray-300 sm:text-sm">
                            <option value="">Semua Kelompok</option>

                            @foreach ($kelompoks as $kelompok)
                                <option value="{{ $kelompok->id_kelompok_tani }}"
                                    {{ request('kelompok') == $kelompok->id_kelompok_tani ? 'selected' : '' }}>
                                    {{ $kelompok->nama_kelompok }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit" class="px-4 py-2 rounded border bg-blue-600 text-white">
                            Cari / Filter
                        </button>

                        <a href="{{ route('petani.index') }}" class="px-4 py-2 rounded border border-gray-300">
                            Reset
                        </a>
                    </form>
                </div>


            </div>

            <div class="py-2 align-middle inline-block min-w-full sm:px-4 lg:px-4">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kontak
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kelompok
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($petanis as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <input type="checkbox" name="" id=""
                                                class="mr-2 rounded border-gray-300">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full object-cover"
                                                    src="{{ asset('storage/' . $item->foto) }}" alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $item->nama }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $item->nik }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $item->telp }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->alamat }}</div>
                                    </td>


                                    {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->nama_kelompok }}
                                    </td> --}}

                                    {{-- tambahkan tampilan kelompok tani --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->kelompoktani->nama_kelompok }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form action="{{ route('petani.destroy', $item->id_penjual) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <a href="{{ route('petani.edit', $item->id_penjual) }}"
                                                class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>

                                            <button class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('Anda Yakin ?')" type="submit">Del</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Tombol pagination --}}
                <div class="mt-4 px-4 pb-4">
                    {{ $petanis->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
