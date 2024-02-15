<!-- resources/views/search.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Search Results</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Column 1</th>
                    <th>Column 2</th>
                    <!-- Tambahkan kolom lain sesuai kebutuhan -->
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $result)
                    <tr>
                        <td>{{ $result->column1 }}</td>
                        <td>{{ $result->column2 }}</td>
                        <!-- Tambahkan kolom lain sesuai kebutuhan -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
