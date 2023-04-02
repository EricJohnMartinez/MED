@extends('layouts.admin')

@section('title', 'Patient Info')

@section('content')
    <form action="{{ route('customers.update', $customer) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item "><a href="#info">Patient Info</a></li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-body">
                <h4 id="info" class="mb-2">Patient Info</h4>

                <div class="form-group">
                    <label for="doctor_name">Doctor's Name</label>
                    <input type="text" name="doctor_name" class="form-control @error('doctor_name') is-invalid @enderror"
                        id="doctor_name" placeholder="Name of Doctor" value="{{ old('doctor_name', $customer->doctor_name) }}">
                    @error('doctor_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name_of_nurse">Nurse on Duty</label>
                    <input type="text" name="name_of_nurse" class="form-control @error('name_of_nurse') is-invalid @enderror"
                        id="name_of_nurse" placeholder="Name of Nurse" value="{{ old('name_of_nurse', $customer->name_of_nurse) }}">
                    @error('name_of_nurse')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="room_number">Room number</label>
                    <input type="text" name="room_number" class="form-control @error('room_number') is-invalid @enderror" id="room_number"
                           placeholder="Room Number" value="{{ old('room_number', $customer->room_number) }}">
                    @error('room_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                           id="first_name"
                           placeholder="First Name" value="{{ old('first_name', $customer->first_name) }}"readonly>
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
                           placeholder="Last Name" value="{{ old('last_name' , $customer->last_name) }}"readonly>
                    @error('last_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                 <div class="form-group">
                    <label for="nickname">Nickname</label>
                    <input type="text" name="nickname" class="form-control @error('nickname') is-invalid @enderror"
                        id="nickname" placeholder="Nick Name" value="{{ old('nickname', $customer->nickname) }}"readonly>
                    @error('nickname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                


                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email"
                           placeholder="Email" value="{{ old('email', $customer->email) }}"readonly>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="date_of_birth">Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror"
                        id="date_of_birth" placeholder="Date of Birth" value="{{ old('date_of_birth', $customer->date_of_birth) }}"readonly>
                    @error('date_of_birth')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="philhealth">Philhealth</label>
                    <input type="text" name="philhealth" class="form-control @error('philhealth') is-invalid @enderror"
                        id="philhealth" placeholder="Philhealth" value="{{ old('philhealth', $customer->philhealth) }}"readonly>
                    @error('philhealth')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="sex">Sex</label>
                    <input type="text" name="sex" class="form-control @error('sex') is-invalid @enderror"
                        id="sex" placeholder="sex" value="{{ old('sex', $customer->sex) }}"readonly>
                    @error('sex')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="height">Height</label>
                    <input type="text" name="height" class="form-control @error('height') is-invalid @enderror"
                        id="height" placeholder="Height" value="{{ old('height', $customer->height) }}"readonly>
                    @error('height')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="weight">Weight</label>
                    <input type="text" name="weight" class="form-control @error('weight') is-invalid @enderror"
                        id="weight" placeholder="Weight" value="{{ old('weight', $customer->weight) }}"readonly>
                    @error('weight')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="marital_status">Marital Status</label>
                    <input type="text" name="marital_status" class="form-control @error('marital_status') is-invalid @enderror"
                        id="marital_status" placeholder="marital_status" value="{{ old('marital_status', $customer->marital_status) }}"readonly>
                    @error('marital_status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

             

                <div class="form-group">
                    <label for="phone">Contact Number</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone"
                           placeholder="Contact Number" value="{{ old('phone', $customer->phone) }}"readonly>
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
                           placeholder="Address" value="{{ old('address', $customer->address) }}"readonly>
                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="emergency">In case of emergency, who should be notified?</label>
                    <input type="text" name="emergency" class="form-control @error('emergency') is-invalid @enderror"
                        id="emergency" placeholder=" " value="{{ old('emergency', $customer->emergency) }}"readonly>
                    @error('emergency')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="is_discharged">Status</label>
                    <select name="is_discharged" class="form-control @error('is_discharged') is-invalid @enderror" id="is_discharged">
                        <option value="0" {{ old('is_discharged', $customer->is_discharged) === 0 ? 'selected' : '' }}>Active
                        </option>
                        <option value="1" {{ old('is_discharged', $customer->is_discharged) === 1 ? 'selected' : '' }}>Inactive
                        </option>
                    </select>
                    @error('is_discharged')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

        <button class="btn btn-success btn-block btn-lg" type="submit">Save Changes</button>
    </form>
@endsection

@section('js')
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            bsCustomFileInput.init();
        });
    </script>
@endsection