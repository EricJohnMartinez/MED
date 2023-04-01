@extends('layouts.admin')

@section('title', 'Restricted Medication')
@section('content-header', 'Restricted Medication')

@section('content')

    <div class="card">
        <div class="card-body">

            <form action="{{ route('restricted.replicate', $restricted) }}" method="POST" enctype="multipart/form-data">
               
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Patient Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           id="name"
                           placeholder="Name" value="{{ old('name', $restricted->name) }}" readonly>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="ward">Ward</label>
                    <input type="number" name="ward" class="form-control @error('ward') is-invalid @enderror"
                           id="ward"
                           placeholder="" value="{{ old('ward', $restricted->ward) }}">
                    @error('ward')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="drug">Name of Drugs</label>
                    <input type="text" name="drug" class="form-control @error('drug') is-invalid @enderror" id="drug"
                           placeholder="Email" value="{{ old('drug', $restricted->drug) }}">
                    @error('drug')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="dosege">Dosage / Frequency</label>
                    <input type="text" name="dosege" class="form-control @error('dosege') is-invalid @enderror" id="dosege"
                           placeholder="Room Number" value="{{ old('dosege', $restricted->dosege) }}">
                    @error('dosege')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="total">Total</label>
                    <input type="text" name="total" class="form-control @error('total') is-invalid @enderror" id="total"
                           placeholder="Contact Number" value="{{ old('total', $restricted->total) }}">
                    @error('total')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nurse">Nurse on Duty</label>
                    <input type="text" name="nurse" class="form-control @error('nurse') is-invalid @enderror"
                           id="nurse"
                           placeholder="nurse" value="{{ old('nurse', $restricted->nurse) }}">
                    @error('nurse')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="pharmacist">Pharmacist on Duty</label>
                    <input type="text" name="pharmacist" class="form-control @error('pharmacist') is-invalid @enderror"
                           id="pharmacist"
                           placeholder="pharmacist" value="{{ old('pharmacist', $restricted->pharmacist) }}">
                    @error('pharmacist')
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
