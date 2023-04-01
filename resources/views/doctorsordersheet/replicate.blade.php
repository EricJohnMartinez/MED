@extends('layouts.admin')

@section('title', 'Doctors Order')
@section('content-header', 'Doctors Order')

@section('content')

    <div class="card">
        <div class="card-body">

            <form action="{{ route('doctorsordersheet.replicate', $doctorsordersheet) }}" method="POST" enctype="multipart/form-data">
               
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Patient Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           id="name"
                           placeholder="Name" value="{{ old('name', $doctorsordersheet->name) }}" readonly>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="progress">Progress Notes</label>
                    <textarea type="text" name="progress" class="form-control @error('progress') is-invalid @enderror"
                           id="progress"
                           placeholder="" value="{{ old('progress', $doctorsordersheet->progress) }}"> </textarea>
                    @error('progress')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="doctorsorder">Doctor's Order</label>
                    <textarea type="text"" name="doctorsorder" class="form-control @error('doctorsorder') is-invalid @enderror" id="doctorsorder"
                           placeholder="" value="{{ old('doctorsorder', $doctorsordersheet->doctorsorder) }}"> </textarea>
                    @error('doctorsorder')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <button class="btn btn-success btn-block btn-lg" type="submit">Submit</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            bsCustomFileInput.init();
        });
    </script>
@endsection
