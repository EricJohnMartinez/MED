@extends('layouts.admin')

@section('title', 'Doctors Order Sheet')
@section('content-header', 'Doctors Order Sheet')
@section('content-actions')
    @if (Auth::user()->roles == 'nurse')
        <a href="{{ route('doctorsordersheet.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Add Doctor's Order</a>
    @endif
    @if (Auth::user()->roles == 'admin')
        <a href="{{ route('doctorsordersheet.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Add Doctor's Order</a>
    @endif
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')

    <div class="container-fluid m-0 p-0">
        <form action="{{ route('doctorsordersheet.index') }}" method="GET">
            <div class="d-flex w-100">
                <input value="{{ $query }}" class="form-control w-100" name="query" type="search" placeholder="Search" aria-label="Search">

                <input class="btn btn-outline-success" type="submit"Search/>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Date/Time</th>
                        <th>Name of Patients</th>
                        <th>Progress Notes</th>
                        <th>Doctor's Order</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($doctorsordersheet as $item)
                        <tr>
                            <td>{{ $item->updated_at }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->progress }}</td>
                            <td>{{ $item->doctorsorder }}</td>
                            <td>
                                <a href="{{ route('doctorsordersheet.editreplicate', $item->id) }}" class="btn btn-primary"><i
                                        class="fas fa-edit"></i></a>
                                <button class="btn btn-danger btn-delete"
                                    data-url="{{ route('doctorsordersheet.destroy', $item->id) }}"><i
                                        class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
         
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.btn-delete', function() {
                $this = $(this);
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "Do you really want to delete this customer?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        $.post($this.data('url'), {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        }, function(res) {
                            $this.closest('tr').fadeOut(500, function() {
                                $(this).remove();
                            })
                        })
                    }
                })
            })
        })
    </script>
@endsection
