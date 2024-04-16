@extends('main_master')
@section('content')
@section('title')
    Locations
@endsection



<div class="container mt-5">

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Type</th>
                <th scope="col">Dimension</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>

            @foreach ($locations as $location)
                <tr>
                    <th scope="row">{{ $location->id }}</th>
                    <td> {{ $location->name }}</td>
                    <td> {{ $location->type }}</td>
                    <td> {{ $location->dimension }} </td>
                    <td> <a href="location/{{ $location->id }}" class="btn btn-color">See Detail</a> </td>
                </tr>
            @endforeach

        </tbody>
    </table>




</div>



<div class="container mt-3">
    <ul class="pagination">
        @if ($totalPages > 1 && request()->has('page') && request()->input('page') != 1)
            <li class="page-item">
                <a href="{{ route('locations', ['page' => request()->input('page') - 1]) }}" class="page-link">Geri</a>
            </li>
        @endif



        @for ($i = $start; $i <= $end; $i++)
            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                <a href="{{ route('locations', ['page' => $i]) }}" class="page-link">{{ $i }}</a>
            </li>
        @endfor

        @if ($end < $totalPages)
            <li class="page-item disabled">
                <span class="page-link">...</span>
            </li>
        @endif


        @if ($totalPages > 1 && request()->has('page') && request()->input('page') != $totalPages)
            <li class="page-item">
                <a href="{{ route('locations', ['page' => request()->input('page') + 1]) }}" class="page-link">İleri</a>
            </li>
        @endif
    </ul>
</div>


@endsection
