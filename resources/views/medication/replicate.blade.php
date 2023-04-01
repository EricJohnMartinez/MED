@extends('layouts.admin')

@section('title', 'Add Daily Medication')
@section('content-header', 'Add Daily Medication')

@section('content')

    <div class="card">
        <div class="card-body">

            <form action="{{ route('medication.replicate') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Patient Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           id="name"
                           placeholder="Patient Name" value="{{ old('name',$medication->name) }}" readonly>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="medicine">Medicines & IV Fluids</label>
                    <input type="text" name="medicine" class="form-control @error('medicine') is-invalid @enderror"
                           id="medicine"
                           placeholder="Medicines & IV Fluids" value="{{ old('medicine',$medication->medicine) }}">
                    @error('medicine')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                 <div class="form-group">
                    <label for="requested">Requested(Quantity)</label>
                    <input type="text" name="requested" class="form-control @error('requested') is-invalid @enderror"
                        id="requested" placeholder="Requested" value="{{ old('requested',$medication->requested) }}">
                    @error('requested')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="dispensed">Dispensed(Quantity)</label>
                    <input type="text" name="dispensed" class="form-control @error('dispensed') is-invalid @enderror" id="dispensed"
                           placeholder="Dispensed" value="{{ old('dispensed',$medication->dispensed) }}">
                    @error('dispensed')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nurse">Nurse on Duty</label>
                    <input type="text" name="nurse" class="form-control @error('nurse') is-invalid @enderror"
                        id="nurse" placeholder="Nurse on Duty" value="{{ old('nurse',$medication->nurse) }}">
                    @error('nurse')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="pharmacist">Pharmacist on Duty</label>
                    <input type="text" name="pharmacist" class="form-control @error('pharmacist') is-invalid @enderror"
                        id="pharmacist" placeholder="pharmacist" value="{{ old('pharmacist',$medication->pharnacist) }}">
                    @error('pharmacist')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea type="text" name="remarks" class="form-control @error('remarks') is-invalid @enderror"
                        id="remarks" placeholder="Remarks" value="{{ old('remarks',$medication->remarks) }}"></textarea>
                    @error('remarks')
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
