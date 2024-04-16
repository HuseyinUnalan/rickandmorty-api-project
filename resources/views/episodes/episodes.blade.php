@extends('main_master')
@section('content')
@section('title')
    Episodes
@endsection


<div class="container mt-5">

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Episode</th>
                <th scope="col">Date</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>

            @foreach ($episodes as $episode)
                <tr>
                    <th scope="row">{{ $episode->id }}</th>
                    <td> {{ $episode->name }}</td>
                    <td>{{ $episode->episode }}</td>
                    <td> {{ $episode->air_date }} </td>
                    <td> <a href="episode/{{ $episode->id }}" class="btn btn-color">See Detail</a> </td>
                </tr>
            @endforeach

        </tbody>
    </table>




</div>


<div class="container mt-3">
    <ul class="pagination">
        @if ($totalPages > 1 && request()->has('page') && request()->input('page') != 1)
            <li class="page-item">
                <a href="{{ route('episodes', ['page' => request()->input('page') - 1]) }}" class="page-link">Geri</a>
            </li>
        @endif



        @for ($i = $start; $i <= $end; $i++)
            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                <a href="{{ route('episodes', ['page' => $i]) }}" class="page-link">{{ $i }}</a>
            </li>
        @endfor

        @if ($end < $totalPages)
            <li class="page-item disabled">
                <span class="page-link">...</span>
            </li>
        @endif


        @if ($totalPages > 1 && request()->has('page') && request()->input('page') != $totalPages)
            <li class="page-item">
                <a href="{{ route('episodes', ['page' => request()->input('page') + 1]) }}" class="page-link">İleri</a>
            </li>
        @endif
    </ul>
</div>




@endsection
