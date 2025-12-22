@extends('layouts.index')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Welcome to Aperturely Dashboard</h4>
                <p class="card-text">You are logged in!
                    your role is: {{ Auth::user()->role }}
                </p>
            </div>
        </div>
    </div>
</div>  
@endsection