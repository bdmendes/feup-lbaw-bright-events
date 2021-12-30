@extends('layouts.app')

@section('title', 'home')

@section('content')
    <div class="homeBackground">
        <img src="https://bomdia.eu/wp-content/uploads/2015/08/estaline.jpg" height="500"> </img>
        <div class="backgroundSlogan">
            <span>Código ligeiro e compacto</span>
        </div>
    </div>

    <div class="homeContent">
        <div>
            Trending Events
            <div style="background-color: #000; opacity: 0.2; height:250px;width:100%;"></div>
            <!-- Summon trending events template here -->
            <div>
                <div>
                    Trending organizers
                    <div style="background-color: #000; opacity: 0.2; height:250px;width:100%;"></div>
                    <!-- Summon trending organizers template here -->
                </div>

            </div>
        </div>
    </div>
@endsection
