@extends('layouts.admin')

@section('title', 'Add New Patient')
@section('content-header', 'Add New Patient')

@section('content')

    <div class="card">
        <div class="card-body">

            <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                           id="first_name"
                           placeholder="First Name" value="{{ old('first_name') }}">
                    @error('first_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                           id="last_name"
                           placeholder="Last Name" value="{{ old('last_name') }}">
                    @error('last_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                 <div class="form-group">
                    <label for="nickname">Nickname</label>
                    <input type="text" name="nickname" class="form-control @error('nickname') is-invalid @enderror"
                        id="nickname" placeholder="Nick Name" value="{{ old('nickname') }}">
                    @error('nickname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="doctor_name">Doctor's Name</label>
                    <input type="text" name="doctor_name" class="form-control @error('doctor_name') is-invalid @enderror"
                        id="doctor_name" placeholder="Name of Doctor" value="{{ old('doctor_name') }}">
                    @error('doctor_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name_of_nurse">Nurse on Duty</label>
                    <input type="text" name="name_of_nurse" class="form-control @error('name_of_nurse') is-invalid @enderror"
                        id="name_of_nurse" placeholder="Name of Nurse" value="{{ old('name_of_nurse') }}">
                    @error('name_of_nurse')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email"
                           placeholder="Email" value="{{ old('email') }}">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="date_of_birth">Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror"
                        id="date_of_birth" placeholder="Date of Birth" value="{{ old('date_of_birth') }}">
                    @error('date_of_birth')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="philhealth">Philhealth</label>
                    <input type="text" name="philhealth" class="form-control @error('philhealth') is-invalid @enderror"
                        id="philhealth" placeholder="Philhealth" value="{{ old('philhealth') }}">
                    @error('philhealth')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="sex" class="form-label">Sex</label>
                    <select name="sex" class="form-control @error('sex') is-invalid @enderror" aria-label="select example">
                <option selected disabled>Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Others">Others</option>
                </select>
                    @error('sex')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="height">Height</label>
                    <input type="text" name="height" class="form-control @error('height') is-invalid @enderror"
                        id="height" placeholder="Height" value="{{ old('height') }}">
                    @error('height')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="weight">Weight</label>
                    <input type="text" name="weight" class="form-control @error('weight') is-invalid @enderror"
                        id="weight" placeholder="Weight" value="{{ old('weight') }}">
                    @error('weight')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="marital_status">Marital Status</label>
                    <select name="marital_status" class="form-control @error('marital_status') is-invalid @enderror" aria-label="select example">
                <option selected disabled>Select</option>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Separated">Separated</option>
                <option value="Widowed">Widowed</option>
                <option value="Divorced">Divorced</option>
                </select>
                    @error('marital_status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="room_number">Room number</label>
                    <input type="text" name="room_number" class="form-control @error('room_number') is-invalid @enderror" id="room_number"
                           placeholder="Room Number" value="{{ old('room_number') }}">
                    @error('room_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Contact Number</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone"
                           placeholder="Contact Number" value="{{ old('phone') }}">
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                           id="address"
                           placeholder="Address" value="{{ old('address') }}">
                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="emergency">In case of emergency, who should be notified?</label>
                    <input type="text" name="emergency" class="form-control @error('emergency') is-invalid @enderror"
                        id="emergency" placeholder=" " value="{{ old('emergency') }}">
                    @error('emergency')
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
